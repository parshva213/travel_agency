<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'includes/db_connect.php';
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT p.*, t.title as tour_title, b.booking_date, pm.name as method_name FROM payments p JOIN bookings b ON p.booking_id = b.id JOIN tours t ON b.tour_id = t.id JOIN payment_methods pm ON p.payment_method_id = pm.id WHERE b.user_id = ? ORDER BY p.created_at DESC');
$stmt->execute([$user_id]);
$payments = $stmt->fetchAll();
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
                    <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>My Payments</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (count($payments) === 0): ?>
                        <div class="text-center text-muted py-4">No payments yet.</div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tour</th>
                                    <th>Booking Date</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $p): ?>
                                <tr>
                                    <td>#<?php echo $p['id']; ?></td>
                                    <td><?php echo htmlspecialchars($p['tour_title']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($p['booking_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($p['method_name']); ?></td>
                                    <td>₹<?php echo number_format($p['total_amount'], 2); ?></td>
                                    <td><span class="badge bg-<?php
                                        switch ($p['status']) {
                                            case 'completed': echo 'success'; break;
                                            case 'pending': echo 'warning'; break;
                                            case 'processing': echo 'info'; break;
                                            case 'failed': echo 'danger'; break;
                                            case 'refunded': echo 'secondary'; break;
                                            default: echo 'light';
                                        }
                                    ?>"><?php echo ucfirst($p['status']); ?></span></td>
                                    <td><?php echo date('M j, Y', strtotime($p['created_at'])); ?></td>
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