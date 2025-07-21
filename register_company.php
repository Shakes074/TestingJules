<?php
// Assuming "Company" is a larger entity that might manage multiple service providers or have different needs.
// For now, we'll create them as a Service Provider role, but this can be adapted.
require_once 'templates/header.php';
require_once 'includes/functions.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_id = 3; // Using Service Provider role for now. Could be a new role ID e.g. 5 for 'Company'.
    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
    $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING));
    $company_name = trim(filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING));

    if (empty($company_name)) { $errors[] = "Company name is required."; }
    if (empty($first_name)) { $errors[] = "Contact person's first name is required."; }
    if (empty($last_name)) { $errors[] = "Contact person's last name is required."; }
    if (empty($email)) { $errors[] = "A valid business email is required."; }
    if (empty($password) || strlen($password) < 8) { $errors[] = "Password must be at least 8 characters long."; }
    if ($password !== $confirm_password) { $errors[] = "Passwords do not match."; }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "An account with this email already exists.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $otp = generate_otp();
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("INSERT INTO users (role_id, first_name, last_name, email, password, phone_number, otp, otp_expires_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $role_id, $first_name, $last_name, $email, $hashed_password, $phone_number, $otp, $otp_expiry);
            $stmt->execute();
            $user_id = $stmt->insert_id;
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO service_providers (user_id, company_name) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $company_name);
            $stmt->execute();
            $stmt->close();

            send_otp_email($email, $otp);
            $conn->commit();
            $_SESSION['registration_email'] = $email;
            redirect('verify_otp.php');
        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<div class="form-container">
    <h2>Register as a Company</h2>
    <p>Create a corporate account to manage your services and team.</p>
    <?php if (!empty($errors)) { echo "<div class='alert alert-danger'>" . implode("<br>", $errors) . "</div>"; } ?>
    <form action="register_company.php" method="post">
        <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" class="form-control" id="company_name" name="company_name" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">Primary Contact First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Primary Contact Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Company Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Company Phone Number</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Register</button>
    </form>
</div>

<?php require_once 'templates/footer.php'; ?>
