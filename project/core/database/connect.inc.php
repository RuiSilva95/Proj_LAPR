<?php
$mysqli_host ='127.0.0.1';
$mysqli_user ='root';
$mysqli_pass ='12345';
$mysqli_db   ='take';

if(!@$conn = mysqli_connect($mysqli_host, $mysqli_user, $mysqli_pass, $mysqli_db)) {
    die(mysqli_error());
}
?>
