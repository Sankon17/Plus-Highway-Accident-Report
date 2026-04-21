<?php
session_start();
include "db_conn.php"; // save the data in this database

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Run if only user click submit button
    
    
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

    
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location']; //Collect variable
    $type = $_POST['type'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];
    
    
    $new_img_name = ""; // default

    if (isset($_FILES['evidence_photo']) && $_FILES['evidence_photo']['error'] === 0) {
        $img_name = $_FILES['evidence_photo']['name']; // Box for file uploads
        $tmp_name = $_FILES['evidence_photo']['tmp_name'];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION); //Allow format file jpg,png, jpeg
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png"); 

        if (in_array($img_ex_lc, $allowed_exs)) {
            
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc; // Create a random unique name for the file
            $img_upload_path = 'uploads/' . $new_img_name; // saved in in the UPLOAD file
            
            
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true); //make an UPLOAD File for the picture to ve stored
            }
            
            move_uploaded_file($tmp_name, $img_upload_path);
        }
    }

    
    $sql = "INSERT INTO reports (user_id, date, time, location, type, priority, description, image) 
            VALUES ('$user_id', '$date', '$time', '$location', '$type', '$priority', '$description', '$new_img_name')";
            // Insert data into the database

    if (mysqli_query($conn, $sql)) {
        header("Location: Submitted_report.php"); //Direct user to the submitted report page
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>