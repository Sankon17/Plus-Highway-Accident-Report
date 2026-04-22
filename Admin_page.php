<?php
session_start();
include "db_conn.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: Admin_login.php");
    exit();
}


if (isset($_POST['update_status'])) {
    $report_id = $_POST['report_id'];
    $new_status = $_POST['new_status'];
    
    $update_sql = "UPDATE reports SET status='$new_status' WHERE id='$report_id'"; // Update the status when admin click the button
    mysqli_query($conn, $update_sql);
    
   
    header("Location: Admin_page.php");
    exit();
}


$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Action Needed';

if ($filter == 'All') {
    $sql = "SELECT reports.*, users.name as reporter_name 
            FROM reports 
            JOIN users ON reports.user_id = users.id 
            ORDER BY reports.id DESC";
} else {
   
    $sql = "SELECT reports.*, users.name as reporter_name 
            FROM reports 
            JOIN users ON reports.user_id = users.id 
            WHERE reports.status IN ('Pending', 'Reviewing') 
            ORDER BY reports.id ASC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PLUS - Admin Dashboard</title>
    <link rel="stylesheet" href="Admin_page.css">
</head>

<body>

    <header>
        <div class="admin-logo">
            <img src="PlusLogo.png" alt="PLUS">
            <span class="admin-title">ADMINISTRATION PANEL</span>
        </div>
        <div>
            <span style="margin-right: 15px; font-size: 12px;">Logged in as:
                <?php echo $_SESSION['admin_name']; ?></span>
            <a href="Logout.php" class="logout-btn">LOG OUT</a>
        </div>
    </header>

    <div class="container">

        <div class="toolbar">
            <h2>Report Management</h2>
            <div class="filter-tabs">
                <a href="Admin_page.php?filter=Action" class="<?php echo ($filter!='All')?'active':''; ?>">⚠ Action
                    Needed</a>
                <a href="Admin_page.php?filter=All" class="<?php echo ($filter=='All')?'active':''; ?>">📄 All
                    Reports</a>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Evidence</th>
                        <th>Reporter</th>
                        <th>Date/Time</th>
                        <th>Location</th>
                        <th>Type/Priority</th>
                        <th>Status</th>
                        <th width="250">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $status = $row['status'];
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>

                        <td>
                            <?php if(!empty($row['image'])) { ?>
                            <a href="uploads/<?php echo $row['image']; ?>" target="_blank">
                                <img src="uploads/<?php echo $row['image']; ?>" class="thumbnail">
                            </a>
                            <?php } else { echo "<span style='color:#ccc; font-size:10px;'>No Img</span>"; } ?>
                        </td>

                        <td><?php echo $row['reporter_name']; ?></td>

                        <td>
                            <?php echo $row['date']; ?><br>
                            <span style="font-size:11px; color:#888;"><?php echo $row['time']; ?></span>
                        </td>

                        <td><?php echo $row['location']; ?></td>

                        <td>
                            <?php echo $row['type']; ?><br>
                            <span
                                style="font-size:11px; font-weight:bold; color:var(--admin-dark);">[<?php echo $row['priority']; ?>]</span>
                        </td>

                        <td><span class="badge st-<?php echo $status; ?>"><?php echo $status; ?></span></td>

                        <td>
                            <a href="Full_report.php?id=<?php echo $row['id']; ?>" class="btn-view" 
                                target="_blank">View</a> <!-- Send admin the full report page of the report id -->

                            <?php if ($status == 'Pending') { ?>
                            <form method="POST" class="action-form">
                                <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="new_status" value="Reviewing">
                                <button type="submit" name="update_status" class="btn-action btn-verify">Start
                                    Review</button>
                            </form>

                            <?php } elseif ($status == 'Reviewing') { ?>
                            <form method="POST" class="action-form">
                                <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="new_status" value="Reviewed">
                                <button type="submit" name="update_status" class="btn-action btn-approve">✔
                                    Verify</button>
                            </form>

                            <form method="POST" class="action-form">
                                <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="new_status" value="Rejected">
                                <button type="submit" name="update_status" class="btn-action btn-reject">✖
                                    Reject</button>
                            </form>
                            <?php } else { ?>
                            <span style="font-size:11px; color:#aaa;">Completed</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center; padding:30px; color:#888;'>No reports found requiring action.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>