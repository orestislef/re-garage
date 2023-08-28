<?php
session_start();

// Include your database connection code here
include 'db_connect.php';

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Redirect to the login page if not authenticated
    exit();
}

// Handle form submission to update main_info
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_url = $_POST["image_url"];
    $title = $_POST["title"];
    $footer_urls = $_POST["footer_urls"];

    // Check if a record with id=1 already exists
    $check_query = "SELECT * FROM main_info WHERE id=1";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Record with id=1 exists, update it
        $stmt = $conn->prepare("UPDATE main_info SET image_url=?, title=?, footer_urls=? WHERE id=1");
    } else {
        // Record with id=1 does not exist, insert a new record
        $stmt = $conn->prepare("INSERT INTO main_info (id, image_url, title, footer_urls) VALUES (1, ?, ?, ?)");
    }

    // Use prepared statements to prevent SQL injection
    $stmt->bind_param("sss", $image_url, $title, $footer_urls);

    if ($stmt->execute()) {
        $message = "Main Info updated successfully.";
    } else {
        $message = "Error updating Main Info: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve current main_info values
$query = "SELECT * FROM main_info WHERE id=1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_image_url = $row["image_url"];
    $current_title = $row["title"];
    $current_footer_urls = $row["footer_urls"];
} else {
    $current_image_url = "";
    $current_title = "";
    $current_footer_urls = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Main Info</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS for styling -->
</head>
<body>
    <header>
        <h1>Edit Main Info</h1>
    </header>
    <main>
        <div class="container">
            <form action="edit_main_info.php" method="post">
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" value="<?php echo $current_image_url; ?>" required><br><br>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $current_title; ?>" required><br><br>

                <label for="footer_urls">Footer URLs (comma-separated):</label>
                <input type="text" id="footer_urls" name="footer_urls" value="<?php echo $current_footer_urls; ?>"><br><br>

                <input type="submit" value="Save">
            </form>
            <a class="logout" href="logout.php">Logout</a>
        </div>
        <p class="message"><?php echo isset($message) ? $message : ""; ?></p>
    </main>
</body>
</html>
