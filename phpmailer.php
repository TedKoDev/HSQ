<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
include 'sqlinfo.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function secure_random_string($length)
{
    $rand_string = '';
    for ($i = 0; $i < $length; $i++) {
        $number = random_int(0, 36);
        $character = base_convert($number, 10, 36);
        $rand_string .= $character;
    }
    return $rand_string;
}

echo "Sec_Out_1: ", secure_random_string(10), "\n";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
// $email_receiver = $_POST['email'];
$email_receiver = 'hte9002@hotmail.com';

echo "email receiver : " . $email_receiver;
$string = secure_random_string(10);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
//    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->Host = 'smtp.naver.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
//    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Username = 'ghdxodml@naver.com';                     //SMTP username
    $mail->Password = '2021xodml12!';                               //SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->CharSet = 'utf-8';
    $mail->Encoding = "base64";

    //Recipients
    $mail->setFrom('ghdxodml@naver.com', 'TodayILearned Admin');
    $mail->addAddress($email_receiver . "", 'User');     //Add a recipient
//    $mail->addAddress('ellen@example.com');               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Attachmentsl
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set emai format to HTML
    $mail->Subject = 'Your Authorization code';
    $mail->Body = 'Your code <b> : </b>' . $string;
    $mail->AltBody = $string;

    $mail->send();
    echo 'Message has been sent';
//    setcookie('emailcode', $string, time() + 3600);


//     $sql = "INSERT INTO emailcode(email,temp_code)
// VALUES('$email_receiver','$string')";
//     $result = mysqli_query($conn, $sql);


} catch (Exception $e) {
    echo "Message could not be sent . Mailer Error: {
        $mail->ErrorInfo}";
}
