<?php
session_start();

// Include your database connection code here
include 'db_connect.php';

if (isset($_POST['password'])) {
    $password = $_POST['password'];

    // Verify the password against the one stored in the 'secret' table
    $query_secret = "SELECT password_hash FROM secret WHERE password_hash = MD5('$password')";
    $result_secret = $conn->query($query_secret);

    if ($result_secret->num_rows > 0) {
        // Password is correct, set session variable to indicate authentication
        $_SESSION['authenticated'] = true;
        header('Location: admin_dashboard.php'); // Redirect to the admin dashboard
        exit();
    } else {
        $error_message = "Invalid password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css"> <!-- Add your admin CSS file -->
    <title>Admin Login</title>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="POST">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
