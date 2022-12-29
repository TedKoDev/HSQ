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
file_get_contents("php://input") ;

$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 
$class_id    =   json_decode(file_get_contents("php://input"))->{"class_id"}; // 수업id 
// $class_id    =   167; // 수업id 
$tp         =   json_decode(file_get_contents("php://input"))->{"tp"}; // 수업시간 
// $tp         =  30 ; // 수업시간 
$schedule       =   json_decode(file_get_contents("php://input"))->{"schedule_list"}; // 수업일정 
// // $schedule       =   json_decode(file_get_contents("php://input"))->{"schedule_list"}; // 수업일정 
// $schedule       =   '1670385600000_1670383800000_1670387400000_1670389200000_1670391000000'; // 수업일정 
// $schedule       =   '1670385600000'; // 수업일정 


$class_method    =   json_decode(file_get_contents("php://input"))->{"class_register_method"}; // 수업방식 
// $class_method    =   0; // 수업방식 

$class_register_memo       =   json_decode(file_get_contents("php://input"))->{"class_register_memo"}; // 강사메모
// $class_register_memo       =  '123밥바오밥'; // 강사메모





//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //학생의 userid
// $User_ID = 32; //학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone



error_log("token : $token , user_id : $User_ID ,  class_id :  $class_id , 수업시간(30,60) :  $tp  , 수업일정: $schedule,  수업도구: $class_method, 수업메모:  $class_register_memo   \n", "3", "../php.log");





//수업id 기준으로 해당 수업의 정보 
$sql = "SELECT * FROM Class_List WHERE class_id = '{$class_id}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

 $tusid = $row['1'];
$clname = $row['2'];
$cldisc = $row['3'];
$cltype = $row['4'];
$cllevel = $row['5'];





// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$explan = (explode("_", $plan));
$tzplan = array(); //Timezone 적용을 위한 배열 생성
foreach($explan as $val){ 
$save = $val - $timezone* $hour;
$date = date('Y-m-d H:i:s',  $save);



//1시간 = 3600000;
$hour   = 3600000;

// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$exschedule = (explode("_", $schedule));
// echo $exschedule;

$tzschedule = array(); //Timezone 적용을 위한 배열 생성
foreach($exschedule as $val){ 
$save = $val - $timezone* $hour;
// $date = date('Y-m-d H:i:s',  $save);

// echo $save;

// Class_Add DB TABLE에 저장 
$sqlClassAdd = "INSERT INTO Class_Add (user_id_student, user_id_teacher, class_id, class_time, schedule_list, class_register_memo, class_register_status , class_register_review , class_register_review_student ,class_register_method, class_register_answer_date, class_register_date) 
           VALUES ('$User_ID', '$tusid','$class_id', '$tp', '$save', '$class_register_memo', '0','0','0', '$class_method', '0' , now())";
// $sqlClassAdd = "INSERT INTO Class_Add (user_id_student, user_id_teacher, class_id, class_time, schedule_list, class_register_memo, class_register_status ,class_register_method, class_register_answer_date, class_register_date) 
//            VALUES ('1', '2', '3', '4', '5555555555','6', '0', '33', '0' , now())";

$insert = mysqli_query($conn, $sqlClassAdd);

if ($sqlClassAdd) 
$last_CAID = mysqli_insert_id($conn); // 마지막으로 insert 된 값의 idx 값 가져오기 용도: 메일 전송후 수업 예약 승낙 여부를 Class_ADD tb내 C_A_Status 상태 변경용. 
// echo 'ff'. $last_CAID ;



if ($insert) { //정상일떄

  $select = "UPDATE Teacher_Schedule  SET teacher_schedule_status = '0' where user_id_teacher = '$tusid' and schedule_list = '$save'";

$response4 = mysqli_query($conn, $select);


if ($response4) { //정상일떄
  
  
  $data = array(
    'schedule_list'            =>   'Teacher_Schedule 값 업뎃 됨',
    'success'        	=>	'yes'   
  );
  // echo json_encode($data);
  // mysqli_close($conn);
} else {//비정상일떄 
  $data = array(
    'schedule_list'            =>   'Teacher_Schedule 값 업뎃 안됨',
    'success'        	=>	'no'
  );
  // echo json_encode($data);
  // mysqli_close($conn);
}
  
  $data = array(
    'schedule_list'            =>   'class_add  잘됨',
    'success'        	=>	'yes',
    'lastclassregisterid'        	=>	$last_CAID
  );
  // echo json_encode($data);
  // mysqli_close($conn);
} else {//비정상일떄 
  $data = array(
 
    'success'        	=>	'no'
  );
  // echo json_encode($data);
  // mysqli_close($conn);
}



array_push($tzplan,$save);
}
$tzplanresult = implode("_",$tzplan); // 다시 합체 




array_push($tzschedule,$save);
}
$tzscheduleresult = implode("_",$tzschedule); // 다시 합체 




// 위의 수업을 개설한 강사의 '이름','email', 'timezone' 정보 
$sql = "SELECT User.user_name, User.user_email, User_Detail.user_timezone
FROM User
JOIN User_Detail ON User.user_id = User_Detail.user_id
 where User.user_id = '$tusid' ";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($result);

 $tname = $row1['0'];
 $temail = $row1['1'];
 $tTimezone = $row1['2'];




// 신청한 수업 일정(schedule) 값을 강사에게 보내주기 위한 코드 이며 강사의 TIMEZONE 기준으로 변환 되어 $sendtimeresult 에 저장됨 . 
$sendtime = array();
$i =0;
foreach($exschedule as $val){

 $save1 = ($val + $tTimezone * $hour)/1000 ;
// echo $save2 = $save1/1000;

 $date = date('Y-m-d H:i:s', $save1);
 $date = date('Y-m-d H:i:s', $save1);

$i =$i +1;
 $i;
 $i;
array_push($sendtime,$date);
}
$sendtimeresult = implode(",  ",$sendtime);


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
Schedule:  '.$i.'time(s)'. "<br/>".''.$sendtimeresult.''. "<br/>".'
Message: '.$class_register_memo."<br/>".'
------------------------'. "<br/>".'
 


'; // Our message above including the link;
try{
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
  'class_register_id'        	=>	$last_CAID,
  'user_name'        	=>	$U_Name
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
mysqli_close($conn);

 ;
}


// AGREE(예약승인) : Please click this link to accept reservation for class :'.$clname.''. "<br/>".'
// http://localhost/reservefinal/reserveApproval.php?email='.$U_Email.'&CAID='.$last_CAID.'&agree='.'1'.'
// '. "<br/>".'
// '. "<br/>".'

// REFUSE(예약거절): Please click this link to accept reservation for class :'.$clname.''. "<br/>".'
// http://localhost/reservefinal/reserveApproval.php?email='.$U_Email.'&CAID='.$last_CAID.'&agree='.'2'.'