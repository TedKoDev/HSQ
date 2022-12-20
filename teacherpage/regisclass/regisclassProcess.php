<?php

// == 수업등록 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 

//1. "token"    : "토큰값".
//2. "class_name"    : "수업명".
//3. "class_description"   : "수업소개".
//4. "class_timeprice"     : "[{"class_time":"30","class_price":"10"},{"class_time":"40","class_price":"20"},{"class_time":"50","class_price":"30"}]" 

//5. "class_people"   : "수업인원" 
//6. "class_type"     : "수업유형" 
//7. "leveltype"     : "수업수준" 


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "class_name"    : "수업명".
//  "class_description"   : "수업소개".
//  "class_timeprice"     :  "[{"class_time":"30","class_price":"10"},{"class_time":"40","class_price":"20"},{"class_time":"50","class_price":"30"}]" 

//  "class_people"   : "수업인원" 
//  "class_type"     : "수업유형" 
//  "class_level"     : "수업수준" 

// }

//협의 사항 수업유형 및 수업일정 프론트단 파싱에 유리한 형태 정하기  
// 예시 ( '읽기,쓰기,말하기','월:0930~1500,화:1900~2000' )



include("../../conn.php");
include("../../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$class_name      =   json_decode(file_get_contents("php://input"))->{"class_name"}; // 수업명 
$class_description     =   json_decode(file_get_contents("php://input"))->{"class_description"}; //수업소개
$class_timeprice  =   json_decode(file_get_contents("php://input"))->{"class_timeprice"};  //수업시간, 수업가격 
$class_people     =   json_decode(file_get_contents("php://input"))->{"class_people"};  //수업인원
$class_type       =   json_decode(file_get_contents("php://input"))->{"class_type"};  //수업유형 
$class_level       =   json_decode(file_get_contents("php://input"))->{"class_level"};  //수업수준
// $class_timeprice       =   json_decode(file_get_contents("php://input"))->{"class_timeprice"};  //수업수준




// date_default_timezone_set('Asia/Seoul');
// $time_now = date("Y-m-d H:i:s");
error_log("$token, $class_name, $class_description,$class_timeprice,$class_people,$class_type ,$class_level ,$class_timeprice \n", "3", "../php.log");


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);







// Class_List에 수업 등록 
$result = "INSERT INTO Class_List (user_id_teacher, class_name, class_description, class_people, class_type, class_level,  class_open_date) VALUES ('$User_ID','$class_name','$class_description','$class_people','$class_type','$class_level', now()) ";

$insert = mysqli_query($conn, $result);



// DB 정보 가져오기 
$sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$User_ID}'ORDER BY class_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$Class_Id = $row['class_id'];


// Class_List에서 등록된 수업 idx 값(class_id) 가져와서   Class_List_Time_Price 에 시간, 가격 리스트 별도로 저장     

$R = json_decode($class_timeprice, true);
// json_decode : JSON 문자열을 PHP 배열로 바꾼다
// json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
// $R : array data

foreach ($R as $row) {
  $class_time = $row['class_time'];
  $class_price = $row['class_price'];

  $result = "INSERT INTO Class_List_Time_Price (class_id, class_time, class_price, class_list_time_price_date) VALUES ('$Class_Id','$class_time','$class_price',now())";
  $insert = mysqli_query($conn, $result);
}


if ($insert) { //정상적으로 저장되었을때 

  $send["success"]   =  "yes";
  // echo json_encode($send);
  mysqli_close($conn);
} else {

  $send["success"]   =  "no";
  // echo json_encode($send);
  mysqli_close($conn);
}

  // $send["success"]   =  "no";
  // echo json_encode($send);
  // mysqli_close($conn);