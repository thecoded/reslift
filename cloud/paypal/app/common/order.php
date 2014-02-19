<?php

require_once __DIR__ . '/db.php';

/**
 * Create a new order
 * @param string $userId Buyer's user id
 * @param string $paymentId payment id returned by paypal
 * @param string $state state of this order
 * @param string $amount payment amount in DD.DD format
 * @param string $description a description about this payment
 * @throws Exception
 */
function addOrder($userId, $paymentId, $state, $amount, $description) {
	$conn = getConnection();
	$query = sprintf("INSERT INTO %s(user_id, payment_id, state, amount, description, created_time) 
			VALUES('%s', '%s', '%s', '%s', '%s', NOW())",
			ORDERS_TABLE,
			mysql_real_escape_string($userId),
			mysql_real_escape_string($paymentId),
			mysql_real_escape_string($state),
			mysql_real_escape_string($amount),
			mysql_real_escape_string($description));	
	$result = mysql_query($query, getConnection());
	if(!$result) {
		$errMsg = "Error creating new order: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	$orderId = mysql_insert_id($conn);
	mysql_close($conn);
	
	return $orderId;
}

/**
 * Update a previously created order.
 * 
 * @param int $orderId
 * @param string $state
 * @param string $paymentId
 * @throws Exception
 * @return number
 */
function updateOrder($orderId, $state, $paymentId=NULL) {
	$conn = getConnection();
	$args = array(ORDERS_TABLE, mysql_real_escape_string($state));
	 $updates = array("state='%s'");
	
	if($paymentId != NULL) {
		$args[] = mysql_real_escape_string($paymentId);
		$updates[] = "payment_id='%s'";
	}
	$args[] = $orderId;
		
	$query = vsprintf("UPDATE %s SET " . implode(', ', $updates) . " WHERE order_id='%s'", $args);		
	$result = mysql_query($query, getConnection());
	if(!$result) {
		$errMsg = "Error updating order record: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	$isUpdated = mysql_affected_rows($conn);
	mysql_close($conn);
	
	return $isUpdated;
}

/**
 * Retrieve orders created by this buyer
 * @param string $email
 * @throws Exception
 * @return array
 */
function getOrders($email) {
	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s WHERE user_id='%s' ORDER BY created_time DESC",
			ORDERS_TABLE,
			mysql_real_escape_string($email));
	$result = mysql_query($query, $conn);	
	if(!$result) {
		$errMsg = "Error retrieving orders: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}
	
	$rows = array();	
	while(($row = mysql_fetch_assoc($result))) {
		$rows[] = $row;
	}	
	mysql_close($conn);
	return $rows;
}


function getOrder($orderId) {
	$conn = getConnection();
	$query = sprintf("SELECT * FROM %s WHERE order_id='%d'",
			ORDERS_TABLE,
			mysql_real_escape_string($orderId));
	$result = mysql_query($query, $conn);
	if(!$result) {
		$errMsg = "Error retrieving order: " . mysql_error($conn);
		mysql_close($conn);
		throw new Exception($errMsg);
	}

	$row = mysql_fetch_assoc($result);
	mysql_close($conn);
	return $row;
}
?>