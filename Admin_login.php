<?php
session_start();
include "db_conn.php";

if (isset($_POST['admin_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_name'] = $row['name'];
        
        
        header("Location: Admin_page.php");
        exit();
    } else {
        $error = "Access Denied: Incorrect Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLUS - Staff Login</title>
    <link rel="stylesheet" href="Admin_login.css">
</head>

<body>

    <div class="login-card">
        <img src="PlusLogo.png" alt="Logo" class="logo-img">
        <br>
        <span class="badge">Staff Portal</span>
        <h2>Admin Login</h2>

        <?php if (isset($error)) { ?>
        <div class="error-msg"><?php echo $error; ?></div>
        <?php } ?>

        <form method="post" action="Admin_login.php">
            <div class="form-group">
                <label>Admin ID</label>
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>

            <button type="submit" name="admin_login" class="btn-login">Access Dashboard</button>
        </form>

        <a href="Log_in.php" class="back-link">← Back to User Login</a>
    </div>

</body>

</html>