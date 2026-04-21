<?php
$sname = "localhost"; //server name
$uname = "root"; // Username
$password = ""; //server pswd
$db_name = "plus_db";// databse name

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";// <- if failed to connect display
}
?>