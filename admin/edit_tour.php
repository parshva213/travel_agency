<?php
require_once '../includes/db_connect.php';
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}

$success = '';
$error = '';

// Get tour ID from URL
$tour_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($tour_id <= 0) {
    header('Location: tours.php');
    exit();
}

// Fetch tour details
try {
    $stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();

    if (!$tour) {
        header('Location: tours.php');
        exit();
    }
} catch (Exception $e) {
    $error = 'Error fetching tour details: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $short_description = trim($_POST['short_description']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $discount = (int)$_POST['discount'];
    $duration = (int)$_POST['duration'];
    $max_group_size = (int)$_POST['max_group_size'];
    $category = trim($_POST['category']);
    $featured = isset($_POST['featured']) ? 1 : 0;

    // Validate input
    if (empty($title) || empty($short_description) || empty($description) || $price <= 0 || $duration <= 0) {
        $error = 'Please fill in all required fields correctly';
    } else {
        try {
            // Handle image upload if new image is provided
            $image_path = $tour['image']; // Keep existing image by default
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $filename = $_FILES['image']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed)) {
                    $new_filename = uniqid() . '.' . $ext;
                    $upload_path = '../assets/images/tours/' . $new_filename;

                    // Create directory if it doesn't exist
                    if (!file_exists('../assets/images/tours')) {
                        mkdir('../assets/images/tours', 0777, true);
                    }

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        // Delete old image if it exists
                        if (!empty($tour['image']) && file_exists('../' . $tour['image'])) {
                            unlink('../' . $tour['image']);
                        }
                        $image_path = 'assets/images/tours/' . $new_filename;
                    } else {
                        throw new Exception('Failed to upload image');
                    }
                } else {
                    throw new Exception('Invalid image format. Allowed formats: ' . implode(', ', $allowed));
                }
            }

            // Update tour in database
            $stmt = $pdo->prepare("
                UPDATE tours 
                SET title = ?, short_description = ?, description = ?, price = ?, 
                    discount = ?, duration = ?, max_group_size = ?, category = ?, 
                    featured = ?, image = ?
                WHERE id = ?
            ");
            
            $stmt->execute([
                $title, $short_description, $description, $price, $discount, 
                $duration, $max_group_size, $category, $featured, $image_path, $tour_id
            ]);

            $success = 'Tour updated successfully';
            
            // Refresh tour data
            $stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
            $stmt->execute([$tour_id]);
            $tour = $stmt->fetch();

        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="tours.php" class="list-group-item list-group-item-action active">
                    <i class="fas fa-map-marked-alt me-2"></i> Manage Tours
                </a>
                <a href="bookings.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-calendar-check me-2"></i> Manage Bookings
                </a>
                <a href="users.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-users me-2"></i> Manage Users
                </a>
                <a href="messages.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-envelope me-2"></i> Contact Messages
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Tour</h1>
                <a href="tours.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Tours
                </a>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?php echo htmlspecialchars($tour['title']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description *</label>
                                    <textarea class="form-control" id="short_description" name="short_description" 
                                              rows="3" required><?php echo htmlspecialchars($tour['short_description']); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Full Description *</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="5" required><?php echo htmlspecialchars($tour['description']); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Tour Image</label>
                                    <?php if (!empty($tour['image'])): ?>
                                        <div class="mb-2">
                                            <img src="../<?php echo htmlspecialchars($tour['image']); ?>" 
                                                 alt="Current tour image" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <small class="text-muted">Leave empty to keep current image. Allowed formats: JPG, JPEG, PNG, WEBP</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($) *</label>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?php echo $tour['price']; ?>" step="0.01" min="0" required>
                                </div>

                                <div class="mb-3">
                                    <label for="discount" class="form-label">Discount (%)</label>
                                    <input type="number" class="form-control" id="discount" name="discount" 
                                           value="<?php echo $tour['discount']; ?>" min="0" max="100">
                                </div>

                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration (days) *</label>
                                    <input type="number" class="form-control" id="duration" name="duration" 
                                           value="<?php echo $tour['duration']; ?>" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="max_group_size" class="form-label">Maximum Group Size</label>
                                    <input type="number" class="form-control" id="max_group_size" name="max_group_size" 
                                           value="<?php echo $tour['max_group_size']; ?>" min="1">
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category *</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="adventure" <?php echo $tour['category'] === 'adventure' ? 'selected' : ''; ?>>Adventure</option>
                                        <option value="beach" <?php echo $tour['category'] === 'beach' ? 'selected' : ''; ?>>Beach</option>
                                        <option value="city" <?php echo $tour['category'] === 'city' ? 'selected' : ''; ?>>City</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="featured" name="featured" 
                                               <?php echo $tour['featured'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="featured">Featured Tour</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Tour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?> 