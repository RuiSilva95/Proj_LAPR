<?php 
$mysql_host ='mysql.1freehosting.com';
$mysql_user ='u209499245_admin';
$mysql_pass ='rafte1';
$mysql_db   ='u209499245_take';

if(!@mysql_connect($mysql_host,$mysql_user,$mysql_pass) || !@ mysql_select_db($mysql_db)){
	die(mysql_error());
}
?>