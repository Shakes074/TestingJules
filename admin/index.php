<?php
require_once '../templates/header.php';
require_once '../includes/functions.php';

// Protect this page
if (!has_role('Admin')) {
    redirect('logout.php');
}

// Handle user approval/rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['action'])) {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $action = $_POST['action']; // 'approve' or 'reject'

    if ($user_id && ($action === 'approve' || $action === 'reject')) {
        $new_status = ($action === 'approve') ? 'approved' : 'rejected';
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE user_id = ? AND status = 'pending'");
        $stmt->bind_param("si", $new_status, $user_id);
        $stmt->execute();
        $stmt->close();
        // TODO: Send notification email to user
    }
}


// Fetch pending users
$stmt = $conn->prepare("SELECT u.user_id, u.first_name, u.last_name, u.email, r.role_name, u.created_at
                        FROM users u
                        JOIN roles r ON u.role_id = r.role_id
                        WHERE u.status = 'pending'
                        ORDER BY u.created_at ASC");
$stmt->execute();
$pending_users = $stmt->get_result();
$stmt->close();
?>

<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</p>

    <div class="card">
        <div class="card-header">
            <h4>Pending User Registrations</h4>
        </div>
        <div class="card-body">
            <?php if ($pending_users->num_rows > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $pending_users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <form action="index.php" method="post" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="index.php" method="post" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                        <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">No pending user registrations.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Other admin functionalities can be added here -->

</div>

<?php require_once '../templates/footer.php'; ?>
