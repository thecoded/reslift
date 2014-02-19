<?php

/*
 * Simple script to create necessary tables for running this app
 * Please ensure that the database parameters in ../app/boostrap.php
 * are correct and that the necessary db privileges have been granted
 */

echo "Creating mysql tables" . PHP_EOL;
if(!extension_loaded('mysql')) {
	echo "Please enable the mysql extension to run this app" . PHP_EOL;
	exit(1);
}

require_once __DIR__ . '/../app/bootstrap.php';


$link = @mysql_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD);
if(!$link) {
	 echo 'Could not connect to mysql ' . mysql_error() . PHP_EOL;
	 exit(1);
}
if(!mysql_select_db(MYSQL_DB, $link)) {
	echo 'Could not select database ' . mysql_error() . PHP_EOL;
	exit(1);
}

$sql = @file_get_contents(__DIR__ . "/db.sql");
$statements = explode(';', $sql);
foreach($statements as $query) {
	if($query) {
		echo "Executing statement:" .  $query . PHP_EOL;
		mysql_query($query) or die(mysql_error());
	}
}
echo PHP_EOL . "Database creation complete" . PHP_EOL;