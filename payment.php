<?php
require_once 'includes/db_connect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if booking_id is provided
if (!isset($_GET['booking_id'])) {
    header('Location: tours.php');
    exit();
}

$booking_id = (int)$_GET['booking_id'];

try {
    // Get booking details with tour and user information
    $stmt = $pdo->prepare("
        SELECT b.*, t.title as tour_title, t.image as tour_image, 
               u.first_name, u.last_name, u.email, u.phone
        FROM bookings b
        JOIN tours t ON b.tour_id = t.id
        JOIN users u ON b.user_id = u.id
        WHERE b.id = ? AND b.user_id = ?
    ");
    $stmt->execute([$booking_id, $_SESSION['user_id']]);
    $booking = $stmt->fetch();

    if (!$booking) {
        throw new Exception('Booking not found');
    }

    // Get available payment methods
    $stmt = $pdo->prepare("SELECT * FROM payment_methods WHERE is_active = 1 ORDER BY id");
    $stmt->execute();
    $payment_methods = $stmt->fetchAll();

    // Check if payment already exists
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE booking_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$booking_id]);
    $existing_payment = $stmt->fetch();

} catch (Exception $e) {
    $_SESSION['error'] = 'Error loading payment page: ' . $e->getMessage();
    header('Location: tours.php');
    exit();
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Payment Information
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Booking Summary -->
                    <div class="booking-summary mb-4">
                        <h5 class="text-primary mb-3">Booking Summary</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <img src="<?php echo htmlspecialchars($booking['tour_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($booking['tour_title']); ?>" 
                                     class="img-fluid rounded">
                            </div>
                            <div class="col-md-9">
                                <h6><?php echo htmlspecialchars($booking['tour_title']); ?></h6>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo date('F j, Y', strtotime($booking['booking_date'])); ?>
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-users me-1"></i>
                                    <?php echo $booking['number_of_people']; ?> 
                                    <?php echo $booking['number_of_people'] === 1 ? 'Person' : 'People'; ?>
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    Total: $<?php echo number_format($booking['total_price'], 2); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php if ($existing_payment && $existing_payment['status'] === 'completed'): ?>
                        <!-- Payment Already Completed -->
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h5 class="text-success">Payment Completed!</h5>
                            <p class="text-muted">Your payment has been successfully processed.</p>
                            <p class="text-muted">Transaction ID: <?php echo htmlspecialchars($existing_payment['transaction_id']); ?></p>
                            <a href="thankyou.php" class="btn btn-primary">Continue</a>
                        </div>
                    <?php else: ?>
                        <!-- Payment Methods -->
                        <form method="POST" action="process_payment.php" id="paymentForm">
                            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                            
                            <h5 class="text-primary mb-3">Select Payment Method</h5>
                            
                            <div class="payment-methods mb-4">
                                <?php foreach ($payment_methods as $method): ?>
                                    <?php
                                    $processing_fee = 0;
                                    if ($method['processing_fee_type'] === 'percentage') {
                                        $processing_fee = $booking['total_price'] * ($method['processing_fee'] / 100);
                                    } else {
                                        $processing_fee = $method['processing_fee'];
                                    }
                                    $total_with_fee = $booking['total_price'] + $processing_fee;
                                    ?>
                                    
                                    <div class="payment-method-option mb-3">
                                        <input type="radio" class="btn-check" name="payment_method" 
                                               id="method_<?php echo $method['id']; ?>" 
                                               value="<?php echo $method['id']; ?>" required>
                                        <label class="btn btn-outline-primary w-100 text-start" 
                                               for="method_<?php echo $method['id']; ?>">
                                            <div class="d-flex align-items-center">
                                                <i class="<?php echo htmlspecialchars($method['icon']); ?> fa-2x me-3"></i>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($method['name']); ?></h6>
                                                    <p class="text-muted mb-0 small"><?php echo htmlspecialchars($method['description']); ?></p>
                                                </div>
                                                <div class="text-end">
                                                    <?php if ($processing_fee > 0): ?>
                                                        <small class="text-muted">Fee: $<?php echo number_format($processing_fee, 2); ?></small><br>
                                                    <?php endif; ?>
                                                    <strong>$<?php echo number_format($total_with_fee, 2); ?></strong>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Payment Details (shown based on selected method) -->
                            <div id="paymentDetails" class="mb-4" style="display: none;">
                                <h5 class="text-primary mb-3">Payment Details</h5>
                                
                                <!-- Credit Card Form -->
                                <div id="creditCardForm" class="payment-form" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="card_number" class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="card_number" name="card_number" 
                                                   placeholder="1234 5678 9012 3456" maxlength="19">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="expiry" class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" id="expiry" name="expiry" 
                                                   placeholder="MM/YY" maxlength="5">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cvv" name="cvv" 
                                                   placeholder="123" maxlength="4">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="card_holder" class="form-label">Card Holder Name</label>
                                            <input type="text" class="form-control" id="card_holder" name="card_holder" 
                                                   placeholder="John Doe">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="billing_address" class="form-label">Billing Address</label>
                                            <input type="text" class="form-control" id="billing_address" name="billing_address" 
                                                   placeholder="123 Main St, City, Country">
                                        </div>
                                    </div>
                                </div>

                                <!-- PayPal Form -->
                                <div id="paypalForm" class="payment-form" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fab fa-paypal me-2"></i>
                                        You will be redirected to PayPal to complete your payment securely.
                                    </div>
                                </div>

                                <!-- Bank Transfer Form -->
                                <div id="bankTransferForm" class="payment-form" style="display: none;">
                                    <div class="alert alert-warning">
                                        <h6>Bank Transfer Details:</h6>
                                        <p class="mb-1"><strong>Bank:</strong> Travel Agency Bank</p>
                                        <p class="mb-1"><strong>Account Number:</strong> 1234567890</p>
                                        <p class="mb-1"><strong>Routing Number:</strong> 987654321</p>
                                        <p class="mb-1"><strong>Reference:</strong> Booking #<?php echo $booking_id; ?></p>
                                        <p class="mb-0"><strong>Amount:</strong> $<?php echo number_format($booking['total_price'], 2); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transfer_reference" class="form-label">Transfer Reference Number</label>
                                        <input type="text" class="form-control" id="transfer_reference" name="transfer_reference" 
                                               placeholder="Enter your bank transfer reference">
                                    </div>
                                </div>

                                <!-- Digital Wallet Form -->
                                <div id="digitalWalletForm" class="payment-form" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-mobile-alt me-2"></i>
                                        Please use your mobile device to complete the payment with Apple Pay or Google Pay.
                                    </div>
                                </div>

                                <!-- Cash on Arrival Form -->
                                <div id="cashForm" class="payment-form" style="display: none;">
                                    <div class="alert alert-success">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        No payment required now. You can pay in cash when you arrive for your tour.
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="terms-conditions.php" target="_blank">Terms and Conditions</a> 
                                    and <a href="privacy-policy.php" target="_blank">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100" id="submitPayment">
                                <i class="fas fa-lock me-2"></i>Complete Payment
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Payment Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Payment Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tour Price:</span>
                        <span>$<?php echo number_format($booking['total_price'], 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" id="processingFee">
                        <span>Processing Fee:</span>
                        <span>$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="totalAmount">$<?php echo number_format($booking['total_price'], 2); ?></strong>
                    </div>
                    
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i>
                        All payments are processed securely. Your payment information is encrypted and protected.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentDetails = document.getElementById('paymentDetails');
    const paymentForms = document.querySelectorAll('.payment-form');
    const processingFeeElement = document.getElementById('processingFee');
    const totalAmountElement = document.getElementById('totalAmount');
    
    const baseAmount = <?php echo $booking['total_price']; ?>;
    const paymentMethodsData = <?php echo json_encode($payment_methods); ?>;

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const methodId = this.value;
            const selectedMethod = paymentMethodsData.find(m => m.id == methodId);
            
            // Show payment details
            paymentDetails.style.display = 'block';
            
            // Hide all payment forms
            paymentForms.forEach(form => form.style.display = 'none');
            
            // Show relevant form
            if (selectedMethod.name === 'Credit Card') {
                document.getElementById('creditCardForm').style.display = 'block';
            } else if (selectedMethod.name === 'PayPal') {
                document.getElementById('paypalForm').style.display = 'block';
            } else if (selectedMethod.name === 'Bank Transfer') {
                document.getElementById('bankTransferForm').style.display = 'block';
            } else if (selectedMethod.name === 'Digital Wallet') {
                document.getElementById('digitalWalletForm').style.display = 'block';
            } else if (selectedMethod.name === 'Cash on Arrival') {
                document.getElementById('cashForm').style.display = 'block';
            }
            
            // Update processing fee and total
            let processingFee = 0;
            if (selectedMethod.processing_fee_type === 'percentage') {
                processingFee = baseAmount * (selectedMethod.processing_fee / 100);
            } else {
                processingFee = parseFloat(selectedMethod.processing_fee);
            }
            
            const total = baseAmount + processingFee;
            
            processingFeeElement.innerHTML = `
                <span>Processing Fee:</span>
                <span>$${processingFee.toFixed(2)}</span>
            `;
            
            totalAmountElement.textContent = `$${total.toFixed(2)}`;
        });
    });

    // Card number formatting
    const cardNumber = document.getElementById('card_number');
    if (cardNumber) {
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }

    // Expiry date formatting
    const expiry = document.getElementById('expiry');
    if (expiry) {
        expiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }

    // CVV validation
    const cvv = document.getElementById('cvv');
    if (cvv) {
        cvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?> 