<?php

	include_once('db2.php');
	include_once('dbShortcuts.php');
	include_once('emailer.php');

	extract($_REQUEST);
	if(!isset($siteUrl)){

		echo($_GET['callback']."(".json_encode(array("result"=>"fail", "reason"=>"Please send a site URL, idiot!")).")");
		return;
	}

	//get all fields
	$elems= $_REQUEST;


	
	echo $_GET['callback'] . '(' . "{'result' : 'success'}" . ')';
	
	//unset variables in array for clean inclusion of just form data
	unset($elems['callback']);

	//save the email of form recipient before unsetting
	$base4Email= $elems['base4Email'];
	unset($elems['base4Email']);


	//add to db
	rollAdd($siteUrl, $elems, false, false ,false, false, true);

	//send email

	$subject="New form submission from your site";
	$htmlContent="";
	foreach($elems as $key =>$value){

		$htmlContent .=$key. ": ". $value."<br>";
	}
	$textContent= str_replace("<br>", "\r\n", $htmlContent);

	sendTheMail($base4Email, $subject, $htmlContent, $textContent);









	

?>