<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');


//$results = discover();
//print_r($results);



function discover($limit=50){

	$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$results = dbMassData("SELECT * FROM inventory WHERE discoverPage = 'true' ORDER BY timestamp DESC LIMIT $limit");

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