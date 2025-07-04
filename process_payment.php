<?php
require_once 'includes/db_connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tours.php');
    exit();
}

$booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
$payment_method_id = isset($_POST['payment_method']) ? (int)$_POST['payment_method'] : 0;

// Validate input
if (!$booking_id || !$payment_method_id) {
    $_SESSION['error'] = 'Invalid payment request';
    header('Location: payment.php?booking_id=' . $booking_id);
    exit();
}

try {
    // Get booking details
    $stmt = $pdo->prepare("
        SELECT b.*, t.title as tour_title
        FROM bookings b
        JOIN tours t ON b.tour_id = t.id
        WHERE b.id = ? AND b.user_id = ?
    ");
    $stmt->execute([$booking_id, $_SESSION['user_id']]);
    $booking = $stmt->fetch();

    if (!$booking) {
        throw new Exception('Booking not found');
    }

    // Get payment method details
    $stmt = $pdo->prepare("SELECT * FROM payment_methods WHERE id = ? AND is_active = 1");
    $stmt->execute([$payment_method_id]);
    $payment_method = $stmt->fetch();

    if (!$payment_method) {
        throw new Exception('Invalid payment method');
    }

    // Calculate processing fee
    $processing_fee = 0;
    if ($payment_method['processing_fee_type'] === 'percentage') {
        $processing_fee = $booking['total_price'] * ($payment_method['processing_fee'] / 100);
    } else {
        $processing_fee = $payment_method['processing_fee'];
    }
    $total_amount = $booking['total_price'] + $processing_fee;

    // Generate transaction ID
    $transaction_id = 'TXN' . date('YmdHis') . rand(1000, 9999);

    // Process payment based on method
    $payment_status = 'pending';
    $payment_data = [];

    switch ($payment_method['name']) {
        case 'Credit Card':
            // Validate credit card details
            $card_number = isset($_POST['card_number']) ? preg_replace('/\s+/', '', $_POST['card_number']) : '';
            $expiry = isset($_POST['expiry']) ? $_POST['expiry'] : '';
            $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';
            $card_holder = isset($_POST['card_holder']) ? trim($_POST['card_holder']) : '';
            $billing_address = isset($_POST['billing_address']) ? trim($_POST['billing_address']) : '';

            if (!$card_number || !$expiry || !$cvv || !$card_holder || !$billing_address) {
                throw new Exception('Please fill in all credit card details');
            }

            // Basic credit card validation
            if (!preg_match('/^\d{13,19}$/', $card_number)) {
                throw new Exception('Invalid card number');
            }

            if (!preg_match('/^\d{2}\/\d{2}$/', $expiry)) {
                throw new Exception('Invalid expiry date format (MM/YY)');
            }

            if (!preg_match('/^\d{3,4}$/', $cvv)) {
                throw new Exception('Invalid CVV');
            }

            // Simulate payment processing (in real implementation, integrate with payment gateway)
            $payment_status = 'completed';
            $payment_data = [
                'card_last4' => substr($card_number, -4),
                'card_type' => getCardType($card_number),
                'expiry' => $expiry,
                'card_holder' => $card_holder,
                'billing_address' => $billing_address
            ];
            break;

        case 'PayPal':
            // Simulate PayPal redirect (in real implementation, redirect to PayPal)
            $payment_status = 'processing';
            $payment_data = [
                'paypal_email' => 'customer@example.com',
                'redirect_url' => 'https://www.paypal.com/checkoutnow?token=' . $transaction_id
            ];
            break;

        case 'Bank Transfer':
            $transfer_reference = isset($_POST['transfer_reference']) ? trim($_POST['transfer_reference']) : '';
            if (!$transfer_reference) {
                throw new Exception('Please provide transfer reference number');
            }
            
            $payment_status = 'pending';
            $payment_data = [
                'transfer_reference' => $transfer_reference,
                'bank_details' => [
                    'bank' => 'Travel Agency Bank',
                    'account' => '1234567890',
                    'routing' => '987654321'
                ]
            ];
            break;

        case 'Digital Wallet':
            $payment_status = 'processing';
            $payment_data = [
                'wallet_type' => 'mobile',
                'device_info' => $_SERVER['HTTP_USER_AGENT']
            ];
            break;

        case 'Cash on Arrival':
            $payment_status = 'pending';
            $payment_data = [
                'payment_type' => 'cash_on_arrival',
                'instructions' => 'Please bring exact amount in cash on the day of your tour'
            ];
            break;

        default:
            throw new Exception('Unsupported payment method');
    }

    // Create payment record
    $stmt = $pdo->prepare("
        INSERT INTO payments (booking_id, payment_method_id, amount, processing_fee, total_amount, transaction_id, status, payment_data)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $booking_id,
        $payment_method_id,
        $booking['total_price'],
        $processing_fee,
        $total_amount,
        $transaction_id,
        $payment_status,
        json_encode($payment_data)
    ]);

    // Update booking status
    $new_booking_status = ($payment_status === 'completed') ? 'paid' : 'pending';
    $new_payment_status = ($payment_status === 'completed') ? 'completed' : 'pending';
    
    $stmt = $pdo->prepare("
        UPDATE bookings 
        SET status = ?, payment_status = ? 
        WHERE id = ?
    ");
    $stmt->execute([$new_booking_status, $new_payment_status, $booking_id]);

    // Redirect based on payment status
    if ($payment_status === 'completed') {
        $_SESSION['success'] = 'Payment completed successfully! Your booking is confirmed.';
        header('Location: thankyou.php');
    } elseif ($payment_status === 'processing') {
        $_SESSION['success'] = 'Payment is being processed. You will receive a confirmation shortly.';
        header('Location: thankyou.php');
    } else {
        $_SESSION['success'] = 'Payment request submitted. Please complete the payment as instructed.';
        header('Location: thankyou.php');
    }
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = 'Payment failed: ' . $e->getMessage();
    header('Location: payment.php?booking_id=' . $booking_id);
    exit();
}

// Helper function to determine card type
function getCardType($card_number) {
    $patterns = [
        'visa' => '/^4/',
        'mastercard' => '/^5[1-5]/',
        'amex' => '/^3[47]/',
        'discover' => '/^6(?:011|5)/'
    ];

    foreach ($patterns as $type => $pattern) {
        if (preg_match($pattern, $card_number)) {
            return ucfirst($type);
        }
    }
    
    return 'Unknown';
}
?> 