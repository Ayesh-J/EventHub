<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['event_id'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

    $stmt = $conn->prepare("DELETE FROM event_registrations WHERE user_id = ? AND event_id = ?");
    $stmt->bind_param("ii", $user_id, $event_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration canceled.');
            window.location.href='../users/dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Something went wrong!');
            window.location.href='../users/dashboard.php';
        </script>";
    }
}
?>
