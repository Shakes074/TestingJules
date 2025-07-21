<?php
// Database Configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'event_planning_sprint');

// Establish database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn->connect_error){
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Site URL
define('SITE_URL', 'http://localhost/event-planning-sprint/'); // Adjust this to your project URL

// PHPMailer settings (for OTP, will be configured later)
// define('SMTP_HOST', 'smtp.example.com');
// define('SMTP_USERNAME', 'user@example.com');
// define('SMTP_PASSWORD', 'password');
// define('SMTP_PORT', 587);

?>
