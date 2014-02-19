<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');





//$res = buyCredits(300);

//print_r($res);

function buyCredits($howMany){


		$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$userId= $_SESSION['userId'];


	
	dbQuery("INSERT INTO payments(amount, userId, status) VALUES ($howMany, $userId, 'notRecieved') ");

	
	$response = array("status"=>"success", "rId"=>"payment pending");
		return $response;
	
}
?>