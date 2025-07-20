<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Add new event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $event_type_id = $_POST['event_type_id'];
    $event_date = $_POST['event_date'];

    $sql = "INSERT INTO event_requests (event_type_id, user_id, event_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $event_type_id, $user_id, $event_date);
    $stmt->execute();
    $stmt->close();
}

// View events
$events_sql = "SELECT er.event_request_id, et.event_type_name, er.event_date, er.status
               FROM event_requests er
               JOIN event_types et ON er.event_type_id = et.event_type_id
               WHERE er.user_id = ?";
$stmt = $conn->prepare($events_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$events_result = $stmt->get_result();
$stmt->close();

$event_types_sql = "SELECT * FROM event_types";
$event_types_result = $conn->query($event_types_sql);
?>

<?php include 'header.php'; ?>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
<a href="profile.php">Edit Profile</a> | <a href="logout.php">Logout</a>

<h3>My Events</h3>
<table>
    <tr>
        <th>Event Type</th>
        <th>Date</th>
        <th>Status</th>
    </tr>
    <?php while($row = $events_result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['event_type_name']); ?></td>
        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Add New Event</h3>
<form method="post" action="">
    Event Type: <select name="event_type_id" required>
        <?php while($row = $event_types_result->fetch_assoc()): ?>
        <option value="<?php echo $row['event_type_id']; ?>"><?php echo htmlspecialchars($row['event_type_name']); ?></option>
        <?php endwhile; ?>
    </select><br>
    Event Date: <input type="datetime-local" name="event_date" required><br>
    <input type="submit" name="add_event" value="Add Event">
</form>
<?php include 'footer.php'; ?>
