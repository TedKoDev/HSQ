<?php

// == 수업등록 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 

//1. "token"    : "토큰값".
//2. "cname"    : "수업명".
//3. "cintro"   : "수업소개".
//4. "timeprice"     : "[{"time":"30","price":"10"},{"time":"40","price":"20"},{"time":"50","price":"30"}]" 

//5. "people"   : "수업인원" 
//6. "type"     : "수업유형" 


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "cname"    : "수업명".
//  "cintro"   : "수업소개".
//  "timeprice"     :  "[{"time":"30","price":"10"},{"time":"40","price":"20"},{"time":"50","price":"30"}]" 

//  "people"   : "수업인원" 
//  "type"     : "수업유형" 

// }

//협의 사항 수업유형 및 수업일정 프론트단 파싱에 유리한 형태 정하기  
// 예시 ( '읽기,쓰기,말하기','월:0930~1500,화:1900~2000' )



include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$cname      =   json_decode(file_get_contents("php://input"))->{"cname"}; // 수업명 
$cintro     =   json_decode(file_get_contents("php://input"))->{"cintro"}; //수업소개
$timeprice  =   json_decode(file_get_contents("php://input"))->{"timeprice"};  //수업시간, 수업가격 
$people     =   json_decode(file_get_contents("php://input"))->{"people"};  //수업인원
$type       =   json_decode(file_get_contents("php://input"))->{"type"};  //수업유형




// date_default_timezone_set('Asia/Seoul');
// $time_now = date("Y-m-d H:i:s");
// error_log("$token, $cname, $cintro,$timeprice,$people,$type  \n", "3", "../php.log");


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);







// Class_List에 수업 등록 
$result = "INSERT INTO Class_List (User_Id, CL_Name, CL_Disc, CL_People, CL_Type,  CL_Date) VALUES ('$User_ID','$cname','$cintro','$people','$type',now()) ";

$insert = mysqli_query($conn, $result);



// DB 정보 가져오기 
$sql = "SELECT * FROM Class_List WHERE User_Id = '{$User_ID}'ORDER BY CLass_Id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$Class_Id = $row['CLass_Id'];


// Class_List에서 등록된 수업 idx 값(CLass_Id) 가져와서   Class_List_Time_Price 에 시간, 가격 리스트 별도로 저장     

$R = json_decode($timeprice, true);
// json_decode : JSON 문자열을 PHP 배열로 바꾼다
// json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
// $R : array data

foreach ($R as $row) {
  $time = $row['time'];
  $price = $row['price'];

  $result = "INSERT INTO Class_List_Time_Price (CLass_Id, Time, price, Date) VALUES ('$Class_Id','$time','$price',now())";
  $insert = mysqli_query($conn, $result);
}


if ($insert) { //정상적으로 저장되었을때 

  $send["success"]   =  "yes";
  echo json_encode($send);
  mysqli_close($conn);
} else {

  $send["success"]   =  "no";
  echo json_encode($send);
  mysqli_close($conn);
}
