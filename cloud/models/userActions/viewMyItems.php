<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');


//$results = viewMyItems();
//print_r($results);

function viewMyItems($limit=20){

	$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	
		$userId= $_SESSION['userId'];
	$results = dbMassData("SELECT * FROM inventory WHERE uploadedById = '$userId' ORDER BY timestamp DESC LIMIT $limit");

	if($results!= null){

		$response = array("status"=>"success", "resp"=>$results);
		return $response;
	}

	else{

		$response = array("status"=>"fail", "resp"=>"noResultsFound ");
		return $response;
	}
}

?>