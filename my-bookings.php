<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'includes/db_connect.php';
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT b.*, t.title as tour_title FROM bookings b JOIN tours t ON b.tour_id = t.id WHERE b.user_id = ? ORDER BY b.created_at DESC');
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
include 'includes/header.php';
?>
<div class="container mt-4 text-center">
    <a href="index.php">
        <img src="assets/logo.png" alt="Travel Agency Logo" style="height: 40px; width: auto;">
    </a>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>My Bookings</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (count($bookings) === 0): ?>
                        <div class="text-center text-muted py-4">No bookings yet.</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tour</th>
                                    <th>Date</th>
                                    <th>People</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td>#<?php echo $b['id']; ?></td>
                                    <td><?php echo htmlspecialchars($b['tour_title']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($b['booking_date'])); ?></td>
                                    <td><?php echo $b['number_of_people']; ?></td>
                                    <td>₹<?php echo number_format($b['total_price'], 2); ?></td>
                                    <td><span class="badge bg-<?php
                                        switch ($b['status']) {
                                            case 'paid': echo 'success'; break;
                                            case 'confirmed': echo 'primary'; break;
                                            case 'pending': echo 'warning'; break;
                                            case 'cancelled': echo 'danger'; break;
                                            case 'refunded': echo 'secondary'; break;
                                            default: echo 'light';
                                        }
                                    ?>"><?php echo ucfirst($b['status']); ?></span></td>
                                    <td>
                                        <?php if ($b['status'] !== 'paid'): ?>
                                            <a href="payment.php?booking_id=<?php echo $b['id']; ?>" class="btn btn-sm btn-primary">Pay Now</a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?> 