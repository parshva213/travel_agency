<?php
$page_title = "Terms & Conditions";
include 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 data-aos="fade-up">Terms & Conditions</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">Please read these terms carefully before using our services</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="header-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <h3><i class="fas fa-file-contract text-primary"></i></h3>
                        <p>Legal Terms</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4" data-aos="fade-up">
                            <h3 class="text-primary mb-3">
                                <i class="fas fa-calendar-alt me-2"></i>Last Updated: <?php echo date('F d, Y'); ?>
                            </h3>
                            <p class="text-muted">These Terms and Conditions govern your use of our travel services and website.</p>
                        </div>

                        <!-- Acceptance of Terms -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                            <h4 class="text-primary mb-3">1. Acceptance of Terms</h4>
                            <p>By accessing and using our website and services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                        </div>

                        <!-- Service Description -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                            <h4 class="text-primary mb-3">2. Service Description</h4>
                            <p>We provide travel booking services including but not limited to:</p>
                            <ul>
                                <li>Tour package bookings</li>
                                <li>Hotel reservations</li>
                                <li>Transportation arrangements</li>
                                <li>Travel insurance</li>
                                <li>Travel consultation services</li>
                            </ul>
                        </div>

                        <!-- Booking and Payment -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="300">
                            <h4 class="text-primary mb-3">3. Booking and Payment Terms</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Booking Process</h5>
                                    <ul>
                                        <li>All bookings are subject to availability</li>
                                        <li>Confirmation is provided via email</li>
                                        <li>Full payment may be required at booking</li>
                                        <li>Payment plans available for select packages</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Payment Methods</h5>
                                    <ul>
                                        <li>Credit/Debit cards</li>
                                        <li>Bank transfers</li>
                                        <li>Digital wallets</li>
                                        <li>Payment plans (where applicable)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Cancellation and Refunds -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="400">
                            <h4 class="text-primary mb-3">4. Cancellation and Refund Policy</h4>
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle me-2"></i>Cancellation Timeline</h5>
                                <ul class="mb-0">
                                    <li><strong>30+ days before departure:</strong> Full refund minus processing fees</li>
                                    <li><strong>15-29 days before departure:</strong> 75% refund</li>
                                    <li><strong>8-14 days before departure:</strong> 50% refund</li>
                                    <li><strong>7 days or less:</strong> No refund</li>
                                </ul>
                            </div>
                            <p>For detailed information, please refer to our <a href="refund-policy.php">Refund Policy</a>.</p>
                        </div>

                        <!-- Travel Documents and Requirements -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="500">
                            <h4 class="text-primary mb-3">5. Travel Documents and Requirements</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Customer Responsibilities</h5>
                                    <ul>
                                        <li>Valid passport with 6+ months validity</li>
                                        <li>Required visas and permits</li>
                                        <li>Travel insurance (recommended)</li>
                                        <li>Health certificates if required</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Our Responsibilities</h5>
                                    <ul>
                                        <li>Provide accurate travel information</li>
                                        <li>Assist with documentation requirements</li>
                                        <li>Notify of any changes in requirements</li>
                                        <li>Provide emergency support</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Health and Safety -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="600">
                            <h4 class="text-primary mb-3">6. Health and Safety</h4>
                            <div class="alert alert-warning">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i>Important Health Information</h5>
                                <p class="mb-0">Travelers are responsible for ensuring they are medically fit to travel. We recommend consulting with healthcare providers before international travel.</p>
                            </div>
                            <ul>
                                <li>Follow local health guidelines and regulations</li>
                                <li>Carry necessary medications and prescriptions</li>
                                <li>Inform us of any special medical requirements</li>
                                <li>Purchase appropriate travel insurance</li>
                            </ul>
                        </div>

                        <!-- Liability and Insurance -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="700">
                            <h4 class="text-primary mb-3">7. Liability and Insurance</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Our Liability</h5>
                                    <ul>
                                        <li>Limited to the cost of the tour package</li>
                                        <li>Excludes personal injury or property damage</li>
                                        <li>Subject to force majeure events</li>
                                        <li>Limited liability for third-party services</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Travel Insurance</h5>
                                    <ul>
                                        <li>Strongly recommended for all travelers</li>
                                        <li>Covers medical emergencies</li>
                                        <li>Protects against trip cancellation</li>
                                        <li>Provides luggage and personal effects coverage</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy and Data Protection -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="800">
                            <h4 class="text-primary mb-3">8. Privacy and Data Protection</h4>
                            <p>We are committed to protecting your privacy. Your personal information is collected, used, and protected in accordance with our <a href="privacy-policy.php">Privacy Policy</a>.</p>
                            <ul>
                                <li>Personal data is used only for booking purposes</li>
                                <li>Information is shared only with necessary service providers</li>
                                <li>You have the right to access and update your information</li>
                                <li>Data is stored securely and encrypted</li>
                            </ul>
                        </div>

                        <!-- Force Majeure -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="900">
                            <h4 class="text-primary mb-3">9. Force Majeure</h4>
                            <p>We are not liable for any failure to perform our obligations due to circumstances beyond our reasonable control, including but not limited to:</p>
                            <ul>
                                <li>Natural disasters and weather events</li>
                                <li>Government actions and travel restrictions</li>
                                <li>War, civil unrest, or terrorism</li>
                                <li>Pandemics and health emergencies</li>
                                <li>Transportation strikes or delays</li>
                            </ul>
                        </div>

                        <!-- Dispute Resolution -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="1000">
                            <h4 class="text-primary mb-3">10. Dispute Resolution</h4>
                            <p>Any disputes arising from these terms or our services will be resolved through:</p>
                            <ol>
                                <li>Direct communication and negotiation</li>
                                <li>Mediation if required</li>
                                <li>Legal proceedings in our jurisdiction</li>
                            </ol>
                        </div>

                        <!-- Contact Information -->
                        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="1100">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-question-circle me-2"></i>Questions About These Terms?
                                    </h4>
                                    <p class="mb-4">If you have any questions about these Terms & Conditions, please contact us.</p>
                                    <a href="contact.php" class="btn btn-primary">
                                        <i class="fas fa-envelope me-2"></i>Contact Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>