<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// Fetch all events
$eventQuery = $conn->prepare("SELECT id, title, description, event_date FROM events ORDER BY event_date ASC");

if (!$eventQuery) {
    die("Query preparation failed: " . $conn->error);
}

$eventQuery->execute();
$events_result = $eventQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Available Events</h2>

    <!-- Show "Add Event" Button for Admins Only -->
    <?php if ($user_role === 'admin') : ?>
        <button><a href="add_event.php">Add Event</a></button>
    <?php endif; ?>

    <ul>
        <?php
        if ($events_result->num_rows > 0) {
            while ($event = $events_result->fetch_assoc()) {
                echo "<li>
                        <a href='event_details.php?id={$event['id']}'>" . htmlspecialchars($event['title']) . "</a> 
                        - " . htmlspecialchars($event['event_date']) . "
                        ";
                // Show "Register" Button for Students Only
                if ($user_role === 'student') {
                    echo "<form method='POST' action='register_event.php' style='display:inline;'>
                              <input type='hidden' name='event_id' value='{$event['id']}'>
                              <button type='submit'>Register</button>
                          </form>";
                }
                echo "</li>";
            }
        } else {
            echo "<li>No events available.</li>";
        }
        ?>
    </ul>

    <button><a href="dashboard.php">Back to Dashboard</a></button>
</body>
</html>
