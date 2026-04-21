<?php
session_start();
include "db_conn.php";


if (!isset($_SESSION['user_id'])&& !isset($_SESSION['admin_id'])) {
    header("Location: Log_in.php"); // If user hasnt logged in, user will be redirect back to the log in page
    exit();
}


if (isset($_GET['id'])) { // Look for id 
    $report_id = $_GET['id']; // Grab the id
    
    
    $sql = "SELECT * FROM reports WHERE id='$report_id'"; //Choose the report that match the user id
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); 

    if (!$row) {
        echo "Report not found!";
        exit();
    }
} else {
    echo "No Report ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PLUS - Full Report #<?php echo $row['id']; ?></title>
    <link rel="stylesheet" href="Full_report.css">
</head>

<body>

    <header>
        <div class="logo" onclick="window.location.href='Menu.php'">
            <img src="PlusLogo.png" alt="PLUS Logo">
        </div>
        <div class="header-controls">
            <div class="lang-search">
                <span style="color:#0056b3">EN</span> | <span>BM</span> | <span>⚲</span>
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
        <button class="nav-btn" style="background-color:#1b4f3e; border:2px solid white; transform:scale(1.05);"
            onclick="window.location.href='Report_search.php'">LIST</button>
        <button class="nav-btn" onclick="window.location.href='User_information.php'">ACCOUNT</button>
    </div>

    <div class="main-container">
        <div class="report-card">

            <div class="status-badge st-<?php echo $row['status']; ?>">
                <!-- Display report status and the color -->
                <?php echo $row['status']; ?>
            </div>

            <h2>Incident Report #<?php echo $row['id']; ?></h2>

            <div class="details-grid">
                <div>
                    <div class="info-group">
                        <div class="info-label">Date of Incident</div>
                        <div class="info-value"><?php echo date("d F Y", strtotime($row['date'])); ?></div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Time</div>
                        <div class="info-value"><?php echo date("H:i:s", strtotime($row['time'])); ?></div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Incident Type</div>
                        <div class="info-value"><?php echo $row['type']; ?></div>
                    </div>
                </div>

                <div>
                    <div class="info-group">
                        <div class="info-label">Location (KM Mark)</div>
                        <div class="info-value"><?php echo $row['location']; ?></div>
                    </div>

                    <div class="info-group">
                        <div class="info-label">Priority Level</div>
                        <div class="info-value" style="color:var(--plus-green);"><?php echo $row['priority']; ?></div>
                    </div>
                </div>

                <div class="evidence-box">
                    <div class="info-label">Photo Evidence</div>
                    <?php if (!empty($row['image'])): ?>
                    <!-- Ask if the image column is empty -->
                    <img src="uploads/<?php echo $row['image']; ?>" alt="Report Evidence" class="evidence-img">
                    <?php else: ?>
                    <div
                        style="padding:20px; background:#f9f9f9; color:#888; text-align:center; font-style:italic; border-radius:8px;">
                        No photo evidence provided for this report.
                    </div>
                    <?php endif; ?>
                </div>

                <div class="description-box">
                    <div class="info-label">Description</div>
                    <p style="margin: 5px 0 0 0; line-height: 1.6;"><?php echo $row['description']; ?></p>
                </div>
            </div>

            <?php if (isset($_SESSION['admin_id'])) { ?>
            <a href="Admin_page.php" class="btn-back">← Back to Dashboard</a>
            <?php } else { ?>
            <a href="Report_search.php" class="btn-back">← Back to List</a>
            <?php } ?>

        </div>
    </div>

</body>

</html>