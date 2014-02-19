<?php

require_once __DIR__ . '/db.php';


/**
 * Add a new user
 * @param string $email user's email address
 * @param string $password plain text password
 * @param string $creditCardId credit card identifier as returned by the vault api
 * @throws Exception
 * @return number
 */
function addUser($email, $password, $creditCardId=NULL) {
	
	$conn = getConnection();
	$query = sprintf("INSERT INTO %s(email, password, creditcard_id) VALUES('%s', PASSWORD('%s'), '%s')", 
			USERS_TABLE, 
			mysql_real_escape_string($email), 
			mysql_real_escape_string($password), 
			mysql_real_escape_string($creditCardId));
	$result = mysql_query($query, $conn);
	if(!$result) {
		$errMsg = "Error creating user: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	$userId = mysql_insert_id($conn);
	mysql_close($conn);
	
	return $userId;
}

/**
 * Validate a login attempt
 * @param string $email user's email address
 * @param string $password plain text password
 * @throws Exception
 * @return boolean
 */
function validateLogin($email, $password) {
	
	$conn = getConnection();
	$query = sprintf("SELECT COUNT(1) FROM %s WHERE email='%s' AND password=PASSWORD('%s')",
			USERS_TABLE,
			mysql_real_escape_string($email),
			mysql_real_escape_string($password));			
	$result = mysql_query($query, $conn);

	if(!$result) {
		$errMsg = "Error validating login: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	$row = mysql_fetch_row($result);
	mysql_close($conn);
	return ($row[0] > 0);
}

/**
 * Update user record
 * @param string $email user's email address
 * @param string $newPassword
 * @param string $newCreditCardId A new credit card identifier as returned by the vault api
 * @throws Exception
 * @return boolean
 */
function updateUser($email, $newPassword, $newCreditCardId) {

	if($newPassword == NULL && $newCreditCardId == NULL) {
		return;
	}
	$conn = getConnection();
	$args = array(USERS_TABLE); $updates = array();
	if($newPassword != NULL) {
		$args[] = mysql_real_escape_string($newPassword);
		$updates[] = "password=PASSWORD('%s')";
	}
	if($newCreditCardId != NULL) {
		$args[] = mysql_real_escape_string($newCreditCardId);
		$updates[] = "creditcard_id='%s'";
	}
	$args[] = mysql_real_escape_string($email);
	
	$query = vsprintf("UPDATE %s SET " . implode(', ', $updates) . " WHERE email='%s'", $args);	
	$result = mysql_query($query, getConnection());
	if(!$result) {
		$errMsg = "Error updating user record: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	$isUpdated = mysql_affected_rows($conn);
	mysql_close($conn);
	
	return $isUpdated;
}

/**
 * Retrieve a user recod
 * @param string $email user's email address
 * @throws Exception
 * @return array
 */
function getUser($email) {
	$conn = getConnection();
	$query = sprintf("SELECT email, creditcard_id FROM %s WHERE email='%s' ",
			USERS_TABLE,
			mysql_real_escape_string($email));
	$result = mysql_query($query, $conn);
	if(!$result) {
		$errMsg = "Error retrieving user record: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	$row = mysql_fetch_assoc($result);
	mysql_close($conn);
	
	return $row;	
}
?>