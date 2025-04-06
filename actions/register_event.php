<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../users/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];

    // Collect participant details
    $college_name = $_POST['college_name'] ?? '';
    $team_name = $_POST['team_name'] ?? '';
    $participant_name = $_POST['participant_name'] ?? '';
    $member_names = $_POST['member_names'] ?? '';

    // Basic sanitization
    $college_name = trim($college_name);
    $team_name = trim($team_name);
    $participant_name = trim($participant_name);
    $member_names = trim($member_names);

    // Check if user already registered for the event
    $checkStmt = $conn->prepare("SELECT * FROM event_registrations WHERE user_id = ? AND event_id = ?");
    $checkStmt->bind_param("ii", $user_id, $event_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Already registered
        echo "<script>alert('You are already registered for this event!'); window.location.href='../users/dashboard.php';</script>";
    } else {
        // Insert registration with participant details
        $registerStmt = $conn->prepare("
            INSERT INTO event_registrations (user_id, event_id, college_name, team_name, participant_name, member_names)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $registerStmt->bind_param("iissss", $user_id, $event_id, $college_name, $team_name, $participant_name, $member_names);

        if ($registerStmt->execute()) {
            echo "<script>alert('Registered successfully!'); window.location.href='../users/dashboard.php';</script>";
        } else {
            echo "<script>alert('Something went wrong while registering.'); window.location.href='../users/dashboard.php';</script>";
        }

        $registerStmt->close();
    }

    $checkStmt->close();
    $conn->close();
} else {
    header("Location: ../users/dashboard.php");
    exit();
}
