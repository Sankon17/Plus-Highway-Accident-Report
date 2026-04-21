<?php
session_start(); // Load the user saved data


if (!isset($_SESSION['user_id'])) {
    header("Location: Log_in.php"); //if the user have not log in, 
    exit();                                 //the user will be redirect to the log in page
}

$name = $_SESSION['user_name']; // get the user name and put it into the variable
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PLUS - Dashboard</title>
    <link rel="stylesheet"href="Menu.css">
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
        <button class="nav-btn active" onclick="window.location.href='Menu.php'">HOME</button>
        <button class="nav-btn" onclick="window.location.href='Report_form.php'">REPORT ACCIDENT</button>
        <button class="nav-btn" onclick="window.location.href='Report_search.php'">LIST</button>
        <button class="nav-btn" onclick="window.location.href='User_information.php'">ACCOUNT</button>
    </div>

    <div class="main-container">
        <div class="scrollable-content">

            <section class="welcome-section">
                <h2>👋 Welcome Back, <?php echo $name ?> </h2>
                <p>PLUS Highway Accident Reporting System. A platform to report and monitor highway accidents in real
                    time.</p>
                <button class="nav-btn" style="font-size:14px; padding: 10px 20px;"
                    onclick="window.location.href='Report_form.php'">REPORT NOW</button>
            </section>

            <div class="dashboard-grid">
                <div class="info-card">
                    <h3 style="margin-top:0;">Why This System?</h3>
                    <p>⚡ Faster accident reporting</p>
                    <p>🛡️ Improve highway safety</p>
                    <p>⏱️ Real-time updates</p>
                </div>

                <div class="latest-accidents">
                    <h3 style="margin-top:0;">Latest Alerts ❗</h3>

                    <div class="accident-item">
                        <div>
                            <span class="tag">COLLISION</span>
                            <div style="font-size: 12px; margin-top:5px;">KM 201.1 Northbound</div>
                        </div>
                        <button class="nav-btn" style="padding: 5px 15px; font-size:12px; min-width:auto;"
                            onclick="window.location.href='Full_report.php'">View</button>
                    </div>

                    <div class="accident-item">
                        <div>
                            <span class="tag">BREAKDOWN</span>
                            <div style="font-size: 12px; margin-top:5px;">KM 67.7 Northbound</div>
                        </div>
                        <button class="nav-btn" style="padding: 5px 15px; font-size:12px; min-width:auto;"
                            onclick="window.location.href='Full_report.php'">View</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>