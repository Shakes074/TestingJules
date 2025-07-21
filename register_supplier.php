<?php
include 'db_connect.php';
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role_id = 3; // Supplier

    $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $password, $email, $role_id);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $supplier_name = $_POST['supplier_name'];
        $supplier_type_id = $_POST['supplier_type_id'];

        $supplier_sql = "INSERT INTO suppliers (supplier_name, supplier_type_id, user_id) VALUES (?, ?, ?)";
        $supplier_stmt = $conn->prepare($supplier_sql);
        $supplier_stmt->bind_param("sii", $supplier_name, $supplier_type_id, $user_id);
        $supplier_stmt->execute();
        $supplier_stmt->close();

        $message = "Registration successful! You can now <a href='login.php'>login</a>.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$supplier_types_sql = "SELECT * FROM supplier_types";
$supplier_types_result = $conn->query($supplier_types_sql);
?>
<?php include 'header.php'; ?>
<h2>Register as a Supplier</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Email: <input type="email" name="email" required><br>
    Supplier Name: <input type="text" name="supplier_name" required><br>
    Supplier Type: <select name="supplier_type_id" required>
        <?php while($row = $supplier_types_result->fetch_assoc()): ?>
        <option value="<?php echo $row['supplier_type_id']; ?>"><?php echo $row['supplier_type_name']; ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="submit" value="Register">
</form>
<p><?php echo $message; ?></p>
<?php include 'footer.php'; ?>
