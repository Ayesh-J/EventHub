<?php
include '../config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Default role is 'student'
    $role = 'student';
    $approval_status = 'approved'; // Students are auto-approved

    // If a user selects "Admin," require approval
    if (isset($_POST['role']) && $_POST['role'] === 'admin') {
        $role = 'admin';
        $approval_status = 'pending'; // New admins require approval
    }

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.location.href='register.php';</script>";
        exit();
    } 

    // Insert user with approval status
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, approval_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $role, $approval_status);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Admin accounts require approval.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close prepared statements
    $checkEmail->close();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="container">
    <h2>Register</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <!-- Role selection for all users -->
        <select name="role">
            <option value="student">Student</option>
            <option value="admin">Admin</option>
        </select><br>

        <button type="submit">Register</button>
        <p class="R-link">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>
</body>
</html>
