<?php

// == add_review 프로세스==
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
$User_ID = 324; //강사/학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone


$kind = base64_decode($payload['kind']); //kind
 $kind = 'teacher'; //kind
// $kind = 'student'; //kind
$class_register_id = base64_decode($payload['class_register_id']); //class_register_id
$class_register_id = 38; //class_register_id

$teacher_review = base64_decode($payload['teacher_review']); //class_registe_status 승인 or 취소 
  $teacher_review = '텍스트' ; //teacher_review 텍스트 


$Sql3 = "SELECT Class_Add.user_id_teacher, Class_Add.schedule_list FROM Class_Add where Class_Add.class_register_id =  '$class_register_id'";
$SRCList_Result3 = mysqli_query($conn, $Sql3);

$row3 = mysqli_fetch_array($SRCList_Result3);

$send['user_id_teacher'] = $row3['user_id_teacher']; //강사의 유저 번호  
echo $user_id_teacher = $row3['user_id_teacher']; //강사의 유저 번호  

$send['schedule_list'] = $row3['schedule_list']; //수업일정
echo $schedule_list = $row3['schedule_list']; //수업일정



if($kind == 'teacher'){

  $class_register_status = '888';

  $select = "UPDATE Teacher_Schedule INNER JOIN Class_Add ON Teacher_Schedule.user_id_teacher = Class_Add.user_id_teacher SET Teacher_Schedule.teacher_schedule_status = '$class_register_status', 
  Class_Add.class_register_status = '$class_register_status' 
  where Class_Add.class_register_id = '$class_register_id' and Class_Add.user_id_teacher = '$user_id_teacher' and Class_Add.schedule_list = '$schedule_list' and Teacher_Schedule.schedule_list = '$schedule_list' and Teacher_Schedule.user_id_teacher = '$user_id_teacher'";
  $response = mysqli_query($conn, $select);
  mysqli_close($conn);



 if ($response) { //정상적으로 파일 저장되었을때 

  $select1 = "INSERT INTO Class_Teacher_Review (class_register_id, teacher_review, teacher_review_date) VALUES ('$class_register_id', '$teacher_review', now()) ";
  $response1 = mysqli_query($conn, $select1);
  mysqli_close($conn);

  if ($response1) { //정상적으로 파일 저장되었을때 

    $send["class_register_id"]   =  'Class_Teacher_Review 값 insert 성공 ';
    $send["teacher_review"]   =  $teacher_review;
    $send["success"]   =  "yes";
    echo json_encode($send);
  
  } else {
    $send["class_register_id"]   =  'Class_Teacher_Review 값 insert 실패';
    $send["teacher_review"]   =  $teacher_review;
    $send["success"]   =  "no";
    echo json_encode($send);
   
  }



  $send["class_register_id"]   = '';
  $send["teacher_review"]   =  $teacher_review;
  $send["success"]   =  "yes";
  echo json_encode($send);

} else {
  $send["class_register_id"]   =  $class_register_id;
  $send["teacher_review"]   =  $teacher_review;
  $send["success"]   =  "no";
  echo json_encode($send);
 
}
}else if($kind == 'student'){


  $select = "UPDATE Class_Add SET class_register_status = '$class_register_status', class_register_answer_date = $answerTime where class_register_id = '$class_register_id' ";
  $response = mysqli_query($conn, $select);
  mysqli_close($conn);
 
 
  if ($response) { //정상적으로 파일 저장되었을때 
   $send["class_register_status"]   =  $status;
   $send["class_register_answer_date"]   =  $class_register_answer_date;
   $send["success"]   =  "yes";
   echo json_encode($send);
 
 } else {
   $send["status"]   =  $status;
   $send["class_register_answer_date"]   =  $class_register_answer_date;
   $send["success"]   =  "no";
   echo json_encode($send);
  
 }


}
 