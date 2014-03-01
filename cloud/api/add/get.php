<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/dbShortcuts.php');
include_once('/var/www/html/cloud/models/db/session.php');


extract($_REQUEST);



if(isset($userId)&&  ($fbId=="" || !isset($fbId))){

	//$userEdits = dbMassData("SELECT * FROM userEdits WHERE userId = '$userId' ORDER BY timestamp DESC LIMIT 1");
	//echo(json_encode($userEdits[0]));
}
else if(isset($userId)&& isset($fbId)){

	$userEdits = dbMassData("SELECT * FROM userEdits WHERE fbId='$fbId'  ORDER BY timestamp DESC LIMIT 1");
	echo(json_encode($userEdits[0]));
}
else if(!isset($userId)&& isset($fbId)){

	$userEdits = dbMassData("SELECT * FROM userEdits WHERE fbId='$fbId' ORDER BY timestamp DESC LIMIT 1");
	echo(json_encode($userEdits[0]));
}
else{

	return;
}

?>