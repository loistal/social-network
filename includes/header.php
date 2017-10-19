<?php
require "config/config.php";

if (isset($_SESSION["username"])) {
    $userLoggedIn = $_SESSION["username"];
    $userDetailsQuery = mysqli_query($connection, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($userDetailsQuery);
} else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Hello World!</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css">
</head>
<body>

    <div class="top_bar">
        <div class="logo">
            <a href="index.php">
                Iaorana
            </a>
        </div>

        <nav>
            <a href="<?php

                echo $userLoggedIn;

             ?>"><?php

                echo $user["firstName"];

             ?></i>
            </a>
            <a href="index.php"><i class="fa fa-home fa-2x" aria-hidden="true"></i>
            </a>
            <a href="#"><i class="fa fa-comments-o fa-2x" aria-hidden="true"></i>
            </a>
            <a href="#"><i class="fa fa-globe fa-2x" aria-hidden="true"></i>
            </a>
            <a href="#"><i class="fa fa-users fa-2x" aria-hidden="true"></i>
            </a>
            <a href="#"><i class="fa fa-cog fa-2x" aria-hidden="true"></i>
            </a>
            <a href="includes/handlers/logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>
            </a>
        </nav>
    </div>

    <div class="wrapper">