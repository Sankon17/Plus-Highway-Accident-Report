<?php
session_start();
include "db_conn.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: Log_in.php");
    exit();
}

$search = "";
$type_filter = "";
$date_filter = "";


$sql = "SELECT * FROM reports WHERE status = 'Reviewed'"; // Display all verified report from the databse


if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " AND (location LIKE '%$search%' OR description LIKE '%$search%')";
}


if (isset($_GET['type']) && !empty($_GET['type'])) {
    $type_filter = $_GET['type'];
    $sql .= " AND type = '$type_filter'";
}

if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date_filter = $_GET['date'];
    
    $sql .= " AND date = '$date_filter'";
}


$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLUS - Public Report List</title>
    <link rel="stylesheet" href="Report_search.css" >
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
        <button class="nav-btn active" onclick="window.location.href='Report_search.php'">LIST</button>
        <button class="nav-btn" onclick="window.location.href='User_information.php'">ACCOUNT</button>
    </div>

    <div class="main-container">

        <aside class="sidebar">
            <h3>Filter reports</h3>

            <form method="GET" action="Report_search.php"> <!-- when button apply clicked
                                                            it will allow PHP to read choices -->

                <div class="filter-group">
                    <label>Search</label>
                    <input type="text" name="search" placeholder="Loc or Desc..."
                        value="<?php echo htmlspecialchars($search); ?>">
                </div>

                <div class="filter-group">
                    <label>Incident</label>
                    <select name="type">
                        <option value="">All Types</option>
                        <option value="Accident" <?php if($type_filter == 'Accident') echo 'selected'; ?>>Accident
                        </option>
                        <option value="Pothole" <?php if($type_filter == 'Pothole') echo 'selected'; ?>>Pothole</option>
                        <option value="Obstruction" <?php if($type_filter == 'Obstruction') echo 'selected'; ?>>
                            Obstruction</option>
                        <option value="Facility Damage" <?php if($type_filter == 'Facility Damage') echo 'selected'; ?>>
                            Facility Damage</option> <!-- The page will saved choince -->
                    </select>
                </div>

                <div class="filter-group">
                    <label>Date</label>
                    <input type="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>">
                </div>

                <button type="submit" class="btn-apply">Apply</button>

                <a href="Report_search.php" class="btn-reset">Reset</a> <!-- reload and reset the filter -->
            </form>
        </aside>

        <section class="content-area">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { // create a row for every report 
                            $formatted_date = date("d F Y", strtotime($row['date']));
                            ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $formatted_date; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><a href="Full_report.php?id=<?php echo $row['id']; ?>" class="view-link">View</a></td> 
                    </tr>                                <!-- add the view button -->
                    <?php
                        }
                    } else {
                        echo "<tr class='no-data-row'><td colspan='6'>No reports match your filters.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

    </div>

</body>

</html>