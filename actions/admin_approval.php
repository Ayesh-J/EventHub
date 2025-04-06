<?php
include '../config/db.php';
session_start();

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Approve admin request
if (isset($_GET['approve_id'])) {
    $approve_id = $_GET['approve_id'];
    $stmt = $conn->prepare("UPDATE users SET approval_status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $approve_id);
    $stmt->execute();
    echo "<script>alert('Admin approved successfully!'); window.location.href='approve_admins.php';</script>";
}

// Fetch pending admin requests
$result = $conn->query("SELECT id, name, email FROM users WHERE role='admin' AND approval_status='pending'");
?>

<h2>Pending Admin Approvals</h2>
<ul>
    <?php while ($admin = $result->fetch_assoc()): ?>
        <li>
            <?php echo htmlspecialchars($admin['name']); ?> (<?php echo htmlspecialchars($admin['email']); ?>) 
            <a href="?approve_id=<?php echo $admin['id']; ?>">Approve</a>
        </li>
    <?php endwhile; ?>
</ul>
