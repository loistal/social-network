<?php
    require "config/config.php";
    require "includes/form_handlers/register_handler.php";
    require "includes/form_handlers/login_handler.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
</head>
<body>
    <div class="wrapper">
        <form action="register.php" method="POST">
            
            <input type="email" name="log_email" value="<?php 
            if(isset($_SESSION["log_email"])) {
                echo $_SESSION["log_email"];
            } ?>" placeholder="Email Address" required>
            <br>
            <input type="password" name="log_password" placeholder="Password">
            <br>
            <input type="submit" name="login_button" value="Login">
            <br>
            <?php 
                if(in_array($login_error_msg, $error_array)) {
                    echo $login_error_msg;
                }
             ?>

        </form>

        <form action="register.php" method="POST">

            <input type="text" name="reg_fname" placeholder="First Name" value="<?php 
            if(isset($_SESSION["reg_fname"])) {
                echo $_SESSION["reg_fname"];
            } ?>" required>
            <br>
            <?php if(in_array($first_name_length_error_msg, $error_array)) echo $first_name_length_error_msg; ?>

            <input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
            if(isset($_SESSION["reg_lname"])) {
                echo $_SESSION["reg_lname"];
            } ?>" required>
            <br>
            <?php if(in_array($last_name_length_error_msg ,$error_array)) echo $last_name_length_error_msg; ?>

            <input type="email" name="reg_email" placeholder="Email" value="<?php 
            if(isset($_SESSION["reg_email"])) {
                echo $_SESSION["reg_email"];
            } ?>" required>
            <br>
            <?php if(in_array($email_format_error_msg ,$error_array)) echo $email_format_error_msg; 
            else if(in_array($email_already_in_use_error_msg ,$error_array)) echo $email_already_in_use_error_msg; ?>

            <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
            if(isset($_SESSION["reg_email2"])) {
                echo $_SESSION["reg_email2"];
            } ?>" required>
            <br>
            <?php if(in_array($email_not_match_error_msg ,$error_array)) echo $email_not_match_error_msg; ?>

            <input type="password" name="reg_password" placeholder="Password" required>
            <br>
            <?php if(in_array($password_length_error_msg , $error_array)) echo $password_length_error_msg; 
            else if(in_array($password_format_error_msg , $error_array)) echo $password_format_error_msg; ?>

            <input type="password" name="reg_password2" placeholder="Confirm Password" required>
            <br>
            <?php if(in_array($passwords_no_match_error_msg , $error_array)) echo $passwords_no_match_error_msg; ?>

            <input type="submit" name="register_button" value="submit" required>
            <?php if(in_array($success_register_msg , $error_array)) echo $success_register_msg; ?>

        </form>
    </div>
</body>
</html>