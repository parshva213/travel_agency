<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}
require_once '../includes/db_connect.php';
$stmt = $pdo->query('SELECT * FROM tours ORDER BY created_at DESC');
$tours = $stmt->fetchAll();
include '../includes/header.php';
?>
<?php include 'includes/admin_navbar.php'; ?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Manage Tours</h4>
        </div>
        <div class="card-body p-4">
            <a href="add_tour.php" class="btn btn-primary mb-3"><i class="fas fa-plus me-2"></i>Add New Tour</a>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><?php echo $tour['id']; ?></td>
                            <td><?php echo htmlspecialchars($tour['title']); ?></td>
                            <td><?php echo htmlspecialchars($tour['category']); ?></td>
                            <td>₹<?php echo number_format($tour['price'], 2); ?></td>
                            <td><?php echo $tour['duration']; ?> days</td>
                            <td>
                                <a href="edit_tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="tours.php" style="display:inline;">
                                    <input type="hidden" name="delete_tour" value="1">
                                    <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this tour?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 