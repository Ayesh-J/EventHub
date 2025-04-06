<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../users/login.php");
    exit();
}

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']);

    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        echo "Failed to delete event: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../admin/dashboard.php");
    exit();
}
