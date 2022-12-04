<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';  $mail = new PHPMailer(true);    
$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->Mailer = "smtp";


$mail->SMTPDebug = 1;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Host = "smtp.gmail.com";
$mail->Username = "apswtrare@gmail.com";
$mail->Password = "kewjqkdawkbcnjor";

//Recipients
$mail->IsHTML(true);
$mail->AddAddress("recipient@domain", "recipient-name");
$mail->SetFrom("from@gmail.com", "from-name");
$mail->AddReplyTo("ghdxodml@naver.com", "reply-to-name");
$mail->AddCC("ghdxodml@naver.com", "cc-recipient-name");
$mail->Subject = "Test Email sent via Gmail SMTP Server using PHP Mailer";
$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class</b>.";


//Content
$mail->MsgHTML($content);

echo "Email sent successfully";

