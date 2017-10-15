<?php

$email_already_in_use_error_msg = "Email already in use<br>";
$email_format_error_msg = "Invalid format<br>";
$email_not_match_error_msg = "Emails don't match<br>";
$first_name_length_error_msg = "Your first name should be between 2 and 25 characters<br>";
$passwords_no_match_error_msg = "Passwords do not match<br>";
$password_length_error_msg = "Your password must be between 5 and 30 characters<br>";
$password_format_error_msg = "Your password can only contain english characters or numbers<br>";
$last_name_length_error_msg = "Your last name should be between 2 and 25 characters<br>";
$success_register_msg = "<span style='color:#14C800;'>You are all set! Go ahead and login</span><br>";

// Starts a session which stores the values 
session_start();

// root: username, no password by default
$connection = mysqli_connect("localhost", "root", "", "iaorana");

if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}

// Declaring variables to prevent errors
$fname = "";
$lname = "";
$em = "";
$em2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = array();

if(isset($_POST["register_button"])) {

    // strip tags takes the html away
    $fname = strip_tags($_POST["reg_fname"]);
    // remove spaces
    $fname = str_replace(" ", "", $fname);
    // convert the name to lowercase and then capitalize the first letter
    $fname = ucfirst(strtolower($fname));
    $_SESSION['reg_fname'] = $fname;

    $lname = strip_tags($_POST["reg_lname"]);
    $lname = str_replace(" ", "", $lname);
    $lname = ucfirst(strtolower($lname));
    $_SESSION['reg_lname'] = $lname;


    $em = strip_tags($_POST["reg_email"]);
    $em = str_replace(" ", "", $em);
    $_SESSION['reg_email'] = $em;


    $em2 = strip_tags($_POST["reg_email2"]);
    $em2 = str_replace(" ", "", $em2);
    $_SESSION['reg_email2'] = $em2;

    $password = strip_tags($_POST["reg_password"]);
    $_SESSION['reg_password'] = $password;

    $password2 = strip_tags($_POST["reg_password2"]);
    $_SESSION['reg_password2'] = $password2;

    $date = date("Y-m-d"); // Current date

    if($em == $em2) {

        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            // Check if email already exists
            $e_check = mysqli_query($connection, "SELECT email FROM users WHERE email='$em'");

            // Count number of rowns retured
            $num_rows = mysqli_num_rows($e_check);

            if ($num_rows > 0) {
                array_push($error_array, $email_already_in_use_error_msg);
            }

        } else {
            array_push($error_array, $email_format_error_msg);
        }

    } else {
        array_push($error_array, $email_not_match_error_msg);
    }

    if(strlen($fname) > 25 || strlen($fname) < 2) {
        array_push($error_array, $first_name_length_error_msg);
    }

    if(strlen($lname) > 25 || strlen($lname) < 2) {
        array_push($error_array, $last_name_length_error_msg);
    }

    if($password != $password2) {
        array_push($error_array, $passwords_no_match_error_msg);
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, $password_format_error_msg);
        }
    }

    if (strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array, $password_length_error_msg);
    }

    if(empty($error_array)) {
        $password = md5($password); // encrypt password

        // generate username 
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($connection, "SELECT username FROM users WHERE username='$username'");

        // Make sure the username is unique
        $i = 0;
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($connection, "SELECT username FROM users WHERE username='$username'");        
        }

        $rand = rand(1, 2);

        switch ($rand) {
            case 1:
                $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
                break;
            case 2:
                $profile_pic = "assets/images/profile_pics/defaults/head_alizarin.png";
                break;
            default:
                $profile_pic = "assets/images/profile_pics/defaults/head_alizarin.png";
                break;
        }
        
        $query = mysqli_query($connection, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',') ");
        array_push($error_array, $success_register_msg);

        // Make sure all variables are reset once registration is done
        $_SESSION["reg_fname"] = "";
        $_SESSION["reg_lname"] = "";
        $_SESSION["reg_email"] = "";
        $_SESSION["reg_email2"] = "";
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

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

</body>
</html>