<?php
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css"> <!-- Add your admin CSS file -->
    <title>Admin Endpoints</title>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome to the Admin Endpoints</h1>
        <div class="dashboard-links">
            <a href="edit_main_info.php">Edit Main Info</a>
            <a href="index.php">View Main Info</a>
            <a href="add_project.php">Add Project</a>
            <a href="admin_dashboard.php">Admin Dashboard</a>
            <a href="change_secret_password.php">Change Secret Password</a>
        </div>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>
