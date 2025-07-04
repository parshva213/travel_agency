<?php
include 'includes/header.php';
include 'includes/db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$token = $_GET['token'] ?? '';
$error = '';
$success = '';
$show_form = false;

if ($token) {
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()');
    $stmt->execute([$token]);
    $reset = $stmt->fetch();
    if ($reset) {
        $show_form = true;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            if (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters.';
            } else {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([$hashed, $reset['user_id']]);
                $pdo->prepare('DELETE FROM password_resets WHERE token = ?')->execute([$token]);
                $success = 'Your password has been reset. You can now <a href="login.php">login</a>.';
                $show_form = false;
            }
        }
    } else {
        $error = 'Invalid or expired token.';
    }
} else {
    $error = 'Invalid request.';
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-key fa-3x text-primary mb-3"></i>
                        <h3>Set New Password</h3>
                    </div>
                    <?php if ($success): ?>
                        <div class="alert alert-success"> <?php echo $success; ?> </div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"> <?php echo $error; ?> </div>
                    <?php endif; ?>
                    <?php if ($show_form): ?>
                    <form method="post" data-validate novalidate>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">Please enter a new password (min 6 characters).</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-save me-2"></i>Set Password
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/main.js"></script>
<?php include 'includes/footer.php'; ?> 