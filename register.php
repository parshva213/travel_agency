<?php
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$first_name || !$last_name || !$email || !$phone || !$password) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Check for existing email
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email is already registered.']);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)');
    if ($stmt->execute([$first_name, $last_name, $email, $phone, $hashed_password])) {
        echo json_encode(['success' => true, 'message' => 'Registration successful! You can now login.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed. Try again.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Travel Agency</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1500&q=80') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(6px);
            z-index: 0;
        }
        .container, .footer { position: relative; z-index: 1; }
        .container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card {
            border-radius: 22px;
            box-shadow: 0 12px 40px 0 rgba(30,42,90,.18);
            border: none;
            max-width: 420px;
            margin: 32px auto;
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1.5px solid rgba(200,200,255,0.18);
        }
        .card-body { padding: 2.5rem 2rem; }
        .logo-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
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
        .text-center a { color: #2563eb; font-weight: 500; }
        .tagline { color: #2563eb; font-weight: 500; font-size: 1.1rem; margin-bottom: 1.5rem; }
        .footer { text-align: center; margin-top: 2rem; color: #888; font-size: 0.95rem; }
        /* Carousel styles */
        .carousel-container {
            max-width: 420px;
            margin: 2rem auto 0 auto;
            text-align: center;
        }
        .carousel {
            position: relative;
            height: 180px;
            overflow: hidden;
            border-radius: 14px;
            box-shadow: 0 2px 12px 0 rgba(30,42,90,.10);
            background: #fff;
        }
        .carousel-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: none;
            transition: opacity 0.5s;
        }
        .carousel-img.active { display: block; }
        .carousel-dots {
            margin-top: 0.5rem;
        }
        .dot {
            display: inline-block;
            width: 10px; height: 10px;
            margin: 0 4px;
            background: #2563eb;
            border-radius: 50%;
            opacity: 0.3;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .dot.active { opacity: 1; }
        /* Why Choose Us styles */
        .why-choose-us {
            max-width: 420px;
            margin: 2rem auto 0 auto;
            background: rgba(255,255,255,0.85);
            border-radius: 14px;
            box-shadow: 0 2px 12px 0 rgba(30,42,90,.10);
            padding: 1.5rem 1.2rem;
            text-align: left;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .why-choose-us h4 {
            color: #2563eb;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .why-choose-us ul {
            list-style: none;
            padding: 0;
            margin-bottom: 1.2rem;
        }
        .why-choose-us li {
            margin-bottom: 0.5rem;
            font-size: 1.05rem;
        }
        .why-choose-us i.fa-check-circle {
            color: #2563eb;
            margin-right: 7px;
        }
        .testimonials blockquote {
            font-size: 1rem;
            color: #444;
            margin: 0 0 1rem 0;
            border-left: 3px solid #2563eb;
            padding-left: 0.7rem;
            background: #f6f8fa;
            border-radius: 6px;
        }
        .testimonials span {
            color: #2563eb;
            font-size: 0.97rem;
            font-style: italic;
        }
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
                <img src="assets/Logo.png" alt="Travel Agency Logo" class="logo-img">
                <h2 style="font-weight:700;">Create Your Travel Account</h2>
                <div class="tagline">Start your journey with us!</div>
            </div>
            <div id="register-alert"></div>
            <form id="registerForm" autocomplete="off">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" id="registerBtn" style="font-weight:600; font-size:1.1rem;">
                    <span id="registerBtnText"><i class="fas fa-user-plus me-2"></i>CREATE ACCOUNT</span>
                </button>
                <div class="text-center">
                    <a href="login.php" class="text-decoration-none">
                        <small>Already have an account? Login</small>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Carousel of travel photos -->
<div class="carousel-container">
    <div class="carousel">
        <img src="https://images.unsplash.com/photo-1465156799763-2c087c332922?auto=format&fit=crop&w=800&q=80" alt="Paris" class="carousel-img active">
        <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=800&q=80" alt="Santorini" class="carousel-img">
        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80" alt="Maldives" class="carousel-img">
    </div>
    <div class="carousel-dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</div>
<!-- Why Choose Us section -->
<div class="why-choose-us">
    <h4>Why Choose Us?</h4>
    <ul>
        <li><i class="fas fa-check-circle"></i> Handpicked destinations worldwide</li>
        <li><i class="fas fa-check-circle"></i> 24/7 customer support</li>
        <li><i class="fas fa-check-circle"></i> Best price guarantee</li>
        <li><i class="fas fa-check-circle"></i> 10,000+ happy travelers</li>
    </ul>
    <div class="testimonials">
        <blockquote>
            <i class="fas fa-quote-left"></i>
            "The best travel experience I've ever had! Highly recommended."
            <br><span>- Priya S., Mumbai</span>
        </blockquote>
        <blockquote>
            <i class="fas fa-quote-left"></i>
            "Amazing service and beautiful destinations. Will book again!"
            <br><span>- John D., London</span>
        </blockquote>
    </div>
</div>
<div class="footer">
    &copy; <?php echo date('Y'); ?> Travel Agency. All rights reserved.
</div>
<script>
$(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        $('#registerBtn').prop('disabled', true);
        $('#registerBtnText').html('<span class="loading"></span>PROCESSING...');
        $('#register-alert').html('');
        $.ajax({
            url: '',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#register-alert').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#registerForm')[0].reset();
                } else {
                    $('#register-alert').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
                $('#registerBtn').prop('disabled', false);
                $('#registerBtnText').html('<i class="fas fa-user-plus me-2"></i>CREATE ACCOUNT');
            },
            error: function() {
                $('#register-alert').html('<div class="alert alert-danger">Server error. Please try again.</div>');
                $('#registerBtn').prop('disabled', false);
                $('#registerBtnText').html('<i class="fas fa-user-plus me-2"></i>CREATE ACCOUNT');
            }
        });
    });
    // Carousel logic
    let currentSlide = 0;
    const images = document.querySelectorAll('.carousel-img');
    const dots = document.querySelectorAll('.dot');
    function showSlide(idx) {
        images.forEach((img, i) => img.classList.toggle('active', i === idx));
        dots.forEach((dot, i) => dot.classList.toggle('active', i === idx));
    }
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            currentSlide = i;
            showSlide(currentSlide);
        });
    });
    setInterval(() => {
        currentSlide = (currentSlide + 1) % images.length;
        showSlide(currentSlide);
    }, 3500);
});
</script>
</body>
</html> 