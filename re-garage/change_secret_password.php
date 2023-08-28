<?php
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Include your database connection code here
include 'db_connect.php';

// Initialize variables
$newPassword = "";
$confirmPassword = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and update the secret password
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the new password matches the confirmation
    if ($newPassword === $confirmPassword) {
        // Update the secret password in the 'secret' table
        $hashedPassword = md5($newPassword);
        $query = "UPDATE secret SET password_hash = '$hashedPassword'";
        if ($conn->query($query)) {
            $success_message = "Secret password changed successfully.";
        } else {
            $error_message = "Error updating secret password: " . $conn->error;
        }
    } else {
        $error_message = "Passwords do not match.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css"> <!-- Add your admin CSS file -->
    <title>Change Secret Password</title>
</head>
<body>
    <div class="form-container">
        <h1>Change Secret Password</h1>
        <form method="POST">
            <label for="newPassword" class="form-label">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" class="form-input" required>

            <label for="confirmPassword" class="form-label">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="form-input" required>

            <button type="submit" class="form-button">Change Password</button>
        </form>
        <?php if (!empty($success_message)) { ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
</body>
</html>
