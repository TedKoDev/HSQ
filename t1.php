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








//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1);
$timezone = $row1['0'];


//배열생성 
$result3['result'] = array();
$result1['data'] = array();
$result2['timeprice'] = array();



//Class_List에 수업 목록확인  
$sql = "SELECT 
User.U_Name, 
User_Teacher.U_T_Special,  
User_Detail.U_D_Img,
User_Detail.U_D_Language,
User_Detail.U_D_Intro,
User_Teacher.U_T_Intro ,
User_Detail.U_D_Country,
User_Detail.U_D_Residence,
Teacher_Schedule.Schedule
FROM User
JOIN User_Detail
  ON User.User_ID = User_Detail.User_Id
JOIN User_Teacher
  ON User_Teacher.User_Id = User_Detail.User_Id 
JOIN Teacher_Schedule
  ON Teacher_Schedule.User_Id = User_Detail.User_Id
 where User.User_Id = '$usid' ";
$response1 = mysqli_query($conn, $sql);



$row1 = mysqli_fetch_array($response1);


$send['U_Name'] = $row1['0'];
$send['U_T_Special'] = $row1['1'];
$send['U_D_Img'] = $row1['2'];
$send['U_D_Language'] = $row1['3'];
$send['U_D_Intro'] = $row1['4'];
$send['U_T_Intro'] = $row1['5'];
$send['U_D_Country'] = $row1['6'];
$send['U_D_Residence'] = $row1['7'];

$plan1 = $row1['8'];


//db에서 가져온 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$planresult = (explode("_", $plan1));

// echo $planresult;

$resultarray = array();
//

foreach ($planresult as $val) {

  $val . "</br>";

  $save = $val - $timezone * 2;

  // echo $save;
  if ($save > 336) {

    $save = $save - 336;
  }


  array_push($resultarray, $save);
}


$string = implode("_", $resultarray);

$send['Schedule'] = $string;




//Class_List에 수업 목록확인  
$sql = "SELECT * FROM Class_List WHERE User_Id = '{$usid}'";
$response1 = mysqli_query($conn, $sql);



while ($row1 = mysqli_fetch_array($response1)) {
  $clid = $row1['0'];

  $send1['class_id'] = $row1['0'];
  $send1['clname'] = $row1['2'];
  $send1['cldisc'] = $row1['3'];
  $send1['clpeople'] = $row1['4'];
  $send1['cltype'] = $row1['5'];
  $send1['cllevel'] = $row1['6'];


  //Class_List_Time_Price 수업 시간, 가격 확인   
  $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
  $response2 = mysqli_query($conn, $sql);

  while ($row2 = mysqli_fetch_array($response2)) {

    $tp['Time'] = $row2['2'];
    $tp['Price'] = $row2['3'];

    array_push($result2['timeprice'], $tp);
  }
  //  echo json_encode($result2);

  $send1['tp'] = $result2['timeprice'];

  array_push($result1['data'], $send1);
  $result2['timeprice'] = array();
}
$send['class'] = $result1['data'];
array_push($result3['result'], $send);
// $result1["success"] = "1";
$result3["success"] = "1";
echo json_encode($result3);


mysqli_close($conn);
