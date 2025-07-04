<?php
$page_title = "FAQ";
include 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 data-aos="fade-up">Frequently Asked Questions</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">Find answers to common questions about our travel services</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="header-stats">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <h3><i class="fas fa-question-circle text-primary"></i></h3>
                        <p>Quick Answers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Booking & Reservations -->
                <div class="mb-5" data-aos="fade-up">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-calendar-check me-2"></i>Booking & Reservations
                    </h3>
                    <div class="accordion" id="bookingAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="booking1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    How far in advance should I book my tour?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="booking1" data-bs-parent="#bookingAccordion">
                                <div class="accordion-body">
                                    We recommend booking at least 2-3 months in advance for popular destinations and peak seasons. For international tours, 4-6 months advance booking is ideal to secure the best rates and availability.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="booking2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    Can I modify or cancel my booking?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="booking2" data-bs-parent="#bookingAccordion">
                                <div class="accordion-body">
                                    Yes, you can modify or cancel your booking up to 30 days before departure. Cancellation fees may apply based on the tour package and timing. Please refer to our <a href="refund-policy.php">Refund Policy</a> for detailed information.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="booking3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    What payment methods do you accept?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="booking3" data-bs-parent="#bookingAccordion">
                                <div class="accordion-body">
                                    We accept all major credit cards (Visa, MasterCard, American Express), debit cards, bank transfers, and digital wallets like PayPal. Payment plans are available for select tour packages.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Travel & Documentation -->
                <div class="mb-5" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-passport me-2"></i>Travel & Documentation
                    </h3>
                    <div class="accordion" id="travelAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="travel1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                    What documents do I need for international travel?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse show" aria-labelledby="travel1" data-bs-parent="#travelAccordion">
                                <div class="accordion-body">
                                    You'll need a valid passport (with at least 6 months validity), visa (if required), travel insurance, and any specific health documents like vaccination certificates. We'll provide detailed requirements for your specific destination.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="travel2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    Do you provide travel insurance?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="travel2" data-bs-parent="#travelAccordion">
                                <div class="accordion-body">
                                    Yes, we offer comprehensive travel insurance packages that cover medical emergencies, trip cancellation, lost luggage, and more. Insurance can be added to your booking for additional protection.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="travel3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    What if I have dietary restrictions?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="travel3" data-bs-parent="#travelAccordion">
                                <div class="accordion-body">
                                    We accommodate various dietary requirements including vegetarian, vegan, gluten-free, and religious dietary restrictions. Please inform us at the time of booking so we can make appropriate arrangements.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tour & Accommodation -->
                <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-hotel me-2"></i>Tour & Accommodation
                    </h3>
                    <div class="accordion" id="tourAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="tour1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                                    What's included in the tour price?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse show" aria-labelledby="tour1" data-bs-parent="#tourAccordion">
                                <div class="accordion-body">
                                    Our tour prices typically include accommodation, transportation, guided tours, some meals, and entrance fees to major attractions. Airfare, personal expenses, and optional activities are usually not included unless specified.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="tour2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                    What type of accommodation do you provide?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="tour2" data-bs-parent="#tourAccordion">
                                <div class="accordion-body">
                                    We offer various accommodation options from budget-friendly hotels to luxury resorts. All accommodations are carefully selected for comfort, safety, and location. You can choose your preferred category during booking.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="tour3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                    Are tours suitable for children and seniors?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="tour3" data-bs-parent="#tourAccordion">
                                <div class="accordion-body">
                                    Yes, we offer family-friendly tours and senior-friendly options with appropriate pacing and activities. Some tours have age restrictions for safety reasons, which are clearly mentioned in the tour details.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Support -->
                <div class="mb-5" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-headset me-2"></i>Customer Support
                    </h3>
                    <div class="accordion" id="supportAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="support1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true" aria-controls="collapse10">
                                    How can I contact customer support?
                                </button>
                            </h2>
                            <div id="collapse10" class="accordion-collapse collapse show" aria-labelledby="support1" data-bs-parent="#supportAccordion">
                                <div class="accordion-body">
                                    You can reach us through multiple channels: phone, email, live chat on our website, or visit our <a href="help-center.php">Help Center</a>. Our support team is available 24/7 for emergency assistance during your trip.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="support2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                    What if I have an emergency during my trip?
                                </button>
                            </h2>
                            <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="support2" data-bs-parent="#supportAccordion">
                                <div class="accordion-body">
                                    We provide 24/7 emergency support during your trip. You'll receive emergency contact numbers before departure. Our local representatives are also available to assist with any urgent situations.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="support3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                    Can I leave a review after my trip?
                                </button>
                            </h2>
                            <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="support3" data-bs-parent="#supportAccordion">
                                <div class="accordion-body">
                                    Absolutely! We encourage feedback from our customers. You'll receive a review request email after your trip. Your feedback helps us improve our services and assists other travelers in making informed decisions.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h4 class="text-primary mb-3">
                                <i class="fas fa-question-circle me-2"></i>Still Have Questions?
                            </h4>
                            <p class="mb-4">Can't find the answer you're looking for? Our support team is here to help!</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="contact.php" class="btn btn-primary">
                                    <i class="fas fa-envelope me-2"></i>Contact Us
                                </a>
                                <a href="help-center.php" class="btn btn-outline-primary">
                                    <i class="fas fa-headset me-2"></i>Help Center
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 