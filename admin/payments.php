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

// Handle payment status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $payment_id = (int)$_POST['payment_id'];
    $action = $_POST['action'];
    
    try {
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE payments SET status = 'completed' WHERE id = ?");
            $stmt->execute([$payment_id]);
            
            // Update booking status
            $stmt = $pdo->prepare("
                UPDATE bookings b 
                JOIN payments p ON b.id = p.booking_id 
                SET b.status = 'paid', b.payment_status = 'completed' 
                WHERE p.id = ?
            ");
            $stmt->execute([$payment_id]);
            
            $success = 'Payment approved successfully';
        } elseif ($action === 'reject') {
            $stmt = $pdo->prepare("UPDATE payments SET status = 'failed' WHERE id = ?");
            $stmt->execute([$payment_id]);
            
            $success = 'Payment rejected successfully';
        }
    } catch (Exception $e) {
        $error = 'Error updating payment: ' . $e->getMessage();
    }
}

// Get payments with related data
$stmt = $pdo->prepare("
    SELECT p.*, pm.name as payment_method_name, pm.icon as payment_method_icon,
           b.booking_date, b.number_of_people, b.total_price as booking_total,
           t.title as tour_title, u.first_name, u.last_name, u.email
    FROM payments p
    JOIN payment_methods pm ON p.payment_method_id = pm.id
    JOIN bookings b ON p.booking_id = b.id
    JOIN tours t ON b.tour_id = t.id
    JOIN users u ON b.user_id = u.id
    ORDER BY p.created_at DESC
");
$stmt->execute();
$payments = $stmt->fetchAll();

include 'includes/admin_navbar.php';

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
                <a href="tours.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-map-marked-alt me-2"></i> Manage Tours
                </a>
                <a href="bookings.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-calendar-check me-2"></i> Manage Bookings
                </a>
                <a href="payments.php" class="list-group-item list-group-item-action active">
                    <i class="fas fa-credit-card me-2"></i> Manage Payments
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
                <h1>
                    <i class="fas fa-credit-card me-2"></i>Payment Management
                </h1>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- Payment Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Payments</h6>
                                    <h4><?php echo count($payments); ?></h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-credit-card fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Completed</h6>
                                    <h4><?php echo count(array_filter($payments, function($p) { return $p['status'] === 'completed'; })); ?></h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Pending</h6>
                                    <h4><?php echo count(array_filter($payments, function($p) { return $p['status'] === 'pending'; })); ?></h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Failed</h6>
                                    <h4><?php echo count(array_filter($payments, function($p) { return $p['status'] === 'failed'; })); ?></h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-times-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Payment History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Tour</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($payments as $payment): ?>
                                    <tr>
                                        <td>#<?php echo $payment['id']; ?></td>
                                        <td>
                                            <div>
                                                <strong><?php echo htmlspecialchars($payment['first_name'] . ' ' . $payment['last_name']); ?></strong><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($payment['email']); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo htmlspecialchars($payment['tour_title']); ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo $payment['number_of_people']; ?> people, 
                                                    <?php echo date('M j, Y', strtotime($payment['booking_date'])); ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="<?php echo htmlspecialchars($payment['payment_method_icon']); ?> me-2"></i>
                                                <?php echo htmlspecialchars($payment['payment_method_name']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>$<?php echo number_format($payment['total_amount'], 2); ?></strong><br>
                                                <small class="text-muted">
                                                    Fee: $<?php echo number_format($payment['processing_fee'], 2); ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            $status_icon = '';
                                            switch ($payment['status']) {
                                                case 'completed':
                                                    $status_class = 'success';
                                                    $status_icon = 'check-circle';
                                                    break;
                                                case 'pending':
                                                    $status_class = 'warning';
                                                    $status_icon = 'clock';
                                                    break;
                                                case 'processing':
                                                    $status_class = 'info';
                                                    $status_icon = 'spinner';
                                                    break;
                                                case 'failed':
                                                    $status_class = 'danger';
                                                    $status_icon = 'times-circle';
                                                    break;
                                                case 'refunded':
                                                    $status_class = 'secondary';
                                                    $status_icon = 'undo';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge bg-<?php echo $status_class; ?>">
                                                <i class="fas fa-<?php echo $status_icon; ?> me-1"></i>
                                                <?php echo ucfirst($payment['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo date('M j, Y', strtotime($payment['created_at'])); ?></strong><br>
                                                <small class="text-muted"><?php echo date('g:i A', strtotime($payment['created_at'])); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" data-bs-target="#paymentModal<?php echo $payment['id']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <?php if ($payment['status'] === 'pending'): ?>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button type="submit" class="btn btn-sm btn-outline-success" 
                                                                onclick="return confirm('Approve this payment?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                onclick="return confirm('Reject this payment?')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Payment Details Modal -->
                                    <div class="modal fade" id="paymentModal<?php echo $payment['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Payment Details #<?php echo $payment['id']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Customer Information</h6>
                                                            <p><strong>Name:</strong> <?php echo htmlspecialchars($payment['first_name'] . ' ' . $payment['last_name']); ?></p>
                                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($payment['email']); ?></p>
                                                            <p><strong>Tour:</strong> <?php echo htmlspecialchars($payment['tour_title']); ?></p>
                                                            <p><strong>Booking Date:</strong> <?php echo date('F j, Y', strtotime($payment['booking_date'])); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Payment Information</h6>
                                                            <p><strong>Method:</strong> <?php echo htmlspecialchars($payment['payment_method_name']); ?></p>
                                                            <p><strong>Amount:</strong> $<?php echo number_format($payment['amount'], 2); ?></p>
                                                            <p><strong>Processing Fee:</strong> $<?php echo number_format($payment['processing_fee'], 2); ?></p>
                                                            <p><strong>Total:</strong> $<?php echo number_format($payment['total_amount'], 2); ?></p>
                                                            <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($payment['transaction_id']); ?></p>
                                                            <p><strong>Status:</strong> 
                                                                <span class="badge bg-<?php echo $status_class; ?>">
                                                                    <?php echo ucfirst($payment['status']); ?>
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if ($payment['payment_data']): ?>
                                                        <div class="mt-3">
                                                            <h6>Payment Data</h6>
                                                            <pre class="bg-light p-3 rounded"><?php echo htmlspecialchars(json_encode(json_decode($payment['payment_data']), JSON_PRETTY_PRINT)); ?></pre>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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