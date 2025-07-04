<?php
session_start();

if (!isset($_SESSION['success']) && !isset($_SESSION['booking_success'])) {
    header('Location: index.php');
    exit();
}

// Get the success message
$success_message = '';
if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
} elseif (isset($_SESSION['booking_success'])) {
    $success_message = 'Your tour booking has been successfully processed. We will contact you shortly with more details about your trip.';
    unset($_SESSION['booking_success']);
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-5">
                    <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
                    <h2 class="card-title text-success mb-3">Thank You!</h2>
                    <p class="card-text fs-5 mb-4"><?php echo htmlspecialchars($success_message); ?></p>
                    
                    <div class="alert alert-info mb-4">
                        <h6><i class="fas fa-info-circle me-2"></i>What's Next?</h6>
                        <ul class="text-start mb-0">
                            <li>You will receive a confirmation email shortly</li>
                            <li>Our team will contact you within 24 hours</li>
                            <li>Please check your email for detailed itinerary</li>
                            <li>Keep your booking reference number handy</li>
                        </ul>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <i class="fas fa-envelope text-primary fa-2x mb-2"></i>
                                    <h6>Email Confirmation</h6>
                                    <p class="small text-muted mb-0">Check your inbox for booking details</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <i class="fas fa-phone text-primary fa-2x mb-2"></i>
                                    <h6>24/7 Support</h6>
                                    <p class="small text-muted mb-0">Call us anytime for assistance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="tours.php" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>Browse More Tours
                        </a>
                        <a href="index.php" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Return to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 