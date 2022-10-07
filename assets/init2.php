<?php
include('config.php');

//Initiate MySQL connection
$MySQLiTest = new MySQLi($host, $dbuser, $dbpasswd, $dbtestname);

if($MySQLiTest->connect_error) {
	die("Can't connect to test database. Please check the connection details.");
}
//Include classes
#include('classes/class.security.php');
#$security = new Security($MySQLi);

include('classes/class.admin2.php');
$admin = new Admin($MySQLiTest);





