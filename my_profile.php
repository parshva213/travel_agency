<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'includes/db_connect.php';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $stmt = $pdo->prepare('UPDATE users SET first_name=?, last_name=?, phone=?, address=? WHERE id=?');
    $stmt->execute([$first_name, $last_name, $phone, $address, $user_id]);
    $_SESSION['success'] = 'Profile updated successfully!';
}
$stmt = $pdo->prepare('SELECT * FROM users WHERE id=?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();
include 'includes/header.php';
?>
<div class="container mt-4 text-center">
    <a href="index.php">
        <img src="assets/logo.png" alt="Travel Agency Logo" style="height: 40px; width: auto;">
    </a>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>My Profile</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?> 