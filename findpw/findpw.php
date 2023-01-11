<?php


include("../conn.php");
include("../jwt.php");

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$email           =   json_decode(file_get_contents("php://input"))->{"email"}; // email

$email  = 'ghdxodml@naver.com';



// 해당 email 이 있는지 user 테이블에서 확인


// $sql = "SELECT exists (select* FROM User WHERE user_email = '$email') as success";

$sql = "SELECT * FROM User WHERE user_email = '{$email}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$User_ID = $row['user_id'];
$U_Name = $row['user_name'];



if ($result->num_rows > 0) {


    $subject = 'Hangle Square change password Link';
    $message = '
    Click Link and change your Password' . "<br/>" . '
    You can change your password.' . "<br/>" . '
     
    ------------------------' . "<br/>" . '
    UserEmail: ' . $email . '' . "<br/>" . '
    Name: ' . $U_Name . '' . "<br/>" . '
    ------------------------' . "<br/>" . '
     
    Please click this link to change your account password:' . "<br/>" . '
    http://localhost/findpw/changepwProcess.php?email=' . $email . '
    '; // Our message above including the link;

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = "utf-8";   //한글이 안깨지게 CharSet 설정
        $mail->Encoding = "base64";
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.gmail.com";
        $mail->Username = "apswtrare@gmail.com";
        $mail->Password = "caofvauzywfzrbxv";
        $mail->Password = "caofvauzywfzrbxv";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('apswtrare@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();

        // echo '메일보내기 정상일떄';
        $send["success"] = "yes";
        $send["message"] = "발송된 이메일을 확인해 주세요.";
        echo json_encode($send);
        mysqli_close($conn);
    } catch (Exception $e) {
        // echo '메일보내기 비정상일떄';
        $data = array(

            'success'           => "Message could not be sent . Mailer Error: {
          $mail->ErrorInfo}"
        );
        // echo json_encode($data);
        // mysqli_close($conn);;
    }
} else {
    // 변경실패 

    $send["success"] = "no";
    $send["message"] = "등록된 메일이 없습니다.";

    echo json_encode($send);
    mysqli_close($conn);
}
