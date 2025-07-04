<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}
include '../includes/db_connect.php';

// Fetch summary data
$total_users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$total_tours = $pdo->query('SELECT COUNT(*) FROM tours')->fetchColumn();
$total_bookings = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$total_revenue = $pdo->query('SELECT IFNULL(SUM(total_amount),0) FROM payments WHERE status = "completed"')->fetchColumn();

// Fetch recent bookings (limit 5)
$stmt = $pdo->prepare('
    SELECT b.id AS booking_id, b.booking_date, b.number_of_people, b.total_price, b.status AS booking_status,
           u.first_name, u.last_name, t.title AS tour_title
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN tours t ON b.tour_id = t.id
    ORDER BY b.created_at DESC LIMIT 5
');
$stmt->execute();
$recent_bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Inter', 'Segoe UI', Arial, sans-serif; }
        .admin-navbar { background: #fff; box-shadow: 0 2px 8px 0 rgba(30,42,90,.06); padding: 0.7rem 2rem; display: flex; align-items: center; justify-content: space-between; }
        .admin-navbar .logo { font-size: 1.6rem; font-weight: 700; color: #e11d48; letter-spacing: 1px; display: flex; align-items: center; }
        .admin-navbar .logo img { height: 36px; width: auto; margin-right: 0.5rem; }
        .admin-navbar .nav { display: flex; gap: 2rem; }
        .admin-navbar .nav a { color: #222; font-weight: 500; text-decoration: none; transition: color 0.2s; }
        .admin-navbar .nav a:hover, .admin-navbar .nav .active { color: #2563eb; }
        .admin-navbar .user-dropdown { position: relative; }
        .admin-navbar .user-btn { background: none; border: none; font-weight: 600; color: #222; cursor: pointer; }
        .admin-navbar .user-menu { display: none; position: absolute; right: 0; top: 120%; background: #fff; box-shadow: 0 2px 8px 0 rgba(30,42,90,.10); border-radius: 8px; min-width: 160px; z-index: 10; }
        .admin-navbar .user-dropdown:hover .user-menu { display: block; }
        .admin-navbar .user-menu a { display: block; padding: 0.7rem 1.2rem; color: #222; text-decoration: none; border-bottom: 1px solid #f3f6fa; }
        .admin-navbar .user-menu a:last-child { border-bottom: none; }
        .admin-navbar .user-menu a:hover { background: #f3f6fa; color: #2563eb; }
        .welcome-banner { background: #1877f2; color: #fff; border-radius: 14px; margin: 2rem 0 1.5rem 0; padding: 2.2rem 2.5rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px 0 rgba(30,42,90,.06); }
        .welcome-banner h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        .welcome-banner p { margin: 0; font-size: 1.1rem; opacity: 0.95; }
        .welcome-banner .banner-icon { font-size: 2.5rem; opacity: 0.18; }
        .summary-cards { display: flex; gap: 2rem; margin-bottom: 2rem; flex-wrap: wrap; }
        .summary-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px 0 rgba(30,42,90,.08); padding: 1.5rem 2rem; flex: 1 1 180px; min-width: 180px; display: flex; flex-direction: column; align-items: flex-start; }
        .summary-card .icon { font-size: 2.2rem; margin-bottom: 0.7rem; color: #1877f2; }
        .summary-card .label { font-size: 1.05rem; color: #888; font-weight: 500; }
        .summary-card .value { font-size: 1.5rem; font-weight: 700; color: #222; }
        .summary-card.revenue .icon { color: #f59e42; }
        .summary-card.revenue .value { color: #f59e42; }
        .summary-card.users .icon { color: #2563eb; }
        .summary-card.tours .icon { color: #059669; }
        .summary-card.bookings .icon { color: #e11d48; }
        .main-content { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
        .dashboard-row { display: flex; gap: 2rem; flex-wrap: wrap; }
        .dashboard-col { flex: 2 1 600px; min-width: 340px; }
        .dashboard-side { flex: 1 1 320px; min-width: 280px; }
        .card { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px 0 rgba(30,42,90,.08); margin-bottom: 2rem; }
        .card-header { padding: 1.2rem 1.5rem; border-bottom: 1px solid #f3f6fa; font-weight: 600; font-size: 1.1rem; color: #2563eb; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 1.5rem 1.5rem; }
        .recent-table { width: 100%; border-collapse: collapse; }
        .recent-table th, .recent-table td { padding: 0.7rem 0.5rem; text-align: left; }
        .recent-table th { color: #2563eb; font-weight: 600; background: #f3f6fa; }
        .recent-table tr { border-bottom: 1px solid #f3f6fa; }
        .recent-table tr:last-child { border-bottom: none; }
        .btn-pink { background: #e11d48; color: #fff; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; font-weight: 600; transition: background 0.2s; }
        .btn-pink:hover { background: #be185d; color: #fff; }
        .quick-actions { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px 0 rgba(30,42,90,.08); padding: 1.5rem 1.5rem; margin-bottom: 2rem; }
        .quick-actions .btn { display: block; width: 100%; margin-bottom: 1rem; font-size: 1.05rem; font-weight: 600; }
        .quick-actions .btn:last-child { margin-bottom: 0; }
        .quick-actions .btn-pink { background: #e11d48; color: #fff; }
        .quick-actions .btn-pink:hover { background: #be185d; }
        .quick-actions .btn-outline { background: #fff; color: #2563eb; border: 2px solid #2563eb; }
        .quick-actions .btn-outline:hover { background: #2563eb; color: #fff; }
        @media (max-width: 900px) {
            .dashboard-row { flex-direction: column; }
            .dashboard-col, .dashboard-side { min-width: 0; }
        }
        @media (max-width: 600px) {
            .main-content { padding: 0 0.5rem; }
            .welcome-banner { padding: 1.2rem 1rem; }
            .summary-cards { gap: 1rem; }
            .summary-card { padding: 1rem 1rem; }
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <a href="dashboard.php" class="logo d-flex align-items-center text-decoration-none">
            <img src="../assets/Logo.png" alt="Travel Agency Logo">
            Travel Agency Admin
        </a>
        <div class="nav">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="admin_tour.php">Tours</a>
            <a href="bookings.php">Bookings</a>
            <a href="payments.php">Payments</a>
            <a href="users.php">Users</a>
        </div>
        <div class="user-dropdown">
            <button class="user-btn"><i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($_SESSION['user_name']); ?> <i class="fas fa-chevron-down ms-1"></i></button>
            <div class="user-menu">
                <a href="../my_profile.php">Profile</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <div class="welcome-banner">
            <div>
                <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
                <p>Here's what's happening with your Travel Agency today.</p>
            </div>
            <div class="banner-icon"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="summary-cards">
            <div class="summary-card users">
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="label">TOTAL USERS</div>
                <div class="value"><?php echo $total_users; ?></div>
            </div>
            <div class="summary-card tours">
                <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
                <div class="label">TOTAL TOURS</div>
                <div class="value"><?php echo $total_tours; ?></div>
            </div>
            <div class="summary-card bookings">
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
                <div class="label">TOTAL BOOKINGS</div>
                <div class="value"><?php echo $total_bookings; ?></div>
            </div>
            <div class="summary-card revenue">
                <div class="icon"><i class="fas fa-rupee-sign"></i></div>
                <div class="label">TOTAL REVENUE</div>
                <div class="value">₹<?php echo number_format($total_revenue, 2); ?></div>
            </div>
        </div>
        <div class="dashboard-row">
            <div class="dashboard-col">
                <div class="card">
                    <div class="card-header">
                        <span><i class="fas fa-clock me-2"></i>Recent Bookings</span>
                        <a href="bookings.php" class="btn btn-pink" style="padding:0.4rem 1.1rem;font-size:0.97rem;">View All</a>
                    </div>
                    <div class="card-body">
                        <?php if (count($recent_bookings) === 0): ?>
                            <div class="text-center text-muted py-4">No bookings yet.</div>
                        <?php else: ?>
                        <table class="recent-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Tour</th>
                                    <th>Date</th>
                                    <th>People</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_bookings as $b): ?>
                                <tr>
                                    <td>#<?php echo $b['booking_id']; ?></td>
                                    <td><?php echo htmlspecialchars($b['first_name'] . ' ' . $b['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($b['tour_title']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($b['booking_date'])); ?></td>
                                    <td><?php echo $b['number_of_people']; ?></td>
                                    <td>₹<?php echo number_format($b['total_price'], 2); ?></td>
                                    <td><span class="badge bg-<?php
                                        switch ($b['booking_status']) {
                                            case 'paid': echo 'success'; break;
                                            case 'confirmed': echo 'primary'; break;
                                            case 'pending': echo 'warning'; break;
                                            case 'cancelled': echo 'danger'; break;
                                            case 'refunded': echo 'secondary'; break;
                                            default: echo 'light';
                                        }
                                    ?>"><?php echo ucfirst($b['booking_status']); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="dashboard-side">
                <div class="quick-actions">
                    <div class="card-header" style="color:#2563eb;"><i class="fas fa-bolt me-2"></i>Quick Actions</div>
                    <a href="add_tour.php" class="btn btn-pink mt-3"><i class="fas fa-plus me-2"></i>Add New Tour</a>
                    <a href="bookings.php" class="btn btn-outline"><i class="fas fa-calendar-check me-2"></i>Manage Bookings</a>
                    <a href="users.php" class="btn btn-outline"><i class="fas fa-users me-2"></i>View Users</a>
                    <a href="payments.php" class="btn btn-outline"><i class="fas fa-credit-card me-2"></i>Manage Payments</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 