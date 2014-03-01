<?php

include_once('/var/www/html/cloud/models/db/db.php');

function getUserInfo(){

	session_start();
	if(!isset($_SESSION['uId'])){

		return false;
	}
	else{

		return($_SESSION);
	}
}

?>