<?php

// Wrapper methods for all PayPal integration

use PayPal\Api\PaymentExecution;

use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;

/**
 * Save a credit card with paypal
 * 
 * This helps you avoid the hassle of securely storing credit
 * card information on your site. PayPal provides a credit card
 * id that you can use for charging future payments.
 * 
 * @param array $params	credit card parameters
 */

function saveCard($params) {
	
	$card = new CreditCard();
	$card->setType($params['type']);
	$card->setNumber($params['number']);
	$card->setExpireMonth($params['expire_month']);
	$card->setExpireYear($params['expire_year']);
	$card->setCvv2($params['cvv2']);
	
	$card->create(getApiContext());
	return $card->getId();
}

/**
 * 
 * @param string $cardId credit card id obtained from 
 * a previous create API call.
 */
function getCreditCard($cardId) {
	return CreditCard::get($cardId, getApiContext());
}


/**
 * Create a payment using a previously obtained
 * credit card id. The corresponding credit
 * card is used as the funding instrument.
 * 
 * @param string $creditCardId credit card id
 * @param string $total Payment amount with 2 decimal points
 * @param string $currency 3 letter ISO code for currency
 * @param string $paymentDesc
 */
function makePaymentUsingCC($creditCardId, $total, $currency, $paymentDesc) {
		
	$ccToken = new CreditCardToken();
	$ccToken->setCreditCardId($creditCardId);	
	
	$fi = new FundingInstrument();
	$fi->setCreditCardToken($ccToken);
	
	$payer = new Payer();
	$payer->setPaymentMethod("credit_card");
	$payer->setFundingInstruments(array($fi));	
	
	// Specify the payment amount.
	$amount = new Amount();
	$amount->setCurrency($currency);
	$amount->setTotal($total);
	// ###Transaction
	// A transaction defines the contract of a
	// payment - what is the payment for and who
	// is fulfilling it. Transaction is created with
	// a `Payee` and `Amount` types
	$transaction = new Transaction();
	$transaction->setAmount($amount);
	$transaction->setDescription($paymentDesc);
	
	$payment = new Payment();
	$payment->setIntent("sale");
	$payment->setPayer($payer);
	$payment->setTransactions(array($transaction));

	$payment->create(getApiContext());
	return $payment;
}

/**
 * Create a payment using the buyer's paypal
 * account as the funding instrument. Your app
 * will have to redirect the buyer to the paypal 
 * website, obtain their consent to the payment
 * and subsequently execute the payment using
 * the execute API call. 
 * 
 * @param string $total	payment amount in DDD.DD format
 * @param string $currency	3 letter ISO currency code such as 'USD'
 * @param string $paymentDesc	A description about the payment
 * @param string $returnUrl	The url to which the buyer must be redirected
 * 				to on successful completion of payment
 * @param string $cancelUrl	The url to which the buyer must be redirected
 * 				to if the payment is cancelled
 * @return \PayPal\Api\Payment
 */

function makePaymentUsingPayPal($total, $currency, $paymentDesc, $returnUrl, $cancelUrl) {
	
	$payer = new Payer();
	$payer->setPaymentMethod("paypal");
	
	// Specify the payment amount.
	$amount = new Amount();
	$amount->setCurrency($currency);
	$amount->setTotal($total);
	
	// ###Transaction
	// A transaction defines the contract of a
	// payment - what is the payment for and who
	// is fulfilling it. Transaction is created with
	// a `Payee` and `Amount` types
	$transaction = new Transaction();
	$transaction->setAmount($amount);
	$transaction->setDescription($paymentDesc);
	
	$redirectUrls = new RedirectUrls();
	$redirectUrls->setReturnUrl($returnUrl);
	$redirectUrls->setCancelUrl($cancelUrl);
	
	$payment = new Payment();
	$payment->setRedirectUrls($redirectUrls);
	$payment->setIntent("sale");
	$payment->setPayer($payer);
	$payment->setTransactions(array($transaction));
	
	$payment->create(getApiContext());
  return $payment;
}


/**
 * Completes the payment once buyer approval has been
 * obtained. Used only when the payment method is 'paypal'
 * 
 * @param string $paymentId id of a previously created
 * 		payment that has its payment method set to 'paypal'
 * 		and has been approved by the buyer.
 * 
 * @param string $payerId PayerId as returned by PayPal post
 * 		buyer approval.
 */
function executePayment($paymentId, $payerId) {
	
	$payment = Payment::get($paymentId, getApiContext());
	$paymentExecution = new PaymentExecution();
	$paymentExecution->setPayerId($payerId);	
	$payment = $payment->execute($paymentExecution, getApiContext());	
	
	return $payment;
}
