<?php 
/*
 * User profile page. User can view/edit his
 * password and credit card information from here.
 */
require_once __DIR__ . '/../bootstrap.php';
session_start();

if(!isSignedIn()) {
	header('Location: sign_in.php');
	exit;
}

try {
	$user = getUser(getSignedInUser());
	if(isset($user['creditcard_id']) && $user['creditcard_id'] != NULL) {
		$card = getCreditCard($user['creditcard_id']);
	}
	// Sign in form postback
	if($_SERVER['REQUEST_METHOD'] == 'POST') {	
		
		// Confirm that the user has provided the correct current password
		if(validateLogin($_POST['user']['email'], $_POST['user']['current_password'])) {
			
			$creditCardId = NULL;
			$newPassword = NULL;
			$newCard = array_map('trim', $_POST['user']['credit_card']);
			$newValues = count(array_filter($newCard, 'strlen'));
			
			// Update credit card info if new credit card data has been provided
			if($newValues > 0 && $newValues < 5 ) {
				$message = "Please fill in all required credit card values.";
				$messageType = "error";
			} else if($newValues == 5 ) {
				$creditCardId = saveCard($newCard);
				$card = getCreditCard($creditCardId);
			}
			
			// Update password if new password data has been provided
			if(isset($_POST['user']['password'])) {
				if($_POST['user']['password'] == $_POST['user']['password_confirmation']) {
					$newPassword = $_POST['user']['password'];
				} else {
					$message = "The new password did not match your confirm password.";
					$messageType = "error";
				}
			}
			
			// update credit card info OR/AND password in our database
			if(!isset($message) && (isset($newPassword) || isset($creditCardId))) {				
				updateUser($_POST['user']['email'], $newPassword, $creditCardId);
				$message = "Your profile has been updated.";
				$messageType = "success";
			}
		} else {
			$message = "The current password that you provided is invalid.";
			$messageType = "error";
		}
		
	} 
} catch (PPConnectionException $ex) {
	$message = parseApiError($ex->getData());
	$messageType = "error";
} catch (Exception $ex) {
	$message = $ex->getMessage();
	$messageType = "error";
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
      <?php if(isset($message) && isset($messageType)) {?>
		<div class="alert fade in alert-<?php echo $messageType;?>">
			<button class="close" data-dismiss="alert">&times;</button>
			<?php echo $message;?>
		</div>
		<?php }?>
      <h2>Edit profile</h2>
      <form accept-charset="UTF-8" action="profile.php" autocomplete="off" class="simple_form form-horizontal edit_user" id="edit_user" method="post" novalidate="novalidate"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /><input name="_method" type="hidden" value="put" /><input name="authenticity_token" type="hidden" value="vpVuNuIt9fRZzLm0eE0gk4h249k0nZPB/WEXWn9ETwg=" /></div>
        
        <div class="control-group email required"><label class="email required control-label" for="user_email"> Email</label><div class="controls"><input autofocus="autofocus" class="string email required" id="user_email" name="user[email]" size="50" type="email" value="<?php echo $user['email'];?>" readonly="true" /></div></div>
        <legend>Change password</legend>
        <div class="control-group password optional"><label class="password optional control-label" for="user_password">Password</label><div class="controls"><input class="password optional" id="user_password" name="user[password]" size="50" type="password" /><p class="help-block">leave it blank if you don't want to change it</p></div></div>
        <div class="control-group password optional"><label class="password optional control-label" for="user_password_confirmation">Password confirmation</label><div class="controls"><input class="password optional" id="user_password_confirmation" name="user[password_confirmation]" size="50" type="password" /></div></div>
        <a name="currentcard"></a>
        <legend>Existing Credit card</legend>
        <div class='control-group'>
          <label class='control-label'>Type</label>
          <div class='controls'>
            <label class='checkbox'><?php if(isset($card)) echo $card->getType();?></label>
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label'>Number</label>
          <div class='controls'>
            <label class='checkbox'><?php if(isset($card)) echo $card->getNumber();?></label>
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label'>Expire month</label>
          <div class='controls'>
            <label class='checkbox'><?php if(isset($card)) echo $card->getExpire_Month();?></label>
          </div>
        </div>
        <div class='control-group'>
          <label class='control-label'>Expire year</label>
          <div class='controls'>
            <label class='checkbox'><?php if(isset($card)) echo $card->getExpire_Year();?></label>
          </div>
        </div>
        <a name="newcard"></a>
        <legend>Update Credit Card</legend>
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
        <legend>Confirmation</legend>
        <div class="control-group password required"><label class="password required control-label" for="user_current_password"><abbr title="required">*</abbr> Current password</label><div class="controls"><input class="password required" id="user_current_password" name="user[current_password]" size="50" type="password" /><p class="help-block">we need your current password to confirm your changes</p></div></div>
        <div class='form-actions'>
          <input class="btn btn btn-primary" name="commit" type="submit" value="Update" />
        </div>
      </form>     
    </div>
	<?php include '../footer.php';?>
    <script src="../../public/js/application.js" type="text/javascript"></script>
  </body>
</html>
