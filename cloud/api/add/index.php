<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');

include_once('/var/www/html/cloud/models/inventory/addProduct.php');


extract($_REQUEST);

$res = addProduct($name, $brand, $desc, $tags, $size, $madeIn, $condition, $num, $sku, 'pending', $estVal, $pic1, $pic2, $pic3, $pic4);

?>