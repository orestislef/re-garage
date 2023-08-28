<?php
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Include your database connection code here
include 'db_connect.php';

// Retrieve the list of projects from the 'projects' table
$query_projects = "SELECT * FROM projects";
$result_projects = $conn->query($query_projects);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css"> <!-- Add your admin CSS file -->
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        <a href="logout.php">Logout</a> <!-- Create a logout page to destroy the session -->
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Progress</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result_projects->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['progress']; ?></td>
                    <td>
                        <a href="edit_project.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_project.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
