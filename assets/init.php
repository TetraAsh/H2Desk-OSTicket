<?php
include('config.php');

//Initiate MySQL connection
$MySQLi = new MySQLi($host, $dbuser, $dbpasswd, $dbname);
$MySQLiOS = new MySQLi($host, $dbuser, $dbpasswd, $dbnewname);
$MySQLiTest = new MySQLi($host, $dbuser, $dbpasswd, $dbtestname);

if($MySQLi->connect_error) {
	#die("Can't connect to database. Please check the connection details.");
}
if($MySQLiOS->connect_error) {
	#die("Can't connect to database ostickets. Please check the connection details.");
}
if($MySQLiTest->connect_error) {
	die("Can't connect to test database. Please check the connection details.");
}
//Include classes
#include('classes/class.security.php');
#$security = new Security($MySQLi);

include('classes/class.admin.php');
$admin = new Admin($MySQLi, $MySQLiOS, $MySQLiTest );





