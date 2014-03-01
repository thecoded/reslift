<?php
/*
 * Set of common utility functions
*/

/**
 * Returns whether the user signed in
 * @return boolean
 */
function isSignedIn() {
	return (isset($_SESSION) && isset($_SESSION['userid']));
}

/**
 * Updates the user's sign in status
 * @param string $userId
 */
function signIn($userId) {
	$_SESSION['userid'] = $userId;
}

/**
 * Sign out the user and clean up session
 */
function signOut() {
	session_destroy();
}

/**
 * Returns the currently signed in user's userId
 * @return string
 */
function getSignedInUser() {
	return $_SESSION['userid'];
}


/**
 * Determine the baseurl of the current script.
 * Used for determining the absolute url of return and
 * cancel urls.
 * @return string
 */
function getBaseUrl() {

	$protocol = 'http';
	if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
		$protocol .= 's';
		$protocol_port = $_SERVER['SERVER_PORT'];
	} else {
		$protocol_port = 80;
	}

	$host = $_SERVER['HTTP_HOST'];
	$port = $_SERVER['SERVER_PORT'];
	$request = $_SERVER['PHP_SELF'];
	return dirname($protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request);
}


/**
 * Utility method that returns the first url of a certain
 * type. Returns empty string if no match is found
 * 
 * @param array $links
 * @param string $type 
 * @return string
 */
function getLink(array $links, $type) {
	foreach($links as $link) {
		if($link->getRel() == $type) {
			return $link->getHref();
		}
	}
	return "";
}

/**
 * Utility function to pretty print API error data
 * @param string $errorJson
 * @return string
 */
function parseApiError($errorJson) {
	$msg = '';
	
	$data = json_decode($errorJson, true);
	if(isset($data['name']) && isset($data['message'])) {
		$msg .= $data['name'] . " : " .  $data['message'] . "<br/>";
	}
	if(isset($data['details'])) {
		$msg .= "<ul>";
		foreach($data['details'] as $detail) {
			$msg .= "<li>" . $detail['field'] . " : " . $detail['issue'] . "</li>";	
		}
		$msg .= "</ul>";
	}
	if($msg == '') {
		$msg = $errorJson;
	}	
	return $msg;
}