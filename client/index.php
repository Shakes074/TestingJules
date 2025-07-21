<?php
require_once '../templates/header.php';
require_once '../includes/functions.php';

// Protect this page
if (!has_role('Client')) {
    redirect('logout.php');
}
?>

<div class="container mt-4">
    <h2>Client Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</p>

    <div class="alert alert-info">
        <p>Your dashboard is under construction. Soon you will be able to:</p>
        <ul>
            <li>View your upcoming events in a calendar.</li>
            <li>Plan new standalone or procedural events.</li>
            <li>Manage payments and view your event history.</li>
            <li>Rate service providers after an event.</li>
        </ul>
    </div>

    <!-- Placeholder for calendar view -->
    <div class="card">
        <div class="card-header">
            <h4>Upcoming Events</h4>
        </div>
        <div class="card-body">
            <p class="text-center">Calendar will be displayed here.</p>
        </div>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>
