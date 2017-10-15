<?php

// root: username, no password by default
$connection = mysqli_connect("localhost", "root", "", "iaorana");

if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}

$query = mysqli_query($connection, "INSERT INTO test VALUES ('1', 'Lois')");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hello World!</title>
</head>
<body>
<h1>This is a test.</h1>
</body>
</html>