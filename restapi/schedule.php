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
$utc      =   json_decode(file_get_contents("php://input"))->{"utc"}; 
$tusid      =   json_decode(file_get_contents("php://input"))->{"tusid"};  // 강사의 userid 









if($token != null){

  //토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
// $User_ID =  base64_decode($payload['User_ID']);
$User_ID =  32;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


  //현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
  $sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
  $response1 = mysqli_query($conn, $sql);
  $row1 = mysqli_fetch_array($response1);
  
  
  $timezone = $row1['0'];
  $send['CONNECT_USER_TIMEZONE'] = $row1['0'];
  
  
  }else {

    $timezone = $utc;
    $send['CONNECT_USER_TIMEZONE'] = $utc;
  
  }







$sql = "SELECT Schedule FROM Teacher_Schedule WHERE User_Id = '$tusid'";
$response2 = mysqli_query($conn, $sql);

$result2['Schedule'] = array();



// 1시간 = 3600;
$hour = 3600000;

$resultarray = array();
//

while ($row1 = mysqli_fetch_array($response2)) {

 $schedule = $row1['0'];


 $schedule2 = $schedule + $hour*$timezone;



  array_push($resultarray, $schedule2);
}

 $string = implode("_",$resultarray);
  
     
 if ($response2) { //정상일떄  
  $data = array(
    'schedule'	=>	$string,
    'success'        	=>	'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else {//비정상일떄 
  $data = array(
    'schedule'	=>	'no',
    'success'        	=>	'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}
  
 