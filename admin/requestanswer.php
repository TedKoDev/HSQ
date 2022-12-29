<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');
/***

수업예약 API
classreservProcess.php

전달받아야 하는값 
1. 사용자(학생)토큰 
2. 수업종류(수업id)
3. 수업시간(30분,60분)
4. 수업일정
5. 수업방식(한글스퀘어 = 0, zoom = 1 )
6. 강사메모
 */

include("../conn.php");
include("../jwt.php");

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


$jwt = new JWT();
// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input");

$token              =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자토큰 
$request_user_id    =   json_decode(file_get_contents("php://input"))->{"request_user_id"}; // 강사신청자id 
$answer_text            =   json_decode(file_get_contents("php://input"))->{"answer_text"}; // 답변 작성 내용 
$answer            =   json_decode(file_get_contents("php://input"))->{"answer"}; // 전문강사, 일반강사, 거절  내용  


//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //학생의 userid
// $User_ID = 32; //학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone







if ($answer == 1) {
  $answer_result = '전문강사/Special_Tutor';

  $select = "UPDATE User_Teacher SET User_Teacher.teacher_special = 'notdefault'
  where User_Teacher.user_id = '$User_ID' ";
  $response = mysqli_query($conn, $select);


} else if ($answer == 2) {
  $answer_result   = '일반강사/Community_Tutor';
  $select = "UPDATE User_Teacher SET User_Teacher.teacher_special = 'default'
  where User_Teacher.user_id = '$User_ID' ";
  $response = mysqli_query($conn, $select);


} else if ($answer == 3) {
  $answer_result   = '거절/Denined';

  $select = "UPDATE User_Detail SET User_Detail.teacher_register_check = 'default'
  where User_Detail.user_id = '$User_ID' ";
  $response = mysqli_query($conn, $select);

}









//메일 전송 
$subject = 'Hangle Square : The answer to the tutor registration application has arrived. / 튜터 등록 신청에 대한 답변이 도착하였습니다. ';
$message = '
Thank you for registering as an instructor for our service.' . ' "<br/>".

Answer/답변: . "<br/>".
저희 서비스에 강사 신청을 해주셔서 감사합니다.' . ' "<br/>".
Thank you for registering as an instructor for our service.' . '"<br/>"' . ' "<br/>".

' . $answer_text . "<br/>" . '
' . $U_Name . ' has been registered as a ' . $answer_result  . '. / ' . $U_Name . ' 님은  '. $answer_result .' 으로 (등록) 되었습니다.  ' . "<br/>" . '
 
';



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
  $mail->addAddress($temail);
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $message;

  $mail->send();


  $data = array(

    'success'           => "yes",
    'message'           => "등록신청 답변 완료",
  
  );
  echo json_encode($data);
  mysqli_close($conn);
} catch (Exception $e) {
  //비정상일떄 
  $data = array(

    'success'           => "Message could not be sent . Mailer Error: {
    $mail->ErrorInfo}"
  );
  echo json_encode($data);
  mysqli_close($conn);;
}
