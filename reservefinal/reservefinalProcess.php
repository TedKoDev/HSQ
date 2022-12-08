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
file_get_contents("php://input") . "<br/>";

$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 
$classid    =   json_decode(file_get_contents("php://input"))->{"classid"}; // 수업id 
$tp         =   json_decode(file_get_contents("php://input"))->{"tp"}; // 수업시간 
$plan       =   json_decode(file_get_contents("php://input"))->{"plan"}; // 수업일정 
$cmethod    =   json_decode(file_get_contents("php://input"))->{"cmethod"}; // 수업방식 
$memo       =   json_decode(file_get_contents("php://input"))->{"memo"}; // 강사메모


//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone


//1시간 = 3600000;
$hour   = 3600000;

// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$explan = (explode("_", $plan));
$tzplan = array(); //Timezone 적용을 위한 배열 생성
foreach($explan as $val){ 
$save = $val - $timezone* $hour;
$date = date('Y-m-d H:i:s',  $save);
array_push($tzplan,$save);
}
$tzplanresult = implode("_",$tzplan); // 다시 합체 



// Class_Add DB TABLE에 저장 
$sqlClassAdd = "INSERT INTO Class_Add (User_Id, CLass_Id, CTP_idx, C_A_Schedule,C_A_Memo,C_A_Status,C_A_Method, C_A_ApprovalDate, C_A_Date) 
           VALUES ('$User_ID', '$classid', '$tp', '$tzplanresult', '$memo', '0', '$cmethod', '0', now())";
$insert = mysqli_query($conn, $sqlClassAdd);

if ($sqlClassAdd)
$last_uid = mysqli_insert_id($conn); // 마지막으로 insert 된 값의 idx 값 가져오기 용도: 메일 전송후 수업 예약 승낙 여부를 Class_ADD tb내 C_A_Status 상태 변경용. 





//수업id 기준으로 해당 수업의 정보 
$sql = "SELECT * FROM Class_List WHERE CLass_Id = '{$classid}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$tusid = $row['1'];
$clname = $row['2'];
$cldisc = $row['3'];
$cltype = $row['4'];
$cllevel = $row['5'];



// 위의 수업을 개설한 강사의 '이름','email', 'timezone' 정보 
$sql = "SELECT 
User.U_Name, User.U_Email, User_Detail.U_D_Timezone
FROM User
JOIN User_Detail ON User.User_ID = User_Detail.User_Id
 where User.User_Id = '$tusid' ";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($result);

$tname = $row1['0'];
$temail = $row1['1'];
$tTimezone = $row1['2'];




// 신청한 수업 일정(plan) 값을 강사에게 보내주기 위한 코드 이며 강사의 TIMEZONE 기준으로 변환 되어 $sendtimeresult 에 저장됨 . 
$sendtime = array();
foreach($explan as $val){
  $i =0;
$save = $val + $tTimezone* $hour/1000;
$date = date('Y-m-d H:i:s',  $save);

$i =$i +1;
array_push($sendtime,$date);
}
$sendtimeresult = implode(",",$sendtime);


//메일 전송 
$subject = 'Hangle Square : '.$U_Name.' want register your class';
$message = '
'.$U_Name.' want to make a reservation your class!'. "<br/>".'
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.'. "<br/>".'
 
------------------------'. "<br/>".'
Student-Email: '.$U_Email.''. "<br/>".'  
Student-Name: '.$U_Name.''. "<br/>".'
Class-Name: '.$clname.''. "<br/>".'
Class-Type: '.$cltype.''. "<br/>".'
Class-Level: '.$cllevel.''. "<br/>".'
Class-TIME: '.$tp.' min'. "<br/>".'
Schedule:'.$i.'time(s)'. "<br/>".''.$sendtimeresult.''. "<br/>".'
Message: '.$memo."<br/>".'
------------------------'. "<br/>".'
 
AGREE(예약승인) : Please click this link to accept reservation for class :'.$clname.''. "<br/>".'
http://localhost/approvalreserv.php?email='.$U_Email.'&CAID='.$last_uid.'&agree='.'0'.'
'. "<br/>".'
'. "<br/>".'

REFUSE(예약거절): Please click this link to accept reservation for class :'.$clname.''. "<br/>".'
http://localhost/approvalreserv.php?email='.$U_Email.'&CAID='.$last_uid.'&agree='.'1'.'


'; // Our message above including the link;
try{
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
$mail->addAddress($temail);
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();


$data = array(
 
  'success'        	=> "yes"
);
echo json_encode($data);
  mysqli_close($conn);

} catch (Exception $e) {
//비정상일떄 
$data = array(
 
  'success'        	=> "Message could not be sent . Mailer Error: {
    $mail->ErrorInfo}"
);
echo json_encode($data);
mysqli_close($conn);

 ;
}