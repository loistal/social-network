<?php
ob_start(); // Turns on output buffering

// Starts a session which stores the values 
session_start();

$timezone = date_default_timezone_set("Pacific/Tahiti");

// root: username, no password by default
$connection = mysqli_connect("localhost", "root", "", "iaorana");

if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}

?>