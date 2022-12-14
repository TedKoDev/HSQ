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
// 1.토큰 수령후 User_Id 값 추출 , plan 값을 수령한다. 
// 2.User_Id 기준으로 User_Detail 에서 사용자의 TIMEZONE 값을 가져온다. 
// 3.plan 내의 스트링값을 분리한뒤 TIMEZONE값 *2를 적용한 결과 값을 얻는다. 이때 결과같은 336을 넘지 않도록 하며 넘는 경우 -336을 진행한 값을 이용한다. 
// 4. 결과값을 배열에 담은후 다시 '_' 을 적용한 STRING 값으로 변환시켜 db에 저장한다. 
// 5. DB Table Teacher_Schedule 에 저장할때 우선 해당 user_id 가 작성한 값이 있는지를 확인하고 있는경우 insert 없는경우 update로 진행되게 한다. 

// #특이사항
// TIMEZONE *2를 하는 이유는  30분단위로 구분하여 스케쥴표를 작성했기 떄문에 timezone +1인 경우  *2를 해주어야한다. 



include("../../conn.php");
include("../../jwt.php");


$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";

// 토큰 
$token     =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰값 
$repeat      =   json_decode(file_get_contents("php://input"))->{"repeat"}; // 몇주 반복 여부  4, 8, 12 주  
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"}; // 
$plan      =   json_decode(file_get_contents("php://input"))->{"schedule_list"};  // 일정 

// unset($plan[0]);
// error_log("$plan , $utc \n", "3", "../php.log");


// $plan      =  '1669894200_1669896000_1669897800';
// $plan      =  '1000_2000';
// $repeat    = 8; // 몇주 반복 여부  4, 8, 12 주  
// $utc       = 9;  // 일정 


$hour = 3600000;




//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone




// if ($result != null) {

// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$result = (explode("_", $plan));


$resultarray = array();
foreach ($result as $val) {

  $val;
  if ($val != 0) {
    // $save = $val - $timezone * $hour;
    $save = $val;
  }


  array_push($resultarray, $save);
}

json_encode($resultarray);

$resultsql = "DELETE FROM Teacher_Schedule   WHERE user_id_teacher = '$User_ID' and teacher_schedule_status = '9'";
$response = mysqli_query($conn, $resultsql);


foreach ($resultarray as $val) {

  $val;

  if ($val != null) {
    $result = "INSERT INTO Teacher_Schedule (user_id_teacher, schedule_list) VALUES ('$User_ID', '$val') ";
    $response = mysqli_query($conn, $result);
  } else if ($val == null) {

    $resultsql = "DELETE FROM Teacher_Schedule   WHERE user_id_teacher = '$User_ID' and teacher_schedule_status = '9'";
    $response = mysqli_query($conn, $resultsql);
  }
}


if ($response) { //정상일떄  
  $data = array(
    'schedule_list'            =>   $resultarray,
    'success'          =>  'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else { //비정상일떄 
  $data = array(

    'success'          =>  'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}
