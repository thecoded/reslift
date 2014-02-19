<?php
/*
 * Order completion page. When PayPal is used as the payment method,
 * the buyer gets redirected here post approval / cancellation of
 * payment.
 */



include_once('/var/www/html/cloud/models/db/dbLib.php');
require_once __DIR__ . '/../bootstrap.php';
session_start();

$email=$_SESSION['email'];
$amount=$_SESSION['amount'];
/*
if(!isSignedIn()) {
	header('Location: ../user/sign_in.php');
	exit;
}
*/
if(isset($_GET['success'])) {

	file_get_contents('http://swankswap.com/cloud/email1.php?email='.$_SESSION['email']);

	// We were redirected here from PayPal after the buyer approved/cancelled
	// the payment
	$userInfo= dbMassData("SELECT * FROM users WHERE email = '$email'");

	$credits = $userInfo[0]['approvedCredits'];
	$credits= floatval($credits);
	$amount = floatval($amount);
	$credits= $credits+$amount;
	dbQuery("UPDATE users SET approvedCredits = '$credits' WHERE email = '$email' ");


	if($_GET['success'] == 'true' && isset($_GET['PayerID']) && isset($_GET['orderId'])) {
		$orderId = $_GET['orderId'];
		try {
			$order = getOrder($orderId);
			$payment = executePayment($order['payment_id'], $_GET['PayerID']);
			updateOrder($orderId, $payment->getState());
			$messageType = "success";
			$message = "Your payment was successful. Your order id is $orderId.";
		} catch (PPConnectionException $ex) {
			$message = parseApiError($ex->getData());
			$messageType = "error";
		} catch (Exception $ex) {
			$message = $ex->getMessage();
			$messageType = "error";
		}
		
	} else {
		$messageType = "error";
		$message = "Your payment was cancelled.";
	}
}
require_once 'orders.php';
