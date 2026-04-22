<?php
include "db_conn.php";
//opens the connection to the database

if (isset($_POST['signup'])) {
// Check if user click the sign up button    
   
    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    } // unable coding in text input

    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $postcode = sanitize($_POST['postcode']);
    $pass = $_POST['password']; 
    $re_pass = $_POST['re_password'];
    //collect variable and store in PHP

   
    if ($pass !== $re_pass) {
        $error = "The confirmation password does not match"; //Check if the password match
    } else {
        
        $sql_check = "SELECT * FROM users WHERE email='$email'";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "The email is already taken, please try another";
        } else {
            
            $sql = "INSERT INTO users(name, email, password, phone, address, postcode) 
                    VALUES('$name', '$email', '$pass', '$phone', '$address', '$postcode')"; 
                    //insert user information into the database
            
            $result = mysqli_query($conn, $sql);

            if ($result) {
                
                header("Location: Log_in.php?success=Account created successfully");
                exit();
            } else {
                $error = "Unknown error occurred";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLUS - Sign Up</title>
    <link rel="stylesheet" href="Sign_up.css" >
    
</head>

<body>

    <div class="left-panel">
        <h1>Sign up</h1>
        <p class="subtitle">If you already have an account register<br>You can <a href="Log_in.php"
                style="color:#009e60; font-weight:bold; text-decoration:none;">Login here !</a></p>

        <?php if (isset($error)) { ?>
        <div class="error-msg"><?php echo $error; ?></div>
        <?php } ?>

        <div id="js-error-container" class="error-msg hidden"></div>

        <form action="Sign_up.php" method="post" id="signupForm" novalidate>
            <!-- process the code -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" id="name" placeholder="Enter your User name" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="Enter your phone number">
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" id="address" placeholder="Residential Address">
            </div> <!-- Input type, name in PHP, name for css & javasript, display text -->

            <div class="form-group">
                <label>Postcode</label>
                <input type="text" name="postcode" id="postcode" placeholder="e.g. 54000">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your Password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="re_password" id="re_password" placeholder="Confirm your Password" required>
            </div>

            <button type="submit" name="signup" class="btn-signup">Register</button>
        </form>
    </div>

    <div class="right-panel">
        <div class="logo-box">
            <img src="PlusLogo.png" alt="PLUS Logo">
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() { // When button register clicked, check error
        const form = document.getElementById('signupForm');
        const errorContainer = document.getElementById('js-error-container');


        const email = document.getElementById('email');
        const name = document.getElementById('name');
        const phone = document.getElementById('phone');
        const postcode = document.getElementById('postcode');
        const password = document.getElementById('password');
        const re_password = document.getElementById('re_password');

        form.addEventListener('submit', function(e) {
            let errors = [];


            [email, name, phone, postcode, password, re_password].forEach(input => {
                input.classList.remove('input-error');
            });

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value.trim())) {
                errors.push("Invalid email address.");
                email.classList.add('input-error');
            }

            if (name.value.trim() === "") {
                errors.push("Username is required.");
                name.classList.add('input-error');
            }

            if (phone.value.trim() !== "") {
                const phonePattern = /^[0-9]{9,12}$/;
                if (!phonePattern.test(phone.value.trim())) {
                    errors.push("Phone number must contain only digits (9-12 digits).");
                    phone.classList.add('input-error');
                }
            }

            if (postcode.value.trim() !== "") {
                const postPattern = /^[0-9]{5}$/;
                if (!postPattern.test(postcode.value.trim())) {
                    errors.push("Postcode must be exactly 5 numbers (e.g., 54000).");
                    postcode.classList.add('input-error');
                }
            }

            if (password.value.length < 6) {
                errors.push("Password must be at least 6 characters long.");
                password.classList.add('input-error');
            }


            if (password.value !== re_password.value) {
                errors.push("Passwords do not match.");
                re_password.classList.add('input-error');
            }


            if (errors.length > 0) {
                e.preventDefault();
                errorContainer.innerHTML = errors.join('<br>');
                errorContainer.classList.remove('hidden');


                document.querySelector('.left-panel').scrollTop = 0;
            } else {
                errorContainer.classList.add('hidden');
            }
        });
    });
    </script>
</body>

</html>