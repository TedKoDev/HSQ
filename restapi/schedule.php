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









if ($token != null) {

  //토큰 해체 
  $data = $jwt->dehashing($token);
  $parted = explode('.', base64_decode($token));
  $payload = json_decode($parted[1], true);
  $User_ID =  base64_decode($payload['User_ID']);
  // $User_ID =  324;
  $U_Name  = base64_decode($payload['U_Name']);
  $U_Email = base64_decode($payload['U_Email']);
  $timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone
  // $timezone      =   8;

} else {
  // echo 111;
  $timezone = $utc;
  // $send['CONNECT_USER_TIMEZONE'] = $utc;


  // $User_ID =  324;

}






$sql = "SELECT Teacher_Schedule.schedule_list, Teacher_Schedule.teacher_schedule_status, Teacher_Schedule.teacher_schedule_review, Teacher_Schedule.class_time FROM Teacher_Schedule
LEFT outer join Class_Add ON Teacher_Schedule.user_id_teacher =  Class_Add.user_id_teacher WHERE Teacher_Schedule.user_id_teacher = '$tusid'";


$response2 = mysqli_query($conn, $sql);
$result2['schedule_list'] = array();
// 1시간 = 3600;
$hour = 3600000;
$resultarray = array();
$status_resultarray = array();
$review_resultarray = array();
$time_resultarray = array();
while ($row1 = mysqli_fetch_array($response2)) {
  $schedule = $row1['schedule_list'];
  $schedule_status = $row1['teacher_schedule_status'];
  $schedule_review = $row1['teacher_schedule_review'];
  $schedule_time = $row1['class_time'];
  // $schedule2 = $schedule + $hour * $timezone;
  $schedule2 = $schedule;
  array_push($resultarray, $schedule2);
  array_push($status_resultarray, $schedule_status);
  array_push($review_resultarray, $schedule_review);
  array_push($time_resultarray, $schedule_time);
}
$string = implode("_", $resultarray);
$string_status = implode("_", $status_resultarray);
$string_review = implode("_", $review_resultarray);
$string_time = implode("_", $time_resultarray);



//예약된 수업 리스트만 
$sql = "SELECT * FROM Teacher_Schedule WHERE user_id_teacher = '$tusid' and  teacher_schedule_status = '1'";
//  $sql = "SELECT * FROM Teacher_Schedule WHERE user_id_teacher = '$User_ID' and  teacher_schedule_status = '1'";
$response3 = mysqli_query($conn, $sql);

// 1시간 = 3600;
$hour = 3600000;
$예약된스케쥴 = array();
while ($row1 = mysqli_fetch_array($response3)) {
  $schedule = $row1['schedule_list'];
  $status = $row1['teacher_schedule_status'];
  //  $schedule3 = $schedule + $hour*$timezone;
  $schedule3 = $schedule;
  array_push($예약된스케쥴, $schedule3);
}

$string2 = implode("_", $예약된스케쥴);



if ($response3) { //정상일떄  
  $data = array(
    'user_timezone'  => $timezone,
    'teacher_schedule_list'   =>   $string,
    'teacher_schedule_list_status'   =>   $string_status,
    'teacher_schedule_list_review'   =>   $string_review,
    'schedule_time'   =>   $string_time,
    'user_reserved_schedule_list'   =>   $string2,

    'success'           =>   'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else { //비정상일떄 
  $data = array(
    'user_timezone'  => 'no',
    'schedule_list'   =>   'no',
    'success'           =>   'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}