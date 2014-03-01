<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
//include_once('/var/www/html/cloud/models/db/session.php');

include_once('/var/www/html/cloud/models/login/getUserInfo.php');


echo json_encode(getUserInfo());
?>