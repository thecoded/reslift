<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');

include_once('/var/www/html/cloud/models/inventory/search.php');


//ini_set('display_errors',1); 
 //error_reporting(E_ALL);

extract($_REQUEST);
session_start();
if(!isset($action)){
	$resp = json_encode(array("status"=>"fail", "reason"=>"please send action"));
	echo($resp);
	return;
}
if($action=="search"){

	$results1 = search($query);
   
	//$results = array("status"=>"success", "resp"=>$results1);
	
	echo(json_encode($results1));

	return;

}

if($action=="uploads"){

	$results1 = getMy();
   
	//$results = array("status"=>"success", "resp"=>$results1);
	
	echo(json_encode($results1));

	return;

}

?>