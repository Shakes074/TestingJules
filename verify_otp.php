<?php
require_once 'templates/header.php';
require_once 'includes/functions.php';

$errors = [];
$success_message = '';

if (!isset($_SESSION['registration_email'])) {
    redirect('register.php');
}

$email = $_SESSION['registration_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = trim(filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING));

    if (empty($otp)) {
        $errors[] = "Please enter the OTP.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id, otp, otp_expires_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user) {
            $errors[] = "An error occurred. Please try registering again.";
        } elseif ($user['otp'] !== $otp) {
            $errors[] = "Invalid OTP.";
        } elseif (strtotime($user['otp_expires_at']) < time()) {
            $errors[] = "OTP has expired. Please request a new one.";
        } else {
            // OTP is correct, update user status to pending (awaiting admin approval)
            $stmt = $conn->prepare("UPDATE users SET status = 'pending', otp = NULL, otp_expires_at = NULL WHERE email = ?");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                unset($_SESSION['registration_email']);
                $success_message = "Email verified successfully! Your account is now awaiting admin approval. You will be notified via email once it's approved.";
            } else {
                $errors[] = "Failed to verify your account. Please try again.";
            }
            $stmt->close();
        }
    }
}
?>

<div class="form-container">
    <h2>Verify Your Email</h2>
    <p>An OTP has been sent to <strong><?php echo htmlspecialchars($email); ?></strong>. Please enter it below.</p>
    <p class="text-muted">(For development: Check the server logs for the OTP if email sending is disabled).</p>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="alert alert-success">
            <p><?php echo $success_message; ?></p>
        </div>
        <div class="text-center">
             <a href="login.php" class="btn btn-primary">Proceed to Login</a>
        </div>
    <?php else: ?>
        <form action="verify_otp.php" method="post">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter 6-Digit OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" maxlength="6" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Verify Account</button>
        </form>
        <div class="text-center mt-3">
            <p>Didn't receive the code? <a href="resend_otp.php">Resend OTP</a>.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'templates/footer.php'; ?>
