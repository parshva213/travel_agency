<?php
$page_title = "Help Center";
include 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 data-aos="fade-up">Help Center</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">Find answers to your questions and get the support you need</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="header-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <h3><i class="fas fa-headset text-primary"></i></h3>
                        <p>24/7 Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h3 class="text-primary mb-3">How can we help you today?</h3>
                    <p class="text-muted">Search our knowledge base or browse popular topics</p>
                </div>
                
                <!-- Search Bar -->
                <div class="search-filter mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="helpSearch" placeholder="Search for help articles, FAQs, or topics...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-md-3">
                        <div class="quick-category-card text-center">
                            <i class="fas fa-calendar-check text-primary fa-2x mb-3"></i>
                            <h6>Booking Help</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="quick-category-card text-center">
                            <i class="fas fa-undo-alt text-primary fa-2x mb-3"></i>
                            <h6>Cancellations</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="quick-category-card text-center">
                            <i class="fas fa-passport text-primary fa-2x mb-3"></i>
                            <h6>Travel Documents</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="quick-category-card text-center">
                            <i class="fas fa-credit-card text-primary fa-2x mb-3"></i>
                            <h6>Payment Issues</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Help Categories -->
<section class="py-5">
    <div class="container">
        <!-- Popular Topics -->
        <div class="mb-5" data-aos="fade-up">
            <h3 class="text-primary mb-4">
                <i class="fas fa-fire me-2"></i>Popular Topics
            </h3>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-calendar-plus me-2"></i>How to Book a Tour
                            </h5>
                            <p class="card-text">Step-by-step guide to booking your dream vacation with us.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-times-circle me-2"></i>Cancelling Your Booking
                            </h5>
                            <p class="card-text">Learn about our cancellation policy and how to cancel your booking.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-credit-card me-2"></i>Payment Methods
                            </h5>
                            <p class="card-text">Accepted payment methods and how to pay for your booking.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-shield-alt me-2"></i>Travel Insurance
                            </h5>
                            <p class="card-text">Understanding travel insurance coverage and how to claim.</p>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Categories -->
        <div class="row g-5">
            <!-- Booking & Reservations -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i>Booking & Reservations
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>How to make a booking
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Modifying your booking
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Group bookings
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Booking confirmation
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Payment plans
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Cancellations & Refunds -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-undo-alt me-2"></i>Cancellations & Refunds
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Cancellation policy
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>How to cancel a booking
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Refund process
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Refund timeline
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Force majeure events
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Travel Documents -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-passport me-2"></i>Travel Documents
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Passport requirements
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Visa information
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Health certificates
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Travel insurance
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Document checklist
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment & Billing -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>Payment & Billing
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Accepted payment methods
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Payment security
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Billing issues
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Payment plans
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-chevron-right text-primary me-2"></i>Receipts and invoices
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="card bg-primary text-white" data-aos="fade-up" data-aos-delay="500">
                    <div class="card-body text-center">
                        <h3 class="mb-4">
                            <i class="fas fa-headset me-2"></i>Still Need Help?
                        </h3>
                        <p class="mb-4">Our customer support team is available 24/7 to assist you with any questions or concerns.</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <i class="fas fa-phone fa-2x mb-2"></i>
                                    <h5>Phone Support</h5>
                                    <p>+1 (555) 123-4567</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <i class="fas fa-envelope fa-2x mb-2"></i>
                                    <h5>Email Support</h5>
                                    <p>support@travelagency.com</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <i class="fas fa-comments fa-2x mb-2"></i>
                                    <h5>Live Chat</h5>
                                    <p>Available 24/7</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="contact.php" class="btn btn-light btn-lg me-3">
                                <i class="fas fa-envelope me-2"></i>Contact Us
                            </a>
                            <a href="faq.php" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-question-circle me-2"></i>View FAQ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Resources -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <h3 class="text-primary mb-4" data-aos="fade-up">
                    <i class="fas fa-book me-2"></i>Additional Resources
                </h3>
                <div class="row g-4">
                    <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-file-contract text-primary fa-2x mb-3"></i>
                                <h5>Terms & Conditions</h5>
                                <p class="text-muted">Read our terms of service</p>
                                <a href="terms-conditions.php" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-shield-alt text-primary fa-2x mb-3"></i>
                                <h5>Privacy Policy</h5>
                                <p class="text-muted">How we protect your data</p>
                                <a href="privacy-policy.php" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-undo-alt text-primary fa-2x mb-3"></i>
                                <h5>Refund Policy</h5>
                                <p class="text-muted">Cancellation and refund terms</p>
                                <a href="refund-policy.php" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <i class="fas fa-question-circle text-primary fa-2x mb-3"></i>
                                <h5>FAQ</h5>
                                <p class="text-muted">Frequently asked questions</p>
                                <a href="faq.php" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for Search Functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('helpSearch');
    const searchButton = searchInput.nextElementSibling;
    
    // Search functionality
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        if (searchTerm) {
            // You can implement actual search functionality here
            alert('Searching for: ' + searchTerm + '\nThis would search through help articles and FAQs.');
        }
    }
    
    // Search on button click
    searchButton.addEventListener('click', performSearch);
    
    // Search on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // Quick category cards click handlers
    const quickCards = document.querySelectorAll('.quick-category-card');
    quickCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.querySelector('h6').textContent;
            searchInput.value = category;
            performSearch();
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?> 