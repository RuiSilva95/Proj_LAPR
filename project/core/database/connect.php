<?php
// SEM BASE DE DADOS
die();
$servername = "";
$username = "";
$password = "";
$database = "";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
