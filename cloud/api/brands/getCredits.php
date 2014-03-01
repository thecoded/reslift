<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');

//include_once('/var/www/html/cloud/models/inventory/discover.php');


//ini_set('display_errors',1); 
 //error_reporting(E_ALL);

extract($_REQUEST);
session_start();
if(!isset($_SESSION['email'])){

	echo(json_encode(array("status"=>"fail", "reason"=>"userNotSignIn")));
	return;
}
//echo('sdsd');
$email = $_SESSION['email'];
$userCred=dbMassData("SELECT * FROM users WHERE email = '$email'");
$credits = $userCred[0]['approvedCredits'];
echo(json_encode(array("status"=>"success", "credits"=>''.$credits.'')));


?>