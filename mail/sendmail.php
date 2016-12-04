<?php
require 'phpmailer/PHPMailerAutoload.php';

//sendmail();

function sendmail($from = "ammar@alqaraghuli.com",
	$subject="Contact message from your website", 
	$body="message body",
	$to="humber@alqaraghuli.com")
{   //function sendmail
	$mail = new PHPMailer;
	$mail->isSMTP();            // Set mailer to use SMTP
	$mail->Host = 'mail.alqaraghuli.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;             // Enable SMTP authentication
	$mail->Username = 'humber@alqaraghuli.com';                 // SMTP username
	$mail->Password = 'Humber2016';                           // SMTP password
	$mail->Port = 25;     //587                               // TCP port to connect to 
	$mail->setFrom('humber@alqaraghuli.com', 'Mailer');
	$mail->addAddress($to);     // Add a recipient, Name is optional
	$mail->addReplyTo($from);
	$mail->addCC('humber@alqaraghuli.com');
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