<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');





//$res = editProduct(1, 'itemDesc', 'this was edited by editProduct');
//print_r($res);

function editProduct($productId, $whichField, $whichEdit, $editedBy=1){


		$userInfo = getUserInfo();
	if($userInfo == false){

		return "notSignedIn";
	}

	$userId= $_SESSION['userId'];


	
	dbQuery("UPDATE inventory SET $whichField = '$whichEdit' WHERE rId = $productId");
  // echo("INSERT INTO inventory (itemName, itemDesc, tags, uploadedById, brand, condition1, size, from1, number, amount, sku) VALUES('$name', '$desc', '$tags', '$userId', '$brand', '$condition', '$size', '$from', '$number', '$amount', '$sku') ");
	$response = array("status"=>"success", "resp"=>"itemEdited");

		
		return $response;
	
}
?>