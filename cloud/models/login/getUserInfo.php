<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');

//$resp = loginUser('m@140ventures.com', 'popcorn1');
//print_r($resp);
//print_r(getUserInfo());

	function getUserInfo(){


		session_start();
		if(isset($_SESSION['email'])){

			$email= $_SESSION['email'];
			$userInfo = dbMassData("SELECT * FROM users WHERE email = '$email'");
			$response = array("status"=>"success", "resp"=>$_SESSION);
			return $response;
		

		}

		else{
			$response = array("status"=>"fail", "resp"=>"notSignedIn");
			return $response;

		}
	}

?>