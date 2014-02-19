<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');





//$res =determineValue('B003UYTEN2');
//print_r($res);



function determineValue($asin){


	$resp= file_get_contents('http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Dapparel&field-keywords='.$asin);
	$res = split('<span class="s9Price red t11 nt2">', $resp);
	$product = $res[1];
	$theSplit = split('</', $product);
	$price= $theSplit[0];


	$response = array("status"=>"success", "price"=>$price);
		return $response;
	

}
?>