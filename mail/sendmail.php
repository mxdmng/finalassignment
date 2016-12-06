<?php
require 'phpmailer/PHPMailerAutoload.php';

//sendmail();

function sendmail($from = "mxdmng@gmail.com",
	$subject="Contact message from your website", 
	$body="message body",
	$to="mxdmng@gmail.com")
{   //function sendmail
	$mail = new PHPMailer;
	$mail->isSMTP();            // Set mailer to use SMTP
	$mail->Host = 'mail.alqaraghuli.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;             // Enable SMTP authentication
	$mail->Username = '';                 // SMTP username
	$mail->Password = '';                           // SMTP password
	$mail->Port = 25;     //587                               // TCP port to connect to 
	$mail->setFrom('mxdmng@gmail.com', 'Mailer');
	$mail->addAddress($to);     // Add a recipient, Name is optional
	$mail->addReplyTo($from);
	$mail->addCC('mxdmng@gmail.com');
	$mail->isHTML(true);      // Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body    = $body;
		
	if(!$mail->send()) {   
		return 'Email could not be sent, Error: ' . $mail->ErrorInfo;
	} else {
		return 'Email sent successfully';
	}
} //function sendmail
?>