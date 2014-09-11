<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "rhssn";
$db_name = "emis";
$prefix = "";
$connection = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Database Connection Failed" . mysql_error());
$db = mysql_select_db($db_name, $connection) or die("Database Selection Failed" . mysql_error());
?>