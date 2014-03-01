<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/dbShortcuts.php');
include_once('/var/www/html/cloud/models/db/session.php');


extract($_REQUEST);



if(isset($liId)){

	//$userEdits = dbMassData("SELECT * FROM userEdits WHERE userId = '$userId' ORDER BY timestamp DESC LIMIT 1");
	//echo(json_encode($userEdits[0]));
	$userEdits = dbMassData("SELECT * FROM userEdits WHERE linkedInId='$liId' ORDER BY timestamp DESC LIMIT 1");
	echo(json_encode($userEdits[0]));
}
else{

	return;
}

?>