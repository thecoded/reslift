<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');


//$results = seePurchases();
//print_r($results);

function seePurchases($limit=20){

	$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$userId= $_SESSION['userId'];
	$results = dbMassData("SELECT * FROM purchases LEFT JOIN inventory ON inventory.rId = purchases.itemId WHERE purchases.userId=$userId");
	// echo("SELECT * FROM purchases LEFT JOIN inventory ON inventory.rId = purchases.itemId WHERE purchases.userId=$userId");
	

	if($results != null){

		$response = array("status"=>"success", "resp"=>$results);
		return $response;
	}

	else{

		$response = array("status"=>"fail", "resp"=>"noResultsFound ");
		return $response;
	}
}

?>