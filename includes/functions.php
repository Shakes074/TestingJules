<?php
// All helper functions will go here.

/**
 * Generates a random 6-digit OTP.
 *
 * @return string The generated OTP.
 */
function generate_otp() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

/**
 * Redirects to a specified page.
 *
 * @param string $url The URL to redirect to.
 * @return void
 */
function redirect($url) {
    header("Location: " . SITE_URL . $url);
    exit();
}

/**
 * Checks if a user is logged in.
 *
 * @return bool True if logged in, false otherwise.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Checks if the logged-in user has a specific role.
 *
 * @param string $role_name The name of the role to check (e.g., 'Admin').
 * @return bool True if the user has the role, false otherwise.
 */
function has_role($role_name) {
    if (!is_logged_in() || !isset($_SESSION['role_name'])) {
        return false;
    }
    return $_SESSION['role_name'] === $role_name;
}

/**
 * Placeholder function for sending OTP email.
 * In a real application, this would use a library like PHPMailer.
 *
 * @param string $to_email The recipient's email address.
 * @param string $otp The OTP to send.
 * @return bool True on success, false on failure.
 */
function send_otp_email($to_email, $otp) {
    $subject = "Your Verification Code";
    $message = "Your OTP for registration is: " . $otp;
    $headers = "From: no-reply@eventplannersaas.com";

    // For now, this will just simulate a successful send.
    // return mail($to_email, $subject, $message, $headers);
    error_log("OTP for $to_email: $otp"); // Log OTP for development
    return true;
}
?>
