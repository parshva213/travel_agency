<?php
$page_title = "Refund Policy";
include 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 data-aos="fade-up">Refund Policy</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">Understanding our cancellation and refund procedures</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="header-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <h3><i class="fas fa-undo-alt text-primary"></i></h3>
                        <p>Refund Process</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Content -->
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
                            <p class="text-muted">This policy outlines our cancellation and refund procedures for all travel bookings.</p>
                        </div>

                        <!-- General Refund Policy -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                            <h4 class="text-primary mb-3">1. General Refund Policy</h4>
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle me-2"></i>Important Notice</h5>
                                <p class="mb-0">All refunds are processed within 7-14 business days from the date of cancellation approval. Processing fees may apply.</p>
                            </div>
                            <p>We understand that travel plans can change unexpectedly. Our refund policy is designed to be fair and transparent while protecting both our customers and service providers.</p>
                        </div>

                        <!-- Cancellation Timeline -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                            <h4 class="text-primary mb-3">2. Cancellation Timeline and Refunds</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Time Before Departure</th>
                                            <th>Refund Amount</th>
                                            <th>Processing Time</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>30+ days</strong></td>
                                            <td><span class="badge bg-success">100%</span></td>
                                            <td>7-10 business days</td>
                                            <td>Minus processing fees ($25-50)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>15-29 days</strong></td>
                                            <td><span class="badge bg-warning">75%</span></td>
                                            <td>10-14 business days</td>
                                            <td>Service provider fees may apply</td>
                                        </tr>
                                        <tr>
                                            <td><strong>8-14 days</strong></td>
                                            <td><span class="badge bg-warning">50%</span></td>
                                            <td>10-14 business days</td>
                                            <td>Subject to provider policies</td>
                                        </tr>
                                        <tr>
                                            <td><strong>7 days or less</strong></td>
                                            <td><span class="badge bg-danger">No Refund</span></td>
                                            <td>N/A</td>
                                            <td>Emergency exceptions may apply</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Processing Fees -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="300">
                            <h4 class="text-primary mb-3">3. Processing Fees</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Standard Fees</h5>
                                    <ul>
                                        <li><strong>Booking Processing:</strong> $25 per booking</li>
                                        <li><strong>Payment Gateway:</strong> 2.5% of refund amount</li>
                                        <li><strong>Bank Transfer:</strong> $15 per transfer</li>
                                        <li><strong>International Transfer:</strong> $25 per transfer</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Service Provider Fees</h5>
                                    <ul>
                                        <li><strong>Hotels:</strong> Varies by property</li>
                                        <li><strong>Airlines:</strong> Based on fare rules</li>
                                        <li><strong>Tour Operators:</strong> 10-25% of tour cost</li>
                                        <li><strong>Insurance:</strong> Non-refundable</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Methods -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="400">
                            <h4 class="text-primary mb-3">4. Refund Methods</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-credit-card text-primary fa-2x mb-3"></i>
                                            <h5>Original Payment Method</h5>
                                            <p>Refunds are processed back to the original payment method used for booking.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-university text-primary fa-2x mb-3"></i>
                                            <h5>Bank Transfer</h5>
                                            <p>For bank transfers, additional fees may apply. Processing time: 5-7 business days.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-gift text-primary fa-2x mb-3"></i>
                                            <h5>Travel Credit</h5>
                                            <p>Opt for travel credit instead of refund. Valid for 12 months with no processing fees.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Special Circumstances -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="500">
                            <h4 class="text-primary mb-3">5. Special Circumstances</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Force Majeure Events</h5>
                                    <div class="alert alert-success">
                                        <h6><i class="fas fa-check-circle me-2"></i>Full Refund Available</h6>
                                        <ul class="mb-0">
                                            <li>Natural disasters</li>
                                            <li>Government travel restrictions</li>
                                            <li>Pandemics and health emergencies</li>
                                            <li>War or civil unrest</li>
                                            <li>Transportation strikes</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Medical Emergencies</h5>
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-heartbeat me-2"></i>Documentation Required</h6>
                                        <ul class="mb-0">
                                            <li>Medical certificate from doctor</li>
                                            <li>Hospital admission records</li>
                                            <li>Insurance claim documentation</li>
                                            <li>Death certificate (if applicable)</li>
                                            <li>Travel insurance coverage</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Non-Refundable Items -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="600">
                            <h4 class="text-primary mb-3">6. Non-Refundable Items</h4>
                            <div class="alert alert-warning">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i>These items are typically non-refundable:</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li><strong>Travel Insurance:</strong> Once purchased, insurance premiums are non-refundable</li>
                                        <li><strong>Processing Fees:</strong> Administrative fees are non-refundable</li>
                                        <li><strong>Special Requests:</strong> Custom arrangements and special services</li>
                                        <li><strong>Last-Minute Bookings:</strong> Bookings made within 7 days of departure</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li><strong>Group Bookings:</strong> Special terms apply for group reservations</li>
                                        <li><strong>Peak Season:</strong> Higher cancellation fees during peak periods</li>
                                        <li><strong>Promotional Rates:</strong> Discounted rates may have stricter terms</li>
                                        <li><strong>Third-Party Services:</strong> Subject to provider policies</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- How to Request a Refund -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="700">
                            <h4 class="text-primary mb-3">7. How to Request a Refund</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Online Process</h5>
                                    <ol>
                                        <li>Log into your account</li>
                                        <li>Go to "My Bookings"</li>
                                        <li>Select the booking to cancel</li>
                                        <li>Choose cancellation reason</li>
                                        <li>Submit refund request</li>
                                        <li>Receive confirmation email</li>
                                    </ol>
                                </div>
                                <div class="col-md-6">
                                    <h5>Contact Support</h5>
                                    <ul>
                                        <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                                        <li><strong>Email:</strong> refunds@travelagency.com</li>
                                        <li><strong>Live Chat:</strong> Available 24/7</li>
                                        <li><strong>Response Time:</strong> Within 24 hours</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Timeline -->
                        <div class="mb-5" data-aos="fade-up" data-aos-delay="800">
                            <h4 class="text-primary mb-3">8. Refund Timeline</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <span class="fw-bold">1</span>
                                        </div>
                                        <h6 class="mt-2">Request Submitted</h6>
                                        <small>Immediate confirmation</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <span class="fw-bold">2</span>
                                        </div>
                                        <h6 class="mt-2">Review Process</h6>
                                        <small>1-2 business days</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <span class="fw-bold">3</span>
                                        </div>
                                        <h6 class="mt-2">Approval & Processing</h6>
                                        <small>3-5 business days</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <span class="fw-bold">4</span>
                                        </div>
                                        <h6 class="mt-2">Refund Issued</h6>
                                        <small>7-14 business days</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="900">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h4 class="text-primary mb-3">
                                        <i class="fas fa-headset me-2"></i>Need Help with Refunds?
                                    </h4>
                                    <p class="mb-4">Our customer support team is here to help you with any refund-related questions.</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5>Phone Support</h5>
                                            <p>+1 (555) 123-4567</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Email Support</h5>
                                            <p>refunds@travelagency.com</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Live Chat</h5>
                                            <p>Available 24/7</p>
                                        </div>
                                    </div>
                                    <a href="contact.php" class="btn btn-primary">
                                        <i class="fas fa-envelope me-2"></i>Contact Support
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