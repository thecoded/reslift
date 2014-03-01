<?php

	include_once('/var/www/html/cloud/models/db/dbLib.php');
	include_once('/var/www/html/cloud/models/db/dbShortcuts.php');
	include_once('/var/www/html/cloud/models/db/session.php');

	extract($_REQUEST);

	if(!isset($keyword)){

		$keyword="developer";
	}
	if(!isset($city)){
		$city="newyork";
	}

	$url = 'http://'.$city.'.craigslist.org/search/?sort=date&areaID=3&catAbb=jjj&query='.$keyword;
	echo($url);
	$contents = file_get_contents($url);

	$posts = explode('<span class="date">', $contents);
	
	for($i=0; $i<count($posts); $i++){
		if($i>1){
			//echo($posts[$i]);
			
			$linkArr = explode('<a href="', $posts[$i]);
			$link = explode('"',$linkArr[1]);
			
			$link = $link[0];
			$link = 'http://'.$city.'.craigslist.org'. $link;
			echo($link);
			$postPage = file_get_contents($link);
			
			//<span class="star"></span>
			$titleArr = explode('<span class="star"></span>', $postPage);
			
			$title= explode("</h2>", $titleArr[1]);
			$title = $title[0];
			echo($title);
			echo('<br>');

			$bodyArr = explode('<section class="userbody">', $postPage);
			$body= explode("<footer>", $bodyArr[1]);
			$body = $body[0];
			echo($body);
			echo('<br>');

			$linkArr = explode('<a href="/reply/', $postPage);
			$link = explode('"',$linkArr[1]);
			
			$link = $link[0];

			echo('<br>');
			echo($link);
			echo('<br><br>');
			$id=$link;
			$link = 'http://'.$city.'.craigslist.org/reply/'.$link;
			$contactLink = $link;
			$contactPage = file_get_contents($link);
			
			$linkArr = explode('readonly="readonly" value="', $contactPage);
			$email = explode('"',$linkArr[1]);
			$email=$email[0];
			echo($email);
			echo('<br><br>');

$fieldsArr= array('id'=>$id, 'email'=>$email, 'contactLink'=>$contactLink, 'title'=>$title, 'info'=>$body);

$source="craigslist";
$tableName = 'postings';
$fieldsArr = $fieldsArr;
$checkExists = true;
$print=true;
$checkAdded=false;
$updateBool=false;
$addNewFields=true;
$exists = dbMassData("SELECT * FROM postings WHERE id ='$id'");
if($exists==null){
		if(isset($email)){

		rollAdd($tableName, $fieldsArr, $checkExists, $print ,$checkAdded, $updateBool, $addNewFields);
	}
}







		}
		
	}




?>
