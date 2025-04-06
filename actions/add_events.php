<?php
include '../config/db.php';
session_start();

// Ensure only admins can access this page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = trim($_POST['event_date']);
    $event_time = trim($_POST['time']); // Using 'time' from form
    $venue = trim($_POST['venue']);
    $organizer = trim($_POST['organizer']);
    $max_participants = intval($_POST['max_participants']);

    if (empty($title) || empty($description) || empty($event_date) || empty($event_time) || empty($venue) || empty($organizer) || empty($max_participants)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, `time`, venue, organizer, max_participants) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $title, $description, $event_date, $event_time, $venue, $organizer, $max_participants);

        if ($stmt->execute()) {
            echo "<script>alert('Event added successfully!'); window.location.href='../admin/dashboard.php';</script>";
        } else {
            echo "<script>alert('Error adding event!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="../assets/css/add_events.css">
</head>
<body>
    <h2>Add Event</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Event Title" required>
        <textarea name="description" placeholder="Event Description" required></textarea>
        <input type="date" name="event_date" required>
        <input type="time" name="time" required>
        <input type="text" name="venue" placeholder="Venue" required>
        <input type="text" name="organizer" placeholder="Organizer" required>
        <input type="number" name="max_participants" placeholder="Max Participants" required>
        <button type="submit">Add Event</button>
    </form>
    <a href="../admin/dashboard.php">Back to Dashboard</a>
</body>
</html>
