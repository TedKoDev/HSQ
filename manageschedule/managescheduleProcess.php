<?php

// == 강사수업가능 시간 설정 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "plan" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "plan"    : "일정  (예시 13,14,55,56,57 ...)".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 




include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
// 토큰 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; 
$plan      =   json_decode(file_get_contents("php://input"))->{"plan"}; 




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




//Class_List에 수업 목록확인  
$sql = "SELECT U_D_Timeze FROM User_Detail WHERE User_Id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);



$row1 = mysqli_fetch_array($response1); 
$timezone = $row1['0'];












  
