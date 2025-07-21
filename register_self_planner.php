<?php
include 'db_connect.php';
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role_id = 1; // Event Planner (Self Planner)

    $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $password, $email, $role_id);

    if ($stmt->execute()) {
        $message = "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<?php include 'header.php'; ?>
<h2>Register as a Self Planner</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Email: <input type="email" name="email" required><br>
    <input type="submit" value="Register">
</form>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>
