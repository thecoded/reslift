<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/dbShortcuts.php');
include_once('/var/www/html/cloud/models/db/session.php');


extract($_REQUEST);


$tableName = 'userEdits';
$fieldsArr = $_REQUEST;
$checkExists = false;
$print=true;
$checkAdded=false;
$updateBool=false;
$addNewFields=true;

rollAdd($tableName, $fieldsArr, $checkExists, $print ,$checkAdded, $updateBool, $addNewFields);


?>