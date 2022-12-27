<?php

// == class_register_accept 프로세스==
//   #요구되는 파라미터 
//  token 
//  kind
//  class_register_id
//  class_register_status

// 반환되는 값 
// {"class_register_status":"approved",
  // "class_register_answer_date":1671338833000,
  // "success":"yes"}



include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 

//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //강사/학생의 userid
// $User_ID = 324; //강사/학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone


$kind      =   json_decode(file_get_contents("php://input"))->{"kind"}; // 
$class_register_id      =   json_decode(file_get_contents("php://input"))->{"class_register_id"}; // 
$class_register_status      =   json_decode(file_get_contents("php://input"))->{"class_register_status"}; // 
error_log("$kind ,   $token,  $class_register_id,   $class_register_status, \n", "3", "../php.log");

if($class_register_status == '1'){
  $status = 'approved';
} else if ($class_register_status == '2'){
  $status = 'cancel';
}


$Sql3 = "SELECT Class_Add.user_id_teacher, Class_Add.schedule_list FROM Class_Add where Class_Add.class_register_id =  '$class_register_id'";
$SRCList_Result3 = mysqli_query($conn, $Sql3);

$row3 = mysqli_fetch_array($SRCList_Result3);

// $send['class_register_id'] = $row3['class_register_id']; //신청된 수업 번호   
// $class_register_id = $row3['class_register_id']; //강사의 유저 번호  

$send['user_id_teacher'] = $row3['user_id_teacher']; //강사의 유저 번호  
$user_id_teacher = $row3['user_id_teacher']; //강사의 유저 번호  

$send['schedule_list'] = $row3['schedule_list']; //수업일정
$schedule_list = $row3['schedule_list']; //수업일정






 $answerTime =    time();
 $class_register_answer_date =     $answerTime * 1000;
//  $date = date('Y-m-d H:i:s', $answerTime);


if($kind == 'teacher'){


  $select2 = "UPDATE Teacher_Schedule INNER JOIN Class_Add ON Teacher_Schedule.user_id_teacher = Class_Add.user_id_teacher SET Teacher_Schedule.teacher_schedule_status = '$class_register_status', 
  Class_Add.class_register_status = '$class_register_status' , Class_Add.class_register_answer_date = '$class_register_answer_date'
  where Class_Add.class_register_id = '$class_register_id' and Class_Add.user_id_teacher = '$user_id_teacher' and Class_Add.schedule_list = '$schedule_list' and Teacher_Schedule.schedule_list = '$schedule_list' and Teacher_Schedule.user_id_teacher = '$user_id_teacher'";
$response2 = mysqli_query($conn, $select2);
mysqli_close($conn);





 if ($response2) { //정상적으로 파일 저장되었을때 
  $send["class_register_status"]   =  $status;
  $send["class_register_answer_date"]   =  $class_register_answer_date;
  $send["class_register_id"]   =  $class_register_id;

  $send["success"]   =  "yes";
  echo json_encode($send);

} else {
  $send["status"]   =  $status;
  $send["class_register_answer_date"]   =  $class_register_answer_date;
  $send["success"]   =  "no22";
  echo json_encode($send);
 
}
}else if($kind == 'student'){


  $select = "UPDATE Teacher_Schedule INNER JOIN Class_Add ON Teacher_Schedule.user_id_teacher = Class_Add.user_id_teacher SET Teacher_Schedule.teacher_schedule_status = '$class_register_status', 
  Class_Add.class_register_status = '$class_register_status' , Class_Add.class_register_answer_date = '$class_register_answer_date'
  where Class_Add.class_register_id = '$class_register_id' and Class_Add.user_id_teacher = '$user_id_teacher' and Class_Add.schedule_list = '$schedule_list' and Teacher_Schedule.schedule_list = '$schedule_list' and Teacher_Schedule.user_id_teacher = '$user_id_teacher'";
$response = mysqli_query($conn, $select);
// mysqli_close($conn);
 
 
  if ($response) { //정상적으로 파일 저장되었을때 
   $send["class_register_status"]   =  $status;
   $send["class_register_answer_date"]   =  $class_register_answer_date;
   $send["class_register_id"]   =  $class_register_id;
   $send["success"]   =  "yes";
   echo json_encode($send);
 
 } else {
   $send["status"]   =  $status;
   $send["class_register_answer_date"]   =  $class_register_answer_date;
   $send["success"]   =  "no";
   echo json_encode($send);
  
 }


}
 