<?php

	include_once('db.php');

	extract($_REQUEST);
	//check for user table
	//if it doesn't exist, create it (first time this script is run)


	


	
	//validation
	if(!isset($email)){
		$response = array("status"=>"fail", "resp"=>"Please send email ");

		$jResponse = json_encode($response);
		echo($jResponse);
		return;
	}

/*


$to      = $email;
$subject = 'SwankSwap Beta';
$message = 'Hi there! Thanks for signing up for the SwankSwap beta! We\'ll be in touch, and you will be one of the first to here about our exclusive offers and pre-launch.';
$headers = 'From: info@swankswap.com';

mail($to, $subject, $message, $headers);
*/



	
	$ipAddress=$_SERVER['REMOTE_ADDR'];
	//echo('ip='.$ipAddress);


		dbQuery("INSERT INTO beta ( email, ipAddress) VALUES ('$email', '$ipAddress')");
	
		//now login user
		$response = array("status"=>"success", "resp"=>"go to go");

		$jResponse = json_encode($response);
		echo($jResponse);
		





	require 'class.phpmailer.php';

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@swankswap.com';                            // SMTP username
$mail->Password = '28nq&y3GmwxqhJm';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'info@swankswap.com';
$mail->FromName = 'SwankSwap Beta';
//$mail->AddAddress('mariah@ppincjobs.com', 'Mariah');  // Add a recipient
$mail->AddAddress($email);               // Name is optional
$mail->AddReplyTo('info@swankswap.com', 'SwankSwap Beta');
//$mail->AddCC('cc@example.com');
//$mail->AddBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Thank You from the SwankSwap Team';
$mail->Body    = 'Thank you so much for signing up for the SwankSwap Beta.  We will be sending you exciting news and updates as we progress towards our beta launch date.  Follow us on twitter @swankswap<br><br>Thanks again from the SwankSwap Team!';
$mail->AltBody = 'Thank you so much for signing up for the SwankSwap Beta.  We will be sending you exciting news and updates as we progress towards our beta launch date.  Follow us on twitter @swankswap. Thanks again from the SwankSwap Team!';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent to'. $email;




	
	

?>