<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

// Fetch featured tours
$stmt = $pdo->query("SELECT * FROM tours WHERE featured = 1 ORDER BY created_at DESC LIMIT 6");
$featured_tours = $stmt->fetchAll();

// Fetch special offers
$stmt = $pdo->query("SELECT * FROM tours WHERE discount > 0 ORDER BY discount DESC LIMIT 4");
$special_offers = $stmt->fetchAll();

// Set page title
$page_title = "Home";
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content" data-aos="fade-up">
        <h1>Book Your Dream Vacation</h1>
        <p>Discover amazing destinations and create unforgettable memories with our curated travel experiences</p>
        <div class="hero-buttons">
            <a href="tours.php" class="btn btn-primary btn-lg">
                <i class="fas fa-search me-2"></i>Explore Tours
            </a>
            <a href="#featured-tours" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-star me-2"></i>Featured Tours
            </a>
        </div>
    </div>
</section>

<!-- Quick Search Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="search-filter" data-aos="fade-up">
            <h4 class="text-center mb-3">Find Your Perfect Tour</h4>
            <form method="GET" action="tours.php" class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" placeholder="Search destinations, tours...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <option value="adventure">Adventure</option>
                        <option value="beach">Beach</option>
                        <option value="city">City</option>
                        <option value="cultural">Cultural</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <select class="form-select" name="duration">
                        <option value="">Any Duration</option>
                        <option value="1-3">1-3 Days</option>
                        <option value="4-7">4-7 Days</option>
                        <option value="8-14">8-14 Days</option>
                        <option value="15+">15+ Days</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Featured Tours Section -->
<section id="featured-tours" class="py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Recommended Tours</h2>
            <p>Handpicked destinations that travelers love</p>
        </div>
        
        <div class="row">
            <?php foreach ($featured_tours as $index => $tour): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="card tour-card h-100">
                        <?php if ($tour['discount'] > 0): ?>
                            <div class="badge">
                                <?php echo $tour['discount']; ?>% OFF
                            </div>
                        <?php endif; ?>
                        
                        <img src="<?php echo htmlspecialchars($tour['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tour['title']); ?>">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($tour['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($tour['short_description']); ?></p>
                            
                            <div class="tour-meta">
                                <span class="badge">
                                    <i class="fas fa-clock me-1"></i><?php echo $tour['duration']; ?> days
                                </span>
                                <span class="badge">
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($tour['location'] ?? 'Multiple Locations'); ?>
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="price">
                                    <?php if ($tour['discount'] > 0): ?>
                                        <span class="text-decoration-line-through">$<?php echo number_format($tour['price'], 2); ?></span>
                                        <span class="ms-2">$<?php echo number_format($tour['price'] * (1 - $tour['discount'] / 100), 2); ?></span>
                                    <?php else: ?>
                                        <span>$<?php echo number_format($tour['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="tour-details.php?id=<?php echo $tour['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="tours.php" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-arrow-right me-2"></i>View All Tours
            </a>
        </div>
    </div>
</section>

<!-- Tour Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Explore by Category</h2>
            <p>Find the perfect adventure that matches your interests</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="category-card hover-lift">
                    <i class="fas fa-mountain"></i>
                    <h5>Adventure Tours</h5>
                    <p>Experience thrilling adventures in nature's most beautiful settings.</p>
                    <a href="tours.php?category=adventure" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i>Explore
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="category-card hover-lift">
                    <i class="fas fa-umbrella-beach"></i>
                    <h5>Beach Holidays</h5>
                    <p>Relax and unwind at the world's most beautiful beaches.</p>
                    <a href="tours.php?category=beach" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i>Explore
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="category-card hover-lift">
                    <i class="fas fa-city"></i>
                    <h5>City Breaks</h5>
                    <p>Explore vibrant cities and their rich cultural heritage.</p>
                    <a href="tours.php?category=city" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i>Explore
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="category-card hover-lift">
                    <i class="fas fa-landmark"></i>
                    <h5>Cultural Tours</h5>
                    <p>Immerse yourself in local traditions and historical sites.</p>
                    <a href="tours.php?category=cultural" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i>Explore
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers -->
<?php if (!empty($special_offers)): ?>
<section class="py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Special Offers</h2>
            <p>Limited time deals you don't want to miss</p>
        </div>
        
        <div class="row">
            <?php foreach ($special_offers as $index => $tour): ?>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="card tour-card h-100">
                        <div class="badge">
                            <i class="fas fa-fire me-1"></i><?php echo $tour['discount']; ?>% OFF
                        </div>
                        
                        <img src="<?php echo htmlspecialchars($tour['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tour['title']); ?>">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($tour['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($tour['short_description']); ?></p>
                            
                            <div class="tour-meta">
                                <span class="badge">
                                    <i class="fas fa-clock me-1"></i><?php echo $tour['duration']; ?> days
                                </span>
                                <span class="badge">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Limited Time
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div class="price">
                                    <span class="text-decoration-line-through">$<?php echo number_format($tour['price'], 2); ?></span>
                                    <span class="ms-2 fw-bold">$<?php echo number_format($tour['price'] * (1 - $tour['discount']/100), 2); ?></span>
                                </div>
                                <a href="tour-details.php?id=<?php echo $tour['id']; ?>" class="btn btn-danger">
                                    <i class="fas fa-bolt me-1"></i>Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Why Choose Us</h2>
            <p>We're committed to making your travel dreams come true</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5>Safe & Secure</h5>
                    <p>Your safety is our top priority with comprehensive travel insurance and 24/7 support.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h5>Best Prices</h5>
                    <p>We guarantee the best prices with price match and exclusive deals for our customers.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>24/7 Support</h5>
                    <p>Round-the-clock customer support to assist you before, during, and after your trip.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5>Expert Guides</h5>
                    <p>Professional and knowledgeable guides to enhance your travel experience.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <i class="fas fa-globe-americas"></i>
                    <h3>50+</h3>
                    <p>Destinations</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <h3>10,000+</h3>
                    <p>Happy Travelers</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <i class="fas fa-award"></i>
                    <h3>15+</h3>
                    <p>Years Experience</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <i class="fas fa-heart"></i>
                    <h3>98%</h3>
                    <p>Satisfaction Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h3>Stay Updated</h3>
                <p class="mb-0">Subscribe to our newsletter for exclusive deals, travel tips, and destination inspiration.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email address" required>
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-paper-plane me-1"></i>Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 