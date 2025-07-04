<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}
$about_file = '../about.txt';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents($about_file, trim($_POST['about']));
    $success = 'About info updated!';
}
$about = file_exists($about_file) ? file_get_contents($about_file) : '';
include '../includes/header.php';
include 'includes/admin_navbar.php';
?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>About Agency</h4>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($success)): ?><div class="alert alert-success mb-3"><?php echo $success; ?></div><?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">About / Mission</label>
                    <textarea class="form-control" name="about" rows="6" required><?php echo htmlspecialchars($about); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary px-4">Save</button>
            </form>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 