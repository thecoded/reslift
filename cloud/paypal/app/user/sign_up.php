<?php
/*
 * User registration page.
 */
require_once __DIR__ . '/../bootstrap.php';
session_start();

// Sign up form postback
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if(trim($_POST['user']['email']) == '' || $_POST['user']['password'] == '') {
		$errorMessage = "You must enter a email address and password to register.";
	} else if ($_POST['user']['password'] != $_POST['user']['password_confirmation']) {
		$errorMessage = "Passwords do not match. Please check.";
	} else {
		try {			
			$creditCardId = NULL;
			// User can configure credit card info later from the
			// profile page or can use paypal as his funding source.
			if(trim($_POST['user']['credit_card']['number']) != "") {
				$creditCardId = saveCard($_POST['user']['credit_card']);
			}
			$userId = addUser($_POST['user']['email'], $_POST['user']['password'], $creditCardId);			
		} catch(PPConnectionException $ex){
			$errorMessage = $ex->getData() != '' ? parseApiError($ex->getData()) : $ex->getMessage();
		} catch (Exception $ex) {
			$errorMessage = $ex->getMessage();		
		}
	}
	if(isset($userId) && $userId != false) {
		signIn($_POST['user']['email']);
		header("Location: ../index.php");
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=Edge,chrome=1' http-equiv='X-UA-Compatible'>
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>
    <title>PizzaShop</title>    
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js" type="text/javascript"></script>
    <![endif]-->
    <link href="../../public/css/application.css" media="all" rel="stylesheet" type="text/css" />
    <link href="../../public/images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  </head>
  <body>
    <?php include '../navbar.php';?>
    <div class='container' id='content'>
      
      <h2>Sign up</h2>
	  <p>Sign up for a new PizzaShop account.</p>
      <?php if(isset($errorMessage)) {?>
		<div class="alert fade in alert-error">
			<button class="close" data-dismiss="alert">&times;</button>
			<?php echo $errorMessage;?>
		</div>
		<?php }?>
      <form accept-charset="UTF-8" action="./sign_up.php" autocomplete="off" class="simple_form form-horizontal new_user" id="new_user" method="post" novalidate="novalidate"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="vpVuNuIt9fRZzLm0eE0gk4h249k0nZPB/WEXWn9ETwg=" /></div>
        
        <div class="control-group email required"><label class="email required control-label" for="user_email"><abbr title="required">*</abbr> Email</label><div class="controls"><input autofocus="autofocus" class="string email required" id="user_email" name="user[email]" size="50" type="email" value="" placeholder="dummy@email.com"/></div></div>
        <div class="control-group password required"><label class="password required control-label" for="user_password"><abbr title="required">*</abbr> Password</label><div class="controls"><input class="password required" id="user_password" name="user[password]" size="50" type="password" /></div></div>
        <div class="control-group password required"><label class="password required control-label" for="user_password_confirmation"><abbr title="required">*</abbr> Password confirmation</label><div class="controls"><input class="password required" id="user_password_confirmation" name="user[password_confirmation]" size="50" type="password" /></div></div>
        <legend>Add Credit Card (Optional)</legend>
		<p>Your credit card information is stored safely with PayPal.</p>
        <div class="control-group select required"><label class="select required control-label" for="user_credit_card_type"><abbr title="required">*</abbr> Type</label><div class="controls"><select class="select required" id="user_credit_card_type" name="user[credit_card][type]"><option value=""></option>
        <option value="visa">visa</option>
        <option value="mastercard">mastercard</option>
        <option value="discover">discover</option>
        <option value="amex">amex</option></select></div></div>
        <div class="control-group string required"><label class="string required control-label" for="user_credit_card_number"><abbr title="required">*</abbr> Number</label><div class="controls"><input class="string required" id="user_credit_card_number" name="user[credit_card][number]" size="50" type="text" /></div></div>
        <div class="control-group string optional"><label class="string required control-label" for="user_credit_card_cvv2">Cvv2</label><div class="controls"><input class="string optional" id="user_credit_card_cvv2" name="user[credit_card][cvv2]" size="50" type="text" /></div></div>        
        <div class="control-group select required"><label class="select required control-label" for="user_credit_card_expire_month"><abbr title="required">*</abbr> Expire month</label><div class="controls"><select class="select required" id="user_credit_card_expire_month" name="user[credit_card][expire_month]"><option value=""></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option></select></div></div>
        <div class="control-group select required"><label class="select required control-label" for="user_credit_card_expire_year"><abbr title="required">*</abbr> Expire year</label><div class="controls"><select class="select required" id="user_credit_card_expire_year" name="user[credit_card][expire_year]"><option value=""></option>
        <option value="2013">2013</option>
        <option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option></select></div></div>  
        <div class='form-actions'>
          <input class="btn btn btn-primary" name="commit" type="submit" value="Sign up" />
        </div>
      </form>
        <a href="sign_in.php">Sign in</a><br />
        <a href="newpassword.php">Forgot your password?</a><br />
    </div>
	<?php include '../footer.php';?>
    <script src="../../public/js/application.js" type="text/javascript"></script>
  </body>
</html>
