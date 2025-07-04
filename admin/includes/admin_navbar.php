<?php
// Admin Navbar with logo and dropdowns
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container-fluid">
    <?php include 'admin_logo.php'; ?>
    <div class="d-flex align-items-center ms-auto">
      <div class="dropdown me-3">
        <button class="btn btn-link dropdown-toggle fw-semibold" type="button" id="adminMenu" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-cog me-1"></i> Admin
        </button>
        <ul class="dropdown-menu" aria-labelledby="adminMenu">
          <li><a class="dropdown-item" href="dashboard.php"><i class="fas fa-clock me-2"></i>Dashboard</a></li>
          <li><a class="dropdown-item" href="admin_tour.php"><i class="fas fa-map-marked-alt me-2"></i>Manage Tours</a></li>
          <li><a class="dropdown-item" href="bookings.php"><i class="fas fa-calendar-check me-2"></i>Manage Bookings</a></li>
          <li><a class="dropdown-item" href="payments.php"><i class="fas fa-credit-card me-2"></i>Manage Payments</a></li>
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn btn-link dropdown-toggle fw-semibold" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="userMenu">
          <li><a class="dropdown-item" href="../my_profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
          <li><a class="dropdown-item" href="../my-bookings.php"><i class="fas fa-calendar-check me-2"></i>My Bookings</a></li>
          <li><a class="dropdown-item" href="../my_payments.php"><i class="fas fa-credit-card me-2"></i>Payment History</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav> 