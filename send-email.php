<?php

$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];
// $email = 'ghdxodml@naver.com';
// $subject = 'subject';
// $message = 'message';

// echo 'ee';


require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;




if(isset($_POST["send"])){

  $mail = new PHPMailer(true);
  $mail->CharSet = "utf-8";   //한글이 안깨지게 CharSet 설정
  $mail->Encoding = "base64";
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  
  $mail->Host = "smtp.gmail.com";
  $mail->Username = "apswtrare@gmail.com";
  $mail->Password = "uxyexqvdxkumbexb";
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
  $mail->setFrom('apswtrare@gmail.com');
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $message;
  
  $mail->send();
  
}
?>
"
<script>
alert('Sent Successfully');
document.location.href = 'form.html';
</script>

";
