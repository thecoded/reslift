<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');
include_once('/var/wwww/html/cloud/models/login/login.php');

//register('mike', 'm@140ventures11111121.com', 'popcorn1');


function register($name, $email, $password){


	
	//check for user table
	//if it doesn't exist, create it (first time this script is run)


	//validation
	if(!isset($email)){
		$response = array("status"=>"fail", "resp"=>"Please send afRegEmail ");

		return $response;
	}
	if(!isset($name)){
		$response = array("status"=>"fail", "resp"=>"Please send a afRegName ");

		return $response;
	}

	if(!isset($password)){
		$response = array("status"=>"fail", "resp"=>"Please send a afRegPassword ");

		return $response;
	}



	//encrpyt password
	$password=md5($password);
	$ipAddress=$_SERVER['REMOTE_ADDR'];
	//echo('ip='.$ipAddress);

	$allUsers = dbMassData("SELECT * FROM users WHERE email = '$email'");
	if($allUsers==null){
		dbQuery("INSERT INTO users (name, email, password, ipAddress) VALUES ('$name', '$email', '$password', '$ipAddress')");
		

		$resp = array("status"=>"success");
		//now login user
		return $resp;

	
		

		//return $response;

	}

	else{
		$response = array("status"=>"fail", "resp"=>"emailTaken");

		
		return $response;


	}
}

?>