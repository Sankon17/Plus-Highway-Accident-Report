<?php
session_start(); //Check which user id


session_unset(); //Emptu all the variable


session_destroy(); //Kill the connection between the user browser with the database


header("Location: Log_in.php"); //Direct user to the database
exit();
?>