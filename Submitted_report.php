<?php
session_start();
include "db_conn.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: Log_in.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM reports WHERE user_id='$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $sql); // Select all the report that had been uplaoded by the user
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PLUS - Submitted Reports</title>
    <link rel="stylesheet" href="Submitted_report.css">
</head>

<body>

    <header>
        <div class="logo" onclick="window.location.href='Menu.php'">
            <img src="PlusLogo.png" alt="PLUS Logo">
        </div>

        <div class="header-controls">
            <div class="lang-search">
                <span class="lang-active">EN</span> | <span>BM</span> | <span class="search-icon">⚲</span>
            </div>
            <div class="plusline-btn">
                <span>✆ PLUSLine</span>
                <strong>1-800-88-0000</strong>
            </div>
        </div>
    </header>

    <div class="nav-container">
        <button class="nav-btn" onclick="window.location.href='Menu.php'">HOME</button>
        <button class="nav-btn" onclick="window.location.href='Report_form.php'">REPORT ACCIDENT</button>
        <button class="nav-btn" onclick="window.location.href='Report_search.php'">LIST</button>
        <button class="nav-btn" onclick="window.location.href='User_information.php'">ACCOUNT</button>
    </div>

    <div class="main-container">

        <h2 class="page-title">Submitted Report</h2>

        <div class="status-tabs">
            <div class="tab all">All</div>
            <div class="tab pending">Pending</div>
            <div class="tab reviewing">Reviewing</div>
            <div class="tab verified">Verified</div>
            <div class="tab rejected">Rejected</div> <!-- Display box status on top -->
        </div>

        <div class="report-list">

            <?php 
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { // Grab the status and priority from the databse 
                    $status = $row['status']; 
                    $priority = $row['priority']; 
            ?>
            <div class="report-card">
                <div class="card-content">
                    <div class="card-header">
                        <span><?php echo date("d F Y", strtotime($row['date'])); ?></span>
                        <span>Time Accident <?php echo date("H:i:s", strtotime($row['time'])); ?></span>
                    </div>

                    <div class="card-id">#<?php echo $row['id']; ?></div>

                    <div class="card-location"><?php echo $row['location']; ?></div>

                    <div class="card-detail">
                        <span class="priority-<?php echo strtolower($priority); ?>">[<?php echo $priority; ?>]</span>
                        <?php echo $row['type']; ?>: <?php echo $row['description']; ?>
                    </div>
                </div>

                <div class="status-bar status-<?php echo $status; ?>"></div> <!-- Change the status color -->
            </div>
            <?php 
                } 
            } else {
                echo "<div class='no-data'>No reports submitted yet.</div>";
            }
            ?>

        </div>
    </div>

</body>

</html>