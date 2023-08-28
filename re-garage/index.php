<?php
// Include your database connection code here
include 'db_connect.php';

// Retrieve main_info values
$query_main_info = "SELECT * FROM main_info WHERE id=1";
$result_main_info = $conn->query($query_main_info);

if ($result_main_info->num_rows > 0) {
    $row_main_info = $result_main_info->fetch_assoc();
    $banner_image_url = $row_main_info["image_url"];
    $main_title = $row_main_info["title"];
    $footer_urls = explode(",", $row_main_info["footer_urls"]);
}

// Retrieve all rows from projects table
$query_projects = "SELECT * FROM projects";
$result_projects = $conn->query($query_projects);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="main.css"> <!-- Updated CSS file name to main.css -->
</head>
<body>
    <header>
        <div class="banner">
            <img src="<?php echo $banner_image_url; ?>" alt="Banner Image">
            <h1><?php echo $main_title; ?></h1>
        </div>
    </header>
    <div class="main-content"> <!-- Main content div for the middle section -->
        <div class="container">
            <div class="projects-section">
                <h2>Projects</h2>
                <?php
                while ($row_project = $result_projects->fetch_assoc()) {
                ?>
                <div class="project-card">
                    <img src="<?php echo $row_project["image"]; ?>" alt="Project Image">
                    <div class="project-details">
                        <h3><?php echo $row_project["title"]; ?></h3>
                        <p class="description"><?php echo $row_project["description"]; ?></p>
                        <div class="progress-bar">
                            <div class="progress" style="width: <?php echo $row_project["progress"]; ?>%;">
                                <div class="progress-text">
                                    <?php echo $row_project["amount_collected"] . ' / ' . $row_project["amount_total"]; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <ul class="footer-links">
                <?php
                foreach ($footer_urls as $footer_url) {
                    echo "<li><a href=\"$footer_url\">$footer_url</a></li>";
                }
                ?>
            </ul>
            <p>&copy; <?php echo date("Y"); ?> Re Garage. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
