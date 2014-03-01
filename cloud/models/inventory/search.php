<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');


//$results = search('purse');
//print_r($results);

function search($keyword, $limit=20){

	

	$results = dbMassData("SELECT * FROM inventory WHERE tags LIKE '%$keyword%' ORDER BY timestamp DESC LIMIT $limit");

	if($results!= null){

		$response = array("status"=>"success", "resp"=>$results);
		return $response;
	}

	else{

		$response = array("status"=>"fail", "resp"=>"noResultsFound ");
		return $response;
	}
}



function getMy(){
	$limit=50;
	session_start();
	$userId = $_SESSION['userId'];
		
	if(!isset($userId)){
		$response = array("status"=>"fail", "resp"=>"notSignedIn ");
		return $response;
	}

	$results = dbMassData("SELECT * FROM inventory WHERE uploadedByID ='$userId' ORDER BY timestamp DESC LIMIT $limit");

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