<?php
include 'db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];

    $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $password, $email, $role_id);

    if ($stmt->execute()) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$roles_sql = "SELECT * FROM user_roles";
$roles_result = $conn->query($roles_sql);
?>

<?php include 'header.php'; ?>
<h2>Register</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Email: <input type="email" name="email" required><br>
    Role: <select name="role_id" required>
        <?php while($row = $roles_result->fetch_assoc()): ?>
        <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Register">
</form>
<p><?php echo $message; ?></p>
<p>Already have an account? <a href="login.php">Login here</a></p>
<?php include 'footer.php'; ?>
