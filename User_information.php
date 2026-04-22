<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: Log_in.php");
    exit();
}

$id = $_SESSION['user_id'];
$message = ""; // To store success/error messages

// --- HANDLER: Update Profile (Text & Image) ---
if (isset($_POST['update_profile'])) {
    
    // 1. Sanitize text inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);

    // 2. Handle Image Upload
    $image_update_query = "";
    
    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != "") {
        $target_dir = "uploads/";
        // Create unique filename to prevent overwriting: id_timestamp.ext
        $image_ext = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
        $new_filename = $id . "_" . time() . "." . $image_ext;
        $target_file = $target_dir . $new_filename;
        $uploadOk = 1;

        // Check file type
        if($image_ext != "jpg" && $image_ext != "png" && $image_ext != "jpeg" && $image_ext != "gif" ) {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // Prepare SQL snippet for image
                $image_update_query = ", profile_image = '$new_filename'";
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // 3. Update Database
    if (empty($message)) { // Only update if no upload errors
        $sql_update = "UPDATE users SET 
                       name='$name', 
                       password='$password', 
                       phone='$phone', 
                       address='$address', 
                       postcode='$postcode' 
                       $image_update_query 
                       WHERE id='$id'";

        if (mysqli_query($conn, $sql_update)) {
            $message = "Profile updated successfully!";
            // Refresh to see changes
            header("Refresh:0"); 
        } else {
            $message = "Error updating record: " . mysqli_error($conn);
        }
    }
}

// --- FETCH USER DATA ---
$sql = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found!";
    exit();
}

// Determine profile picture to display
$profile_pic = !empty($user['profile_image']) ? "uploads/" . $user['profile_image'] : "Amanpak.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PLUS - User Profile</title>
    <link rel="stylesheet" href="User_information.css">
    <style>
        /* Add some basic style for the file input to be hidden */
        #fileInput { display: none; }
        .avatar-wrapper { cursor: pointer; }
        .message-box { text-align: center; color: green; font-weight: bold; margin-bottom: 10px; }
    </style>
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
        <button class="nav-btn active" onclick="window.location.href='User_information.php'">ACCOUNT</button>
    </div>

    <div class="main-container">
        <form action="" method="POST" enctype="multipart/form-data" class="profile-card">
            
            <h1 class="page-title">User <span>Profile</span></h1>
            
            <?php if($message): ?>
                <div class="message-box"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="profile-layout">
                <div class="left-col">
                    
                    <input type="file" id="fileInput" name="profile_image" accept="image/*" onchange="previewImage(this)">
                    
                    <div class="avatar-wrapper" onclick="document.getElementById('fileInput').click()">
                        <div class="avatar" id="avatarPreview" style="background-image: url('<?php echo $profile_pic; ?>');"></div>
                        <div class="edit-icon">✎</div>
                    </div>

                    <button type="button" class="btn-submitted-report" onclick="window.location.href='Submitted_report.php'">SUBMITTED REPORT</button>
                    <button type="button" class="btn-logout" onclick="window.location.href='Logout.php'">LOG OUT</button>
                </div> 

                <div class="right-col">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="<?php echo $user['name']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" value="<?php echo $user['password']; ?>" id="passwordInput">
                            <span class="toggle-password" onclick="togglePass()">👁️</span>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label>Phone number</label>
                        <input type="text" name="phone" value="<?php echo $user['phone']; ?>">
                    </div>

                    <div class="form-group full-width">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>" readonly style="background-color:#eee; cursor:not-allowed;">
                    </div>

                    <div class="form-group full-width">
                        <label>Address</label>
                        <input type="text" name="address" value="<?php echo $user['address']; ?>">
                    </div>

                    <div class="form-group full-width">
                        <label>Postcode</label>
                        <input type="text" name="postcode" value="<?php echo $user['postcode']; ?>">
                    </div>
                </div>
            </div>

            <button type="submit" name="update_profile" class="btn-confirm">Confirm</button>
        </form>
    </div>

    <script>
    function togglePass() {
        var x = document.getElementById("passwordInput"); 
        if (x.type === "password") { // Eye function change from astris to text
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    // New Function to preview image immediately after selection
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').style.backgroundImage = "url('" + e.target.result + "')";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</body>
</html>