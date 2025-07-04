<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND is_admin = 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['is_admin'] = $user['is_admin'];
        echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid admin credentials.']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Travel Agency</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #fff;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }
        .container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card {
            border-radius: 18px;
            box-shadow: 0 6px 32px 0 rgba(30,42,90,.08);
            border: none;
            max-width: 420px;
            margin: 32px auto;
            background: #fff;
        }
        .card-body { padding: 2.5rem 2rem; }
        .fa-user-shield {
            color: #2563eb;
            background: #e8f0fe;
            border-radius: 50%;
            padding: 12px;
        }
        .form-label { font-weight: 600; }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            font-size: 1.08rem;
            background: #f6f8fa;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px #2563eb22;
            background: #fff;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }
        .btn-primary:disabled { opacity: 0.85; }
        .loading {
            margin-right: 8px;
            border: 2px solid #fff;
            border-top: 2px solid #2563eb;
            border-radius: 50%;
            width: 18px; height: 18px;
            display: inline-block;
            animation: spin 1s linear infinite;
            vertical-align: middle;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .alert { border-radius: 8px; font-size: 1rem; }
        .tagline { color: #888; font-weight: 400; font-size: 1.08rem; margin-bottom: 1.5rem; }
        @media (max-width: 600px) {
            .card-body { padding: 1.5rem 0.7rem; }
            .card { max-width: 98vw; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card shadow">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fas fa-user-shield fa-3x mb-3"></i>
                <h2 style="font-weight:700;">Admin Login</h2>
                <div class="tagline">Sign in to your admin account</div>
            </div>
            <div id="login-alert"></div>
            <form id="loginForm" autocomplete="off">
                <div class="mb-3">
                    <label for="email" class="form-label">Admin Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" id="loginBtn" style="font-weight:600; font-size:1.1rem;">
                    <span id="loginBtnText"><i class="fas fa-sign-in-alt me-2"></i>PROCESSING...</span>
                </button>
            </form>
        </div>
    </div>
</div>
<script>
$(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $('#loginBtn').prop('disabled', true);
        $('#loginBtnText').html('<span class="loading"></span>PROCESSING...');
        $('#login-alert').html('');
        $.ajax({
            url: '',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#login-alert').html('<div class="alert alert-success">Login successful! Redirecting...</div>');
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    $('#login-alert').html('<div class="alert alert-danger">' + response.message + '</div>');
                    $('#loginBtn').prop('disabled', false);
                    $('#loginBtnText').html('<i class=\"fas fa-sign-in-alt me-2\"></i>SIGN IN');
                }
            },
            error: function() {
                $('#login-alert').html('<div class="alert alert-danger">Server error. Please try again.</div>');
                $('#loginBtn').prop('disabled', false);
                $('#loginBtnText').html('<i class=\"fas fa-sign-in-alt me-2\"></i>SIGN IN');
            }
        });
    });
});
</script>
</body>
</html> 