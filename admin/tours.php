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

// Handle tour deletion
if (isset($_POST['delete_tour'])) {
    $tour_id = (int)$_POST['tour_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM tours WHERE id = ?");
        $stmt->execute([$tour_id]);
        $success = 'Tour deleted successfully';
    } catch(PDOException $e) {
        $error = 'Failed to delete tour';
    }
}

// Get all tours
$stmt = $pdo->query("SELECT * FROM tours ORDER BY created_at DESC");
$tours = $stmt->fetchAll();

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
                <h1>Manage Tours</h1>
                <a href="add_tour.php" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Tour
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
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tours as $tour): ?>
                                    <tr>
                                        <td><?php echo $tour['id']; ?></td>
                                        <td>
                                            <img src="../<?php echo htmlspecialchars($tour['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($tour['title']); ?>"
                                                 style="width: 100px; height: 60px; object-fit: cover;">
                                        </td>
                                        <td><?php echo htmlspecialchars($tour['title']); ?></td>
                                        <td><?php echo htmlspecialchars($tour['category']); ?></td>
                                        <td>$<?php echo number_format($tour['price'], 2); ?></td>
                                        <td><?php echo $tour['duration']; ?> days</td>
                                        <td>
                                            <?php if ($tour['featured']): ?>
                                                <span class="badge bg-success">Yes</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit_tour.php?id=<?php echo $tour['id']; ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this tour?');">
                                                    <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                                                    <button type="submit" name="delete_tour" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?> 