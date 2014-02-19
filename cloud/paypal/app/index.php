<?php 
require_once 'bootstrap.php';
session_start();
$message = isset($_GET['message']) ? $_GET['message'] : NULL;
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta content="IE=Edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>PizzaShop</title>    
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js" type="text/javascript"></script>
    <![endif]-->
    <link href="../public/css/application.css" media="all" rel="stylesheet" type="text/css">
    <link href="../public/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
  </head>
  <body style="zoom: 1;">
    <?php include './navbar.php';?>
    <div class="container" id="content">   
      <?php if(isset($message)) {?>
		<div class="alert fade in alert-success">
			<button class="close" data-dismiss="alert">&times;</button>
			<?php echo $message;?>
		</div>
	  <?php }?>	   
      <div class="row pizza-row">
        <div class="span2">
          <div class="image">
            <img alt="Pizza 0" src="../public/images/0000000000000000000000000000000">
          </div>
          <div class="details">
            10$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=10.00&order%5Bdescription%5D=Pizza+0" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 1" src="../public/images/0000000000000000000000000000001">
          </div>
          <div class="details">
            15$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=15.00&order%5Bdescription%5D=Pizza+1" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 2" src="../public/images/0000000000000000000000000000002">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+2" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 3" src="../public/images/0000000000000000000000000000003">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+3" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 4" src="../public/images/0000000000000000000000000000004">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+4" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 5" src="../public/images/0000000000000000000000000000005">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+5" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
      </div>
      <div class="row pizza-row">
        <div class="span2">
          <div class="image">
            <img alt="Pizza 6" src="../public/images/0000000000000000000000000000006">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+6" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 7" src="../public/images/0000000000000000000000000000007">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+7" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 8" src="../public/images/0000000000000000000000000000008">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+8" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 9" src="../public/images/0000000000000000000000000000009">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+9" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 10" src="../public/images/00000000000000000000000000000010">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+10" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 11" src="../public/images/00000000000000000000000000000011">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+11" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
      </div>
      <div class="row pizza-row">
        <div class="span2">
          <div class="image">
            <img alt="Pizza 12" src="../public/images/00000000000000000000000000000012">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+12" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 13" src="../public/images/00000000000000000000000000000013">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+13" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 14" src="../public/images/00000000000000000000000000000014">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+14" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 15" src="../public/images/00000000000000000000000000000015">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+15" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 16" src="../public/images/00000000000000000000000000000016">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+16" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
        <div class="span2">
          <div class="image">
            <img alt="Pizza 17" src="../public/images/00000000000000000000000000000017">
          </div>
          <div class="details">
            20$ -
            <a href="./order/order_confirmation.php?order%5Bamount%5D=20.00&order%5Bdescription%5D=Pizza+17" class="btn btn-small" data-disable-with="Procesing.." data-method="post" rel="nofollow">Buy</a>
          </div>
        </div>
      </div>
	  <br/><br/><br/>
      <div class="row">
		  <div class="span6 offset3">
	   	    <p>This is a sample application which showcases the new PayPal REST APIs. The app uses mock data to demonstrate how you can use the REST APIs for</p>
			<ul>
				<li>Saving credit card information with PayPal for later use.</li>
				<li>Making payments using a saved credit card.</li>
				<li>Making payments using PayPal.</li>
			</ul>
			</div>
      </div>
    </div>
    <?php include './footer.php';?>
    <script src="../public/js/application.js" type="text/javascript"></script>
</body></html>
