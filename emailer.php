<?php



	function sendTheMail($email, $subject, $htmlContent, $textContent){


		require_once 'class.phpmailer.php';
echo('trying');

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'm@thecoded.com';                            // SMTP username
$mail->Password = 'reprapLife1';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'm@thecoded.com';
$mail->FromName = "ResLift";
//$mail->AddAddress('mariah@ppincjobs.com', 'Mariah');  // Add a recipient
$mail->AddAddress($email);               // Name is optional
$mail->AddReplyTo('m@thecoded.com', "ResLift");
//$mail->AddCC('cc@example.com');
//$mail->AddBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $htmlContent;
$mail->AltBody = $textContent;

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   
}

echo 'Message has been sent to'. $email;



	}

	
	

?>