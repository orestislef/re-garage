<?php
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Include your database connection code here
include 'db_connect.php';

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Retrieve the project details from the 'projects' table
    $query_project = "SELECT * FROM projects WHERE id = $project_id";
    $result_project = $conn->query($query_project);

    if ($result_project->num_rows === 1) {
        $row_project = $result_project->fetch_assoc();

        // Handle deletion confirmation
        if (isset($_POST['confirm_delete'])) {
            // Delete the project from the database
            $delete_query = "DELETE FROM projects WHERE id = $project_id";

            if ($conn->query($delete_query) === TRUE) {
                // Redirect to the admin dashboard after successful deletion
                header('Location: admin_dashboard.php');
                exit();
            } else {
                $error_message = "Error deleting project: " . $conn->error;
            }
        } elseif (isset($_POST['cancel'])) {
            // Redirect back to the admin dashboard if cancel is clicked
            header('Location: admin_dashboard.php');
            exit();
        }
    } else {
        // Handle the case where the provided project ID doesn't exist
        echo "Project not found.";
        exit();
    }
} else {
    // Handle the case where no project ID is provided in the URL
    echo "Invalid request.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css"> <!-- Add your admin CSS file -->
    <title>Delete Project</title>
</head>
<body>
    <div class="dashboard-container">
        <h1>Delete Project</h1>
        <a href="admin_dashboard.php">Back to Dashboard</a>
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
        <p>Are you sure you want to delete the project "<?php echo $row_project['title']; ?>"?</p>
        <form method="POST">
            <button type="submit" name="confirm_delete">Yes, Delete</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>
</body>
</html>
