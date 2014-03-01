<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');





//$res = addProduct('DKNY jeans', 'DKNY', 'awesome', 'dkny, jeans', '32','China', '2', '2', '0000', 'pending', '300');

//print_r($res);

function addProduct($name, $brand, $desc, $tags, $size, $from="china", $condition, $number, $sku, $status='prending', $amount, $pic1, $pic2, $pic3, $pic4){


		$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$userId= $_SESSION['userId'];


	
	dbQuery("INSERT INTO inventory (itemName, itemDesc, tags, uploadedById, brand, condition1, size, from1, number, amount, sku, pic1, pic2, pic3, pic4) VALUES('$name', '$desc', '$tags', '$userId', '$brand', '$condition', '$size', '$from', '$number', '$amount', '$sku', '$pic1', '$pic2', '$pic3', '$pic4') ");
  // echo("INSERT INTO inventory (itemName, itemDesc, tags, uploadedById, brand, condition1, size, from1, number, amount, sku) VALUES('$name', '$desc', '$tags', '$userId', '$brand', '$condition', '$size', '$from', '$number', '$amount', '$sku') ");
	$response = array("status"=>"success", "resp"=>"itemAdded");

		
		return $response;
	
}
?>