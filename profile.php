<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $user_id);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $message = "Profile updated successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<?php include 'header.php'; ?>
<h2>Profile</h2>
<form method="post" action="">
    Username: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
    <input type="submit" value="Update Profile">
</form>
<p><?php echo $message; ?></p>
<a href="dashboard.php">Back to Dashboard</a>
<?php include 'footer.php'; ?>
