<?php

// == 강사수업가능 시간 설정 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "plan" : "스케쥴"  
//2. "tusid" : "강사의 userid "  

/***

강사일정  RestAPI
schedule.php

분기 조건 
1. token 있다/없다.


출력정보  

1. 토큰 있는경우 사용자의 timzone 적용   

2. 토큰 없는경우 전달받은 (비로그인)  사용자의 로컬 타임 utc를 timezone으로 적용  


 
 */



include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
// 토큰 

$token      =   json_decode(file_get_contents("php://input"))->{"token"}; 
// $token      =   11; 
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"}; 
// $utc      =   9; 
$tusid      =   json_decode(file_get_contents("php://input"))->{"user_id_teacher"};  // 강사의 userid 
// $tusid      =   324;  // 강사의 userid 









if($token != null){

  //토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
// $User_ID =  32;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


  //현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
  $sql = "SELECT user_timezone FROM User_Detail WHERE user_id = '{$User_ID}'";
  $response1 = mysqli_query($conn, $sql);
  $row1 = mysqli_fetch_array($response1);
  
  
  $timezone = $row1['0'];
  // $send['CONNECT_USER_TIMEZONE'] = $row1['0'];

  
  }else {
// echo 111;
    $timezone = $utc;
    // $send['CONNECT_USER_TIMEZONE'] = $utc;

  }







$sql = "SELECT schedule_list, teacher_schedule_status FROM Teacher_Schedule WHERE user_id_teacher = '$tusid'";
$response2 = mysqli_query($conn, $sql);
$result2['schedule_list'] = array();
// 1시간 = 3600;
$hour = 3600000;
$resultarray = array();
$status_resultarray = array();
while ($row1 = mysqli_fetch_array($response2)) {
 $schedule = $row1['0'];
 $schedule_status = $row1['1'];
 $schedule2 = $schedule + $hour*$timezone;
  array_push($resultarray, $schedule2);
  array_push($status_resultarray, $schedule_status);
}
 $string = implode("_",$resultarray);
 $string_status = implode("_",$status_resultarray);
  
 

//예약된 수업 리스트만 
//  $sql = "SELECT * FROM Teacher_Schedule WHERE user_id_teacher = '$tusid' and  teacher_schedule_status = '1'";
 $sql = "SELECT * FROM Teacher_Schedule WHERE user_id_teacher = '$User_ID' and  teacher_schedule_status = '1'";
 $response3 = mysqli_query($conn, $sql);
  
 // 1시간 = 3600;
 $hour = 3600000;
 $예약된스케쥴 = array();
  while ($row1 = mysqli_fetch_array($response3)) {
   $schedule = $row1['2'];
  $status = $row1['3'];
    $schedule3 = $schedule + $hour*$timezone;
    array_push($예약된스케쥴, $schedule3);
 }
 
  $string2 = implode("_",$예약된스케쥴);

  
     
 if ($response1&&$response2&&$response3) { //정상일떄  
  $data = array(
    'user_timezone'  => $timezone,
    'teacher_schedule_list'	=>	$string,
    'teacher_schedule_list_status'	=>	$string_status,
    'user_reserved_schedule_list'	=>	$string2,
 
    'success'        	=>	'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else {//비정상일떄 
  $data = array(
    'user_timezone'  => 'no',
    'schedule_list'	=>	'no',
    'success'        	=>	'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}
  
 