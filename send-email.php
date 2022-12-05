<?php
$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];

error_log("'dd',$name, $email, $subject,$message\n", "3", "./php.log");

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;



$mail->Username = "apswtrare@gmail.com";
$mail->Password = "2018xodml12!";

$mail->setFrom($email, $name);
$mail->addAddress($email, $name);

$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

header("Location: sent.html");