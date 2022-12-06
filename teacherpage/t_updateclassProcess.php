<?php
// 작성중!!!
// == 수업 수정 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 

//1. "token"    : "토큰값".
//2. "class_id"    : "수업 idx 값".


// 보낼 줄 때 형태 
// {
// "token"    : "토큰값".
// "class_id"    : "수업 idx 값"
// }



include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$class_id      =   json_decode(file_get_contents("php://input"))->{"class_id"}; // 수업명 




// date_default_timezone_set('Asia/Seoul');
// $time_now = date("Y-m-d H:i:s");
// error_log("$time_now, $position, $desc\n", "3", "../php.log");


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);



// class_id 값을 기준으로 해당 항목의 user_id를 비교해서
// 다를경우  안된다고 돌려보내기 
// 동일 하면  수정 process시작 



//Class_List에 수업 목록확인  
$check = "SELECT * FROM Class_List where CLass_Id = '{$class_id}'";
$checkresult = mysqli_query($conn, $check);


$row = mysqli_fetch_array($checkresult);
$User_Id = $row['User_Id'];


// 
if($User_Id != $User_ID) {

  $send["success"]   =  "no";
  echo json_encode($send);
  mysqli_close($conn);

}else {

//update 코드 작성중  상세페이지 작성 이후 예정 




}








// // Class_List에 수업 등록 
// $result = "INSERT INTO Class_List (User_Id, CL_Name, CL_Disc, CL_People, CL_Type,  CL_Date) VALUES ('$User_ID','$cname','$cintro','$people','$type',,now()) ";

// $insert = mysqli_query($conn, $result);



// // DB 정보 가져오기 
// $sql = "SELECT * FROM Class_List WHERE User_Id = '{$User_ID}'ORDER BY CLass_Id DESC LIMIT 1";
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_array($result);
// $Class_Id = $row['CLass_Id'];


// // Class_List에서 등록된 수업 idx 값(CLass_Id) 가져와서   Class_List_Time_Price 에 시간, 가격 리스트 별도로 저장     

// $R = json_decode($timeprice, true);
// // json_decode : JSON 문자열을 PHP 배열로 바꾼다
// // json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
// // $R : array data

// foreach ($R as $row) {
//   $time = $row['time'];
//   $price = $row['price'];

//   $result = "INSERT INTO Class_List_Time_Price (CLass_Id, Time, price, Date) VALUES ('$Class_Id','$time','$price',now())";
//   $insert = mysqli_query($conn, $result);
// }


// if ($insert) { //정상적으로 저장되었을때 

//   $send["success"]   =  "yes";
//   echo json_encode($send);
//   mysqli_close($conn);
// } else {

//   $send["success"]   =  "no";
//   echo json_encode($send);
//   mysqli_close($conn);
// }
