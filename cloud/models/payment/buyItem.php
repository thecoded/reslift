<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');





//$res = buyItem(1);

//print_r($res);


function buyItem($whichItem){


		$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$userId= $_SESSION['userId'];


	
	dbQuery("INSERT INTO purchases(itemId, userId, status) VALUES ($whichItem, $userId, 'pending') ");

	
	$response = array("status"=>"success", "rId"=>"purchases pending for item #" . $whichItem);
		return $response;
	
}
?>