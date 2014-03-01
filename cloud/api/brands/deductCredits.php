<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');

//include_once('/var/www/html/cloud/models/inventory/discover.php');


//ini_set('display_errors',1); 
 //error_reporting(E_ALL);

extract($_REQUEST);
session_start();


$email=$_SESSION['email'];
$amount=$_REQUEST['amount'];
$userInfo= dbMassData("SELECT * FROM users WHERE email = '$email'");

	$credits = $userInfo[0]['approvedCredits'];
	$credits= floatval($credits);
	$amount = floatval($amount);
	$credits= $credits-$amount;
	dbQuery("UPDATE users SET approvedCredits = '$credits' WHERE email = '$email' ");

echo('credits deducted');

?>