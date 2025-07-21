<?php
require_once 'templates/header.php';
require_once 'includes/functions.php';

$errors = [];

if (is_logged_in()) {
    redirect('dashboard.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $password = $_POST['password'];

    if (empty($email)) { $errors[] = "A valid email is required."; }
    if (empty($password)) { $errors[] = "Password is required."; }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT u.user_id, u.email, u.password, u.status, r.role_name
                                FROM users u
                                JOIN roles r ON u.role_id = r.role_id
                                WHERE u.email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] == 'approved') {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role_name'] = $user['role_name'];

                redirect('dashboard.php');
            } elseif ($user['status'] == 'pending') {
                $errors[] = "Your account is pending approval from an administrator.";
            } elseif ($user['status'] == 'rejected') {
                $errors[] = "Your account registration was rejected. Please contact support.";
            } else {
                 $errors[] = "Your account is inactive or suspended.";
            }
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<div class="form-container">
    <h2>Login to Your Account</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="text-center mt-3">
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
