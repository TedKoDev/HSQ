<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  require 'src/Exception.php';
  require 'src/PHPMailer.php';
  require 'src/SMTP.php';
  $mail = new PHPMailer(true);    
  
  $mail->IsSMTP();
  $mail->Mailer = "smtp";
  
  try {
  $mail->SMTPDebug = 1;
  $mail->SMTPAuth = TRUE;
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;
  $mail->Host = "smtp.gmail.com";
  $mail->Username = "your-email@gmail.com";
  $mail->Password = "your-gmail-password";
  
  //Recipients
  $mail->IsHTML(true);
  $mail->AddAddress("recipient@domain”, “recipient-name");
  $mail->SetFrom("from@gmail.com","from-name");
  $mail->AddReplyTo("reply-to@domain", "reply-to-name");
  $mail->AddCC("cc-recipient@domain","cc-recipient-name");
  $mail->Subject = "Test Email sent via Gmail SMTP Server using PHP Mailer";
  $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class</b>.";
  
  //Attachments
  $mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
  $mail->addAttachment('/tmp/image.jpg’, ‘new.jpg'); //Optional name
  
  //Content
  $mail->MsgHTML($content);
  if(!$mail->Send()) {
  echo "Error while sending Email.";
  var_dump($mail);
  } else {
  echo "Email sent successfully";
  }
  }
?>