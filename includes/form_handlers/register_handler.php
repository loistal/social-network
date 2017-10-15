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
$login_error_msg = "Email or password was incorrect<br>";

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