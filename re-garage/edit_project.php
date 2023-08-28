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
$project_id = "";
$title = "";
$description = "";
$amount_collected = "";
$amount_total = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Retrieve project details by ID
    $project_id = $_GET['id'];
    $query = "SELECT * FROM projects WHERE id = $project_id";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $amount_collected = $row['amount_collected'];
        $amount_total = $row['amount_total'];
    } else {
        $error_message = "Project not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and update project details
    $project_id = $_POST['project_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $amount_collected = $_POST['amount_collected'];
    $amount_total = $_POST['amount_total'];

    // Update project details in the database
    $query = "UPDATE projects SET title = ?, description = ?, amount_collected = ?, amount_total = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiii", $title, $description, $amount_collected, $amount_total, $project_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Error updating project: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css"> <!-- Add your admin CSS file -->
    <title>Edit Project</title>
</head>
<body>
    <div class="form-container">
        <h1>Edit Project</h1>
        <form method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" name="title" class="form-input" value="<?php echo $title; ?>" required>

            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description" class="form-textarea" required><?php echo $description; ?></textarea>

            <label for="amount_collected" class="form-label">Amount Collected:</label>
            <input type="number" id="amount_collected" name="amount_collected" class="form-input" value="<?php echo $amount_collected; ?>" required>

            <label for="amount_total" class="form-label">Amount Total:</label>
            <input type="number" id="amount_total" name="amount_total" class="form-input" value="<?php echo $amount_total; ?>" required>

            <button type="submit" class="form-button">Save Changes</button>
        </form>
        <?php if (!empty($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
</body>
</html>
