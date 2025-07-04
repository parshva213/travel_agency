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

$tour_id = isset($_POST['tour_id']) ? (int)$_POST['tour_id'] : 0;
$booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : '';
$number_of_people = isset($_POST['number_of_people']) ? (int)$_POST['number_of_people'] : 0;
$special_requests = isset($_POST['special_requests']) ? trim($_POST['special_requests']) : '';

// Validate input
if (!$tour_id || !$booking_date || !$number_of_people) {
    $_SESSION['error'] = 'Please fill in all required fields';
    header('Location: tour-details.php?id=' . $tour_id);
    exit();
}

try {
    // Get tour details
    $stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();

    if (!$tour) {
        throw new Exception('Tour not found');
    }

    // Calculate total price
    $price_per_person = $tour['price'] * (1 - $tour['discount']/100);
    $total_price = $price_per_person * $number_of_people;

    // Create booking
    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, tour_id, booking_date, number_of_people, total_price, special_requests) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_SESSION['user_id'],
        $tour_id,
        $booking_date,
        $number_of_people,
        $total_price,
        $special_requests
    ]);

    // Get the booking ID
    $booking_id = $pdo->lastInsertId();

    // Redirect to payment page
    header('Location: payment.php?booking_id=' . $booking_id);
    exit();

} catch (Exception $e) {
    $_SESSION['error'] = 'Booking failed: ' . $e->getMessage();
    header('Location: tour-details.php?id=' . $tour_id);
    exit();
}
?> 