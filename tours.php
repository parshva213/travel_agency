<?php
require_once 'includes/db_connect.php';
include 'includes/header.php';

// Get filters
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$price_min = isset($_GET['price_min']) ? (float)$_GET['price_min'] : '';
$price_max = isset($_GET['price_max']) ? (float)$_GET['price_max'] : '';
$duration = isset($_GET['duration']) ? $_GET['duration'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Build query
$query = "SELECT * FROM tours WHERE 1=1";
$params = [];

if ($category) {
    $query .= " AND category = ?";
    $params[] = $category;
}

if ($search) {
    $query .= " AND (title LIKE ? OR short_description LIKE ? OR location LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($price_min !== '') {
    $query .= " AND price >= ?";
    $params[] = $price_min;
}

if ($price_max !== '') {
    $query .= " AND price <= ?";
    $params[] = $price_max;
}

if ($duration) {
    switch($duration) {
        case '1-3':
            $query .= " AND duration BETWEEN 1 AND 3";
            break;
        case '4-7':
            $query .= " AND duration BETWEEN 4 AND 7";
            break;
        case '8-14':
            $query .= " AND duration BETWEEN 8 AND 14";
            break;
        case '15+':
            $query .= " AND duration >= 15";
            break;
    }
}

// Add sorting
switch($sort) {
    case 'price_low':
        $query .= " ORDER BY price ASC";
        break;
    case 'price_high':
        $query .= " ORDER BY price DESC";
        break;
    case 'duration':
        $query .= " ORDER BY duration ASC";
        break;
    case 'popular':
        $query .= " ORDER BY featured DESC, created_at DESC";
        break;
    default:
        $query .= " ORDER BY created_at DESC";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$tours = $stmt->fetchAll();

// Get unique categories for filter
$categories = $pdo->query("SELECT DISTINCT category FROM tours WHERE category IS NOT NULL AND category != ''")->fetchAll();

// Set page title
$page_title = "Tour Packages";
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1>Tour Packages</h1>
                <p class="lead">Discover amazing destinations and create unforgettable memories with our carefully curated tour packages.</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="header-stats">
                    <div class="stat-item">
                        <h3><?php echo count($tours); ?></h3>
                        <p>Tours Available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="search-filter" data-aos="fade-up">
            <form method="GET" class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <label for="search" class="form-label">Search Tours</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by title, description, or location..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo $category === $cat['category'] ? 'selected' : ''; ?>>
                                <?php echo ucfirst(htmlspecialchars($cat['category'])); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <label for="price_min" class="form-label">Min Price</label>
                    <input type="number" class="form-control" id="price_min" name="price_min" placeholder="Min $" value="<?php echo $price_min; ?>">
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <label for="price_max" class="form-label">Max Price</label>
                    <input type="number" class="form-control" id="price_max" name="price_max" placeholder="Max $" value="<?php echo $price_max; ?>">
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <label for="duration" class="form-label">Duration</label>
                    <select class="form-select" id="duration" name="duration">
                        <option value="">Any Duration</option>
                        <option value="1-3" <?php echo $duration === '1-3' ? 'selected' : ''; ?>>1-3 Days</option>
                        <option value="4-7" <?php echo $duration === '4-7' ? 'selected' : ''; ?>>4-7 Days</option>
                        <option value="8-14" <?php echo $duration === '8-14' ? 'selected' : ''; ?>>8-14 Days</option>
                        <option value="15+" <?php echo $duration === '15+' ? 'selected' : ''; ?>>15+ Days</option>
                    </select>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <label for="sort" class="form-label">Sort By</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest</option>
                        <option value="popular" <?php echo $sort === 'popular' ? 'selected' : ''; ?>>Most Popular</option>
                        <option value="price_low" <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="duration" <?php echo $sort === 'duration' ? 'selected' : ''; ?>>Duration</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Search Tours
                        </button>
                        <a href="tours.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Tours Grid -->
<section class="py-5">
    <div class="container">
        <?php if (empty($tours)): ?>
            <div class="text-center py-5" data-aos="fade-up">
                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                <h3>No tours found</h3>
                <p class="text-muted mb-4">Try adjusting your search criteria or browse our featured tours.</p>
                <a href="tours.php" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>View All Tours
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($tours as $index => $tour): ?>
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                        <div class="card tour-card h-100" data-category="<?php echo htmlspecialchars($tour['category']); ?>">
                            <?php if ($tour['discount'] > 0): ?>
                                <div class="badge">
                                    <i class="fas fa-fire me-1"></i><?php echo $tour['discount']; ?>% OFF
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($tour['featured']): ?>
                                <div class="badge" style="top: 1rem; left: 1rem; right: auto;">
                                    <i class="fas fa-star me-1"></i>Featured
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
                                    <?php if ($tour['category']): ?>
                                        <span class="badge">
                                            <i class="fas fa-tag me-1"></i><?php echo ucfirst(htmlspecialchars($tour['category'])); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div class="price">
                                        <?php if ($tour['discount'] > 0): ?>
                                            <span class="text-decoration-line-through">$<?php echo number_format($tour['price'], 2); ?></span>
                                            <span class="ms-2 fw-bold">$<?php echo number_format($tour['price'] * (1 - $tour['discount']/100), 2); ?></span>
                                        <?php else: ?>
                                            <span class="fw-bold">$<?php echo number_format($tour['price'], 2); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="tour-details.php?id=<?php echo $tour['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>Added <?php echo date('M j, Y', strtotime($tour['created_at'])); ?>
                                    </small>
                                    <?php if ($tour['featured']): ?>
                                        <small class="text-warning">
                                            <i class="fas fa-star me-1"></i>Featured Tour
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Load More Button (if needed) -->
            <?php if (count($tours) >= 12): ?>
                <div class="text-center mt-5" data-aos="fade-up">
                    <button class="btn btn-outline-primary btn-lg" id="loadMoreBtn">
                        <i class="fas fa-plus me-2"></i>Load More Tours
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Quick Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Quick Categories</h2>
            <p>Browse tours by category</p>
        </div>
        
        <div class="row">
            <?php 
            $quick_categories = [
                ['icon' => 'fas fa-mountain', 'name' => 'Adventure', 'color' => 'primary'],
                ['icon' => 'fas fa-umbrella-beach', 'name' => 'Beach', 'color' => 'info'],
                ['icon' => 'fas fa-city', 'name' => 'City', 'color' => 'success'],
                ['icon' => 'fas fa-landmark', 'name' => 'Cultural', 'color' => 'warning'],
                ['icon' => 'fas fa-tree', 'name' => 'Nature', 'color' => 'success'],
                ['icon' => 'fas fa-utensils', 'name' => 'Food & Wine', 'color' => 'danger']
            ];
            
            foreach ($quick_categories as $index => $cat): ?>
                <div class="col-lg-2 col-md-4 col-6 mb-3" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <a href="tours.php?category=<?php echo strtolower($cat['name']); ?>" class="text-decoration-none">
                        <div class="quick-category-card">
                            <i class="<?php echo $cat['icon']; ?> text-<?php echo $cat['color']; ?>"></i>
                            <h6><?php echo $cat['name']; ?></h6>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?> 