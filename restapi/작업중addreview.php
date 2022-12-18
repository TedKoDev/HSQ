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
// $User_ID = 324; //강사/학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone


$kind = base64_decode($payload['kind']); //kind
// $kind = 'teacher'; //kind
// $kind = 'student'; //kind
$class_register_id = base64_decode($payload['class_register_id']); //class_register_id
// $class_register_id = 38; //class_register_id
$class_register_status = base64_decode($payload['class_register_status']); //class_registe_status 승인 or 취소 
// $class_register_status = 1 or 2; //class_registe_status 승인 or 취소 


if($class_register_status == '1'){
  $status = 'approved';
} else if ($class_register_status == '2'){
  $status = 'cancel';
}




 $answerTime =    time();
 $class_register_answer_date =     $answerTime * 1000;
//  $date = date('Y-m-d H:i:s', $answerTime);


if($kind == 'teacher'){
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
 