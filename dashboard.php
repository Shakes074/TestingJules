<?php
require_once 'templates/header.php';
require_once 'includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

// Redirect user to their specific dashboard based on role
$role_name = $_SESSION['role_name'];

switch ($role_name) {
    case 'Admin':
        redirect('admin/index.php');
        break;
    case 'Client':
        redirect('client/index.php');
        break;
    case 'Service Provider':
        redirect('provider/index.php');
        break;
    default:
        // If role is not set or invalid, logout and redirect to login
        redirect('logout.php');
        break;
}

// This page should ideally not be reached. The header template could also contain this logic.
echo "<p>Redirecting you to your dashboard...</p>";

require_once 'templates/footer.php';
?>
