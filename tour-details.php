<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

// Get tour ID from URL
$tour_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$tour_id) {
    header('Location: tours.php');
    exit;
}

// Fetch tour details
$stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$tour_id]);
$tour = $stmt->fetch();

if (!$tour) {
    header('Location: tours.php');
    exit;
}

$page_title = $tour['title'];
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="tours.php" class="text-white">Tours</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($tour['title']); ?></li>
                    </ol>
                </nav>
                <h1><?php echo htmlspecialchars($tour['title']); ?></h1>
                <p class="lead"><?php echo htmlspecialchars($tour['short_description']); ?></p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="header-stats">
                    <div class="stat-item">
                        <h3><?php echo $tour['duration']; ?></h3>
                        <p>Days</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tour Details Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Tour Images and Info -->
            <div class="col-lg-8 mb-5" data-aos="fade-right">
                <!-- Main Image -->
                <div class="card border-0 shadow-sm mb-4">
                    <img src="<?php echo htmlspecialchars($tour['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tour['title']); ?>" style="height: 400px; object-fit: cover;">
                    <?php if ($tour['discount'] > 0): ?>
                        <div class="badge" style="position: absolute; top: 1rem; right: 1rem;">
                            <i class="fas fa-fire me-1"></i><?php echo $tour['discount']; ?>% OFF
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Tour Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Tour Overview</h3>
                        <p class="lead mb-4"><?php echo htmlspecialchars($tour['short_description']); ?></p>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-clock text-primary me-3"></i>
                                    <div>
                                        <strong>Duration:</strong><br>
                                        <span><?php echo $tour['duration']; ?> days</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                    <div>
                                        <strong>Location:</strong><br>
                                        <span><?php echo htmlspecialchars($tour['location'] ?? 'Multiple Locations'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-users text-primary me-3"></i>
                                    <div>
                                        <strong>Group Size:</strong><br>
                                        <span>2-15 people</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-tag text-primary me-3"></i>
                                    <div>
                                        <strong>Category:</strong><br>
                                        <span><?php echo ucfirst(htmlspecialchars($tour['category'] ?? 'Adventure')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tour-meta mb-4">
                            <span class="badge me-2">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                            <span class="badge me-2">
                                <i class="fas fa-shield-alt me-1"></i>Safe Travel
                            </span>
                            <span class="badge me-2">
                                <i class="fas fa-certificate me-1"></i>Certified Guide
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Detailed Description -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Tour Description</h3>
                        <div class="tour-description">
                            <?php echo nl2br(htmlspecialchars($tour['description'] ?? 'Detailed description coming soon...')); ?>
                        </div>
                    </div>
                </div>
                
                <!-- Itinerary -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Itinerary</h3>
                        <div class="itinerary">
                            <div class="itinerary-day mb-4">
                                <h5 class="text-primary">Day 1: Arrival & Welcome</h5>
                                <p>Arrive at your destination and meet your tour guide. Check into your accommodation and enjoy a welcome dinner with your fellow travelers.</p>
                            </div>
                            <div class="itinerary-day mb-4">
                                <h5 class="text-primary">Day 2-<?php echo $tour['duration'] - 1; ?>: Exploration</h5>
                                <p>Explore the highlights of your destination with guided tours, cultural experiences, and adventure activities tailored to your interests.</p>
                            </div>
                            <div class="itinerary-day">
                                <h5 class="text-primary">Day <?php echo $tour['duration']; ?>: Departure</h5>
                                <p>Enjoy your final morning at the destination before departing with unforgettable memories and new friendships.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- What's Included -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="mb-4">What's Included</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-success mb-3"><i class="fas fa-check-circle me-2"></i>Included</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Accommodation</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Professional Guide</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Transportation</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Meals (as specified)</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Activities & Tours</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger mb-3"><i class="fas fa-times-circle me-2"></i>Not Included</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>International Flights</li>
                                    <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Travel Insurance</li>
                                    <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Personal Expenses</li>
                                    <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Optional Activities</li>
                                    <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Tips & Gratuities</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Booking Sidebar -->
            <div class="col-lg-4" data-aos="fade-left">
                <!-- Price Card -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Book This Tour</h4>
                        
                        <div class="price-section mb-4">
                            <?php if ($tour['discount'] > 0): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-decoration-line-through text-muted fs-5">$<?php echo number_format($tour['price'], 2); ?></span>
                                    <span class="badge ms-2"><?php echo $tour['discount']; ?>% OFF</span>
                                </div>
                                <div class="price-display">
                                    <span class="fs-2 fw-bold text-primary">$<?php echo number_format($tour['price'] * (1 - $tour['discount']/100), 2); ?></span>
                                    <span class="text-muted">per person</span>
                                </div>
                            <?php else: ?>
                                <div class="price-display">
                                    <span class="fs-2 fw-bold text-primary">$<?php echo number_format($tour['price'], 2); ?></span>
                                    <span class="text-muted">per person</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Quick Booking Form -->
                        <form method="POST" action="booking.php" data-validate>
                            <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                            
                            <div class="mb-3">
                                <label for="number_of_people" class="form-label">Number of Travelers</label>
                                <select class="form-select" id="number_of_people" name="number_of_people" required>
                                    <option value="">Select</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?> <?php echo $i === 1 ? 'Person' : 'People'; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            
                            <div class="mb-4">
                                <label for="special_requests" class="form-label">Special Requests</label>
                                <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Any special requirements or requests..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </button>
                            
                            <button type="button" class="btn btn-outline-primary w-100" onclick="addToWishlist(<?php echo $tour['id']; ?>)">
                                <i class="fas fa-heart me-2"></i>Add to Wishlist
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <!-- Contact Info -->
                        <div class="text-center">
                            <p class="mb-2"><strong>Need Help?</strong></p>
                            <p class="mb-2"><i class="fas fa-phone text-primary me-2"></i>+1 (555) 123-4567</p>
                            <p class="mb-0"><i class="fas fa-envelope text-primary me-2"></i>info@travelagency.com</p>
                        </div>
                    </div>
                </div>
                
                <!-- Similar Tours -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Similar Tours</h5>
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM tours WHERE category = ? AND id != ? LIMIT 3");
                        $stmt->execute([$tour['category'], $tour['id']]);
                        $similar_tours = $stmt->fetchAll();
                        ?>
                        
                        <?php foreach ($similar_tours as $similar): ?>
                            <div class="similar-tour mb-3">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <img src="<?php echo htmlspecialchars($similar['image']); ?>" alt="<?php echo htmlspecialchars($similar['title']); ?>" class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($similar['title']); ?></h6>
                                        <p class="text-muted mb-1"><?php echo $similar['duration']; ?> days</p>
                                        <p class="fw-bold text-primary mb-0">$<?php echo number_format($similar['price'], 2); ?></p>
                                    </div>
                                </div>
                                <a href="tour-details.php?id=<?php echo $similar['id']; ?>" class="stretched-link"></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Customer Reviews</h2>
            <p>What our travelers say about this tour</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row">
                    <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="John D." class="rounded-circle" width="50" height="50">
                                    </div>
                                    <div>
                                        <h6 class="mb-0">John D.</h6>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0">"Amazing experience! The tour was well-organized and our guide was incredibly knowledgeable. Highly recommend!"</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Sarah M." class="rounded-circle" width="50" height="50">
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Sarah M.</h6>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0">"Perfect balance of adventure and relaxation. The accommodations were excellent and the food was delicious!"</p>
                            </div>
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
                <h3>Ready to Book Your Adventure?</h3>
                <p class="mb-0">Don't miss out on this incredible experience. Book now and secure your spot!</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <a href="#booking" class="btn btn-light btn-lg">
                    <i class="fas fa-calendar-check me-2"></i>Book Now
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function addToWishlist(tourId) {
    // Add to wishlist functionality
    showNotification('Tour added to wishlist!', 'success');
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}
</script>

<?php include 'includes/footer.php'; ?> 