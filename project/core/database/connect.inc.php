<?php
$mysqli_host ='127.0.0.1';
$mysqli_user ='root';
$mysqli_pass ='12345';
$mysqli_db   ='take';

$conn = mysqli_connect($mysqli_host, $mysqli_user, $mysqli_pass, $mysqli_db);

if(mysqli_connect_errno()) {
    die("Failed to connect:".mysqli_connect_error());
}
?>
