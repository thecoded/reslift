<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');
moreInfo(1);

function moreInfo($rId){

	$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$userId= $_SESSION['userId'];

	$results = dbMassData("SELECT * FROM inventory WHERE rId = '$rId' ORDER BY timestamp DESC LIMIT 1");

	if($results!= null){
		dbQuery("INSERT INTO productView(productId, userId) VALUES ($rId, $userId)");
		$response = array("status"=>"success", "resp"=>$results[0]);
		return $response;
	}

	else{

		$response = array("status"=>"fail", "resp"=>"noResultsFound ");
		return $response;
	}
}
?>