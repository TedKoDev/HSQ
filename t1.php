<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "schedule" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 




include("./conn.php");
include("./jwt.php");


//Class_List에 수업 목록확인  
$sql = "SELECT * FROM Class_List WHERE User_Id = '32'";
$response1 = mysqli_query($conn, $sql);


$result1['data'] = array();
$result2['timeprice'] = array();


while ($row1 = mysqli_fetch_array($response1)){
  $clid= $row1['0'];

  $send['class_id'] = $row1['0'];
  $send['clname'] = $row1['2'];
  $send['cldisc'] = $row1['3'];
  $send['clpeople'] = $row1['4'];
  $send['cltype'] = $row1['5'];
  $send['cllevel'] = $row1['6'];
 

//Class_List_Time_Price 수업 시간, 가격 확인   
$sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
$response2 = mysqli_query($conn, $sql);

while ($row2 = mysqli_fetch_array($response2)){
 
   $tp['Time'] = $row2['2'];
   $tp['Price'] = $row2['3']; 

 array_push($result2['timeprice'],$tp);

 }
//  echo json_encode($result2);

$send['tp'] = $result2['timeprice'];

array_push($result1['data'],$send);
$result2['timeprice'] = array();
}

$result1["success"] = "1";
echo json_encode($result1);


mysqli_close($conn);