<?php 
ob_start();
session_start();
error_reporting(0); 

require("database/connect.inc.php");
require("functions/function.php");
require("TCPDF/tcpdf.php");
?>