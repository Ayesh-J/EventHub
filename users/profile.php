<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>

<h2>Student Profile</h2>
<p>Welcome, <?php echo $_SESSION['user_name']; ?>!</p>
<p><a href="logout.php">Logout</a></p>
