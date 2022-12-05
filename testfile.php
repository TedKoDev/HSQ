<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch $mail->IsSMTP(); // telling the class to use SMTP
$mail->IsSMTP(); // telling the class to use SMTP

    //1. 업체에 보내기
    $mail->CharSet = "utf-8";   //한글이 안깨지게 CharSet 설정
    $mail->Encoding = "base64";
    $mail->Host = "smtp.gmail.com"; // email 보낼때 사용할 서버를 지정  smtp.sample.com
    $mail->SMTPAuth = true; // SMTP 인증을 사용함
    $mail->Port = 465; // email 보낼때 사용할 포트를 지정
    $mail->SMTPSecure = "ssl"; // SSL을 사용함
    $mail->Username = "apswtrare@gmail.com";
    $mail->Password = "uxyexqvdxkumbexb";
    $mail->SetFrom('test@sample.com', '제니엘맥'); // 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
    $mail->AddAddress('ghdxodml@naver.com'); // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
    $mail->AddCC('cc@sample.com');  //보내는이한테 확인메일 보내기
    $mail->Subject = '제목이라네'; // 메일 제목
    $mail->Body = '내용이라네'; // 내용
    // $mail->AddAttachment('./files/test.jpg');
    $mail->Send(); // 발송
echo "Message Sent OK //발송 확인\n";
 
?>
