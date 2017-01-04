<?php
$mysqli_host ='localhost';
$mysqli_user ='root';
$mysqli_pass ='12345';
$mysqli_db   ='takemore';

if(!@$conn = mysqli_connect($mysqli_host, $mysqli_user, $mysqli_pass, $mysqli_db)) {
    die(mysqli_error());
}
?>
