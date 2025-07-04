<?php
include 'includes/header.php';
include 'includes/db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Check if user exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user) {
            // Generate token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            // Store token
            $pdo->prepare('INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)')->execute([$user['id'], $token, $expires]);
            // Send email (pseudo-code, replace with actual mail function)
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/set_new_password.php?token=$token";
            // mail($email, 'Password Reset', "Click here to reset your password: $reset_link");
        }
        $success = 'If the email exists in our system, a password reset link has been sent.';
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-unlock-alt fa-3x text-primary mb-3"></i>
                        <h3>Forgot Password?</h3>
                        <p class="text-muted">Enter your email to receive a password reset link.</p>
                    </div>
                    <?php if ($success): ?>
                        <div class="alert alert-success"> <?php echo $success; ?> </div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"> <?php echo $error; ?> </div>
                    <?php endif; ?>
                    <form method="post" data-validate novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Please enter your email address.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                        </button>
                        <div class="text-center">
                            <a href="login.php" class="text-decoration-none">
                                <small>Back to Login</small>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/main.js"></script>
<?php include 'includes/footer.php'; ?> 