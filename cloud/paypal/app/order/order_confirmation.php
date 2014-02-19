<?php
/*
 * An order confirmation screen for the buyer. The buyer
 * is required to choose a payment method here.
 * Available payment methods are paypal and credit card.
 */ 
require_once __DIR__ . '/../bootstrap.php';
session_start();

$_SESSION['items']= $_REQUEST['items'];
 $_SESSION['amount']= $_GET['order']['amount'];
//echo($_SESSION['items']);
/*
if(!isSignedIn() || !isset($_GET['order'])) {
	header('Location: ../user/sign_in.php');
	exit;
}

*/
$amount = $_GET['order']['amount'];
$description = $_GET['order']['description'];
// Figure out what funding instruments are available for this buyer
$availableFundingInstruments = array();
/*
$user = getUser(getSignedInUser());

if(isset($user['creditcard_id']) && $user['creditcard_id'] != NULL) {
	$availableFundingInstruments[] = 'credit_card';
}

*/
$availableFundingInstruments[] = 'paypal';
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<meta content='IE=Edge,chrome=1' http-equiv='X-UA-Compatible'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>SwankSwap Checkout</title>
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js" type="text/javascript"></script>
    <![endif]-->
<link href="../../public/css/application.css" media="all" rel="stylesheet"
	type="text/css" />
<link href="../../public/images/favicon.ico" rel="shortcut icon"
	type="image/vnd.microsoft.icon" />
</head>
<body>
	<?php include '../navbar.php';?>
	<div class='container' id='content'>
		<h2>Order Confirmation</h2>
		<form accept-charset="UTF-8" action="order_place.php"
			class="simple_form form-horizontal new_order" id="order"
			method="post" novalidate="novalidate">
			<div class='control-group'>
				<label class="string optional control-label" for="order_amount">Amount</label>
				<div class='controls'>
					<label class='checkbox'> <?php echo $amount;?> </label> <input id="order_amount"
						name="order[amount]" type="hidden" value="<?php echo $amount;?>" />
				</div>
			</div>
			<div class='control-group'>
				<label class="string optional control-label" for="order_description">Description</label>
				<div class='controls'>
					<label class='checkbox'> <?php echo $description;?> </label> <input
						id="order_description" name="order[description]" type="hidden"
						value="<?php echo $description;?>" />
				</div>
			</div>
			<div class="control-group select optional" style="display:none">
				<label class="select optional control-label"
					for="order_payment_method">Payment method</label>
				<div class="controls">
					<select class="select optional" id="order_payment_method"
						name="order[payment_method]">
						<?php foreach ($availableFundingInstruments as $fi) {?>
						<option value="<?php echo $fi;?>"><?php echo $fi;?></option>
						<?php }?>						
					</select>
					<p class="help-block" style="display:none">Update your credit card in <a href="../user/profile.php#currentcard">Profile</a> page</p>
				</div>
			</div>
			<div class='form-actions'>
				<input class="btn btn btn-primary" name="commit" type="submit"
					value="Place Order" />
			</div>
		</form>
		<?php include '../footer.php';?>
	</div>
	<script src="../../public/js/application.js" type="text/javascript"></script>
</body>
</html>