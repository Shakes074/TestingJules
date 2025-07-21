<?php
require_once '../templates/header.php';
require_once '../includes/functions.php';

// Protect this page
if (!has_role('Service Provider')) {
    redirect('logout.php');
}
?>

<div class="container mt-4">
    <h2>Service Provider Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</p>

     <div class="alert alert-info">
        <p>Your dashboard is under construction. Soon you will be able to:</p>
        <ul>
            <li>Manage your daily and weekly event limits and set a break day.</li>
            <li>View and respond to incoming booking requests.</li>
            <li>Showcase your services by uploading photos and videos.</li>
            <li>Manage payments and rate clients.</li>
        </ul>
    </div>

    <!-- Placeholder for booking management -->
    <div class="card">
        <div class="card-header">
            <h4>Incoming Booking Requests</h4>
        </div>
        <div class="card-body">
            <p class="text-center">Incoming requests will be displayed here.</p>
        </div>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>
