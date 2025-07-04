<?php
require_once 'includes/db_connect.php';
session_start();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            $success = 'Thank you for your message. We will get back to you soon!';
            
            // Clear form data
            $name = $email = $subject = $message = '';
        } catch(PDOException $e) {
            $error = 'Failed to send message. Please try again later.';
        }
    }
}

include 'includes/header.php';
$page_title = "Contact Us";
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1>Contact Us</h1>
                <p class="lead">Get in touch with our travel experts. We're here to help you plan your perfect trip.</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="header-stats">
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Support Available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
    <div class="row">
        <!-- Contact Form -->
            <div class="col-lg-8 mb-5" data-aos="fade-right">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Send us a Message</h3>
                        
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                        <form method="POST" data-validate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subject" class="form-label">Subject *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Select a subject</option>
                                        <option value="General Inquiry" <?php echo isset($subject) && $subject === 'General Inquiry' ? 'selected' : ''; ?>>General Inquiry</option>
                                        <option value="Tour Booking" <?php echo isset($subject) && $subject === 'Tour Booking' ? 'selected' : ''; ?>>Tour Booking</option>
                                        <option value="Custom Tour" <?php echo isset($subject) && $subject === 'Custom Tour' ? 'selected' : ''; ?>>Custom Tour</option>
                                        <option value="Support" <?php echo isset($subject) && $subject === 'Support' ? 'selected' : ''; ?>>Support</option>
                                        <option value="Partnership" <?php echo isset($subject) && $subject === 'Partnership' ? 'selected' : ''; ?>>Partnership</option>
                                    </select>
                                </div>
                        </div>

                        <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tell us about your travel plans or any questions you have..."><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Subscribe to our newsletter for travel tips and exclusive deals
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Get in Touch</h4>
                        
                        <div class="contact-info">
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Address</h6>
                                        <p class="mb-0">123 Travel Street<br>Adventure City, AC 12345<br>United States</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-phone text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Phone</h6>
                                        <p class="mb-0">
                                            <a href="tel:+15551234567" class="text-decoration-none">+1 (555) 123-4567</a><br>
                                            <small class="text-muted">Mon-Fri: 9AM-6PM EST</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Email</h6>
                                        <p class="mb-0">
                                            <a href="mailto:info@travelagency.com" class="text-decoration-none">info@travelagency.com</a><br>
                                            <a href="mailto:support@travelagency.com" class="text-decoration-none">support@travelagency.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Business Hours</h6>
                                        <p class="mb-0">
                                            Monday - Friday: 9:00 AM - 6:00 PM<br>
                                            Saturday: 10:00 AM - 4:00 PM<br>
                                            Sunday: Closed<br>
                                            <small class="text-muted">24/7 Emergency Support Available</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>

                <!-- Social Media -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our services</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                How do I book a tour?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can book a tour through our website by browsing our tour packages, selecting your preferred dates, and completing the booking form. You can also call us directly or send us an email for personalized assistance.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                What is your cancellation policy?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer flexible cancellation policies. Most tours can be cancelled up to 7 days before departure for a full refund. Cancellations within 7 days may incur a fee. Please check the specific terms for your chosen tour.
                            </div>
                        </div>
                        </div>

                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Do you offer custom tours?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! We specialize in creating custom tours tailored to your specific interests, budget, and schedule. Contact our team to discuss your requirements and we'll design the perfect itinerary for you.
                </div>
            </div>
        </div>

                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                What safety measures do you have in place?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Your safety is our top priority. We work with certified guides, maintain small group sizes, provide comprehensive travel insurance, and follow all local safety protocols. We also offer 24/7 emergency support.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Find Us</h2>
            <p>Visit our office or explore our location</p>
            </div>

        <div class="row">
            <div class="col-12" data-aos="fade-up">
                <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.5!2d-74.006!3d40.7128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQyJzQ2LjEiTiA3NMKwMDAnMjEuNiJX!5e0!3m2!1sen!2sus!4v1234567890" 
                                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h3>Ready to Start Planning?</h3>
                <p class="mb-0">Let our travel experts help you create the perfect itinerary for your next adventure.</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <a href="tours.php" class="btn btn-light btn-lg">
                    <i class="fas fa-search me-2"></i>Browse Tours
                </a>
        </div>
    </div>
</div>
</section>

<?php include 'includes/footer.php'; ?> 