<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');

include_once('/var/www/html/cloud/models/login/login.php');


include_once('/var/www/html/cloud/models/login/register.php');


extract($_REQUEST);
if(!isset($action)){

	echo('send action');
	return;
}

if(!isset($email)){

	echo('send email');
	return;
}
switch($action){

	case "login":
		$res=loginUser($email, $password);
		echo(json_encode($res));
		return;
	break;


	case "register":
		$res=register($name, $email, $password);
		if($res['status']=="success"){
				sleep(1);
		$res=loginUser($email, $password);
		echo(json_encode($res));
		return;
		}
		else{

			echo"issue";
		}
		

	break;

	default:
		"send action";
		return;
	break;

	
}
?>