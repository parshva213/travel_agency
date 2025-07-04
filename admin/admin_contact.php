<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}
require_once '../includes/db_connect.php';
if (isset($_POST['mark_read'])) {
    $stmt = $pdo->prepare('UPDATE contact_messages SET status = ? WHERE id = ?');
    $stmt->execute(['read', (int)$_POST['id']]);
}
if (isset($_POST['mark_replied'])) {
    $stmt = $pdo->prepare('UPDATE contact_messages SET status = ? WHERE id = ?');
    $stmt->execute(['replied', (int)$_POST['id']]);
}
$stmt = $pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC');
$messages = $stmt->fetchAll();
include '../includes/header.php';
include 'includes/admin_navbar.php';
?>
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Messages</h4>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $m): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($m['name']); ?></td>
                            <td><?php echo htmlspecialchars($m['email']); ?></td>
                            <td><?php echo htmlspecialchars($m['subject']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($m['message'])); ?></td>
                            <td><?php echo date('M j, Y', strtotime($m['created_at'])); ?></td>
                            <td><span class="badge bg-<?php
                                switch ($m['status']) {
                                    case 'new': echo 'warning'; break;
                                    case 'read': echo 'info'; break;
                                    case 'replied': echo 'success'; break;
                                    default: echo 'light';
                                }
                            ?>"><?php echo ucfirst($m['status']); ?></span></td>
                            <td>
                                <?php if ($m['status'] === 'new'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                        <button type="submit" name="mark_read" class="btn btn-sm btn-outline-info">Mark Read</button>
                                    </form>
                                <?php endif; ?>
                                <?php if ($m['status'] !== 'replied'): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                        <button type="submit" name="mark_replied" class="btn btn-sm btn-outline-success">Mark Replied</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 