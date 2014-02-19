<?php 
/*
 * Order listing page. We rely on the local database
 * to retrieve the order history of this buyer. 
 */
require_once __DIR__ . '/../bootstrap.php';

/*
if(!isset($_SESSION)) {
	session_start();
}
if(!isSignedIn()) {
	header('Location: ../user/sign_in.php');
	exit;
}
*/

/*
try {
	$orders = getOrders(getSignedInUser());
} catch (Exception $ex) {

	*/
	// Don't overwrite any message that was already set
	if(!isset($message)) {
		$message = $ex->getMessage();
		$messageType = "error";
	}
	$orders = array();
	/*
}

*/
?>
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8'>
<meta content='IE=Edge,chrome=1' http-equiv='X-UA-Compatible'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title>Swank|Swap</title>
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

	<script>
	function goHomeW(){

		window.location="http://swankswap.com/site3/index.html#itemIds=<?php echo $_SESSION['items']; ?>&amount=<?php echo $_SESSION['amount'];?>";
	}
	</script>
	<?php include '../navbar.php';?>
	<div class='container' id='content'>
		<?php if(isset($message) && isset($messageType)) {?>
		<div class="alert fade in alert-<?php echo $messageType;?>">
			<button class="close" data-dismiss="alert">&times;</button>
			<?php echo $message;?>

			<br><br>

			<button onclick="goHomeW()">Back to the SwankSwap Store</button>
		</div>
		<?php }?>
		<h2>Orders</h2>
		<table class='table' style="display:none">
			<thead>
				<tr>
					<th>Payment ID</th>
					<th>Amount($)</th>
					<th>Payment Status</th>
					<th>Time</th>
					<th>Description</th>
				</tr>
			</thead>			
			<tbody>
				<?php foreach($orders as $order) {?>
				<tr>
					<td><?php echo $order['payment_id'];?></td>
					<td><?php echo $order['amount'];?></td>
					<td><?php echo $order['state'];?></td>
					<td><?php echo $order['created_time'];?></td>
					<td><?php echo $order['description'];?></td>					
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
	<?php include '../footer.php';?>
	<script src="../../public/js/application.js" type="text/javascript"></script>
</body>
</html>
