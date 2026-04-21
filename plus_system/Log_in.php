<?php
session_start();//Session Cookies
include "db_conn.php"; // connect to the database

if (isset($_POST['email']) && isset($_POST['password'])) { //check if the form actually sumbitted
    
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']); // prevent coding

   
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result); // Check in the database for matches 
        
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email']; // save into the browser memories

        header("Location: Menu.php"); // direct user to the menu page
        exit();
    } else {
        $error = "Incorrect Email or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLUS - Login</title>
    <link rel="stylesheet" href="Log_in.css" >
</head>
<body>

    <div class="left-panel"> <!-- page split in half -->
        <h2>Welcome <span class="welcome-green">Back !</span></h2>
        <h1>Log In</h1>

        <?php if (isset($error)) { ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php } ?>

        <div id="js-error-container" class="error-msg hidden"></div>

        <form action="Log_in.php" method="post" id="loginForm" novalidate>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your Password" required>
            </div>

            <button type="submit" class="btn-login">Log In</button>
        </form>
        
        <p style="margin-top: 20px; text-align: center; font-size: 14px;">
            Don't have an account? <a href="Sign_up.php" style="color:#009e60; text-decoration:none; font-weight:bold;">Sign Up</a>
        </p>
    </div>

    <div class="right-panel"> <!-- Hidden button for the admin -->
        <div class="logo-box">
            <a href="Admin_login.php" title="Admin Access">
        <img src="PlusLogo.png" alt="PLUS Logo">
    </a>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() { // Validation cehck if the button clicked 
            const form = document.getElementById('loginForm');    
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const errorContainer = document.getElementById('js-error-container');

            form.addEventListener('submit', function(e) {
                let errors = [];
                
                
                const emailValue = emailInput.value.trim();
                const passwordValue = passwordInput.value.trim();
                
            
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (emailValue === "") {
                    errors.push("Email is required.");
                } else if (!emailPattern.test(emailValue)) {
                    errors.push("Please enter a valid email address.");
                }

               
                if (passwordValue === "") {
                    errors.push("Password is required.");
                } else if (passwordValue.length < 6) {
                    
                    errors.push("Password must be at least 6 characters.");
                }
                
                if (errors.length > 0) {
                    e.preventDefault(); // if empty, display error
                    
                    
                    errorContainer.innerHTML = errors.join('<br>');
                    errorContainer.classList.remove('hidden');
                } else {
                
                    errorContainer.classList.add('hidden');
                    
                }
            });
        });
    </script>

</body>
</html>