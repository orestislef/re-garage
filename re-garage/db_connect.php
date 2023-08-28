<?php
$servername = "localhost";
$username = "root";
$password = ""; // Empty password

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select your database
$db_name = "re_projects"; // Change to your database name
if (!mysqli_select_db($conn, $db_name)) {
    // If the database does not exist, you can create it here or handle the error accordingly.
    die("Database selection failed: " . mysqli_error($conn));
}

// Set character set (optional)
mysqli_set_charset($conn, "utf8");

// You can use this $conn object for executing SQL queries in your PHP scripts.

?>
