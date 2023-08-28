<?php
session_start();

// Include your database connection code here
include 'db_connect.php';

// Check if the user is already authenticated
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: edit_main_info.php"); // Redirect to the edit page if already authenticated
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];

    // Retrieve the stored password hash from the secret table
    $query = "SELECT password_hash FROM secret WHERE 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password_hash = $row["password_hash"];

        // Verify the provided password against the stored hash
        if (md5($password) === $stored_password_hash) {
            $_SESSION['authenticated'] = true;
            header("Location: edit_main_info.php");
            exit();
        } else {
            $message = "Incorrect password. Please try again.";
        }
    } else {
        $message = "Error retrieving the stored password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS for styling -->
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <div class="container">
            <form action="login.php" method="post">
                <label for="password">Enter Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Login">
            </form>
            <p class="message"><?php echo isset($message) ? $message : ""; ?></p>
        </div>
    </main>
</body>
</html>
