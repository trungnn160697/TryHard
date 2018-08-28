<?php
require_once('class.phpmailer.php');

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "anhlahau.hl@gmail.com";
$mail->Password = "gatoranguyhiem";
$mail->SetFrom("anhlau.hl@gmail.com", "Share DOC");
$mail->Subject = "Test";
$mail->Body = "hello";
$mail->AddAddress("leconghau.hit@gmail.com");

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }

 ?>