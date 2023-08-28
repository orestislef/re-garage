<?php
session_start();

// Include your database connection code here
include 'db_connect.php';

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Redirect to the login page if not authenticated
    exit();
}

// Handle form submission to add a project
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_url = $_POST["image_url"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $progress = $_POST["progress"];
    $amount_collected = $_POST["amount_collected"];
    $amount_total = $_POST["amount_total"];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO projects (image, title, description, progress, amount_collected, amount_total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiis", $image_url, $title, $description, $progress, $amount_collected, $amount_total);

    if ($stmt->execute()) {
        $message = "Project added successfully.";
    } else {
        $message = "Error adding project: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS for styling -->
</head>
<body>
    <header>
        <h1>Add Project</h1>
    </header>
    <main>
        <div class="container">
            <?php if (isset($message)) : ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="add_project.php" method="post">
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" required><br><br>

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea><br><br>

                <label for="progress">Progress (%):</label>
                <input type="number" id="progress" name="progress" required><br><br>

                <label for="amount_collected">Amount Collected:</label>
                <input type="number" id="amount_collected" name="amount_collected" required><br><br>

                <label for="amount_total">Amount Total:</label>
                <input type="number" id="amount_total" name="amount_total" required><br><br>

                <input type="submit" value="Add Project">
            </form>
            <a class="logout" href="logout.php">Logout</a>
        </div>
    </main>
</body>
</html>
