<?php

// == 강사수업가능 시간 설정 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "plan" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값"
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출. 
// 2.User_Id 기준으로 User_Detail 에서 사용자의 TIMEZONE 값을 가져온다. 
// 3.User_Id 기준으로 Teacher_Schedule 에서 사용자의 Schedule 값을 가져온다. 
// 4.Schedule 내의 스트링값을 분리한뒤 TIMEZONE값 *2를 적용한 결과 값을 얻는다. 이때 결과같은 336을 넘지 않도록 하며 넘는 경우 -336을 진행한 값을 이용한다. 
// 5. 결과값을 배열에 담은후 다시 '_' 을 적용한 STRING 값으로 변환시켜 프론트엔드로 전달한다. 

// #특이사항
// TIMEZONE *2를 하는 이유는  30분단위로 구분하여 스케쥴표를 작성했기 떄문에 timezone +1인 경우  *2를 해주어야한다. 



include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
// 토큰 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; 




//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);




//U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1); 
$timezone = $row1['0'].'</br>';



$sql = "SELECT Schedule FROM Teacher_Schedule WHERE User_Id = '{$User_ID}'";
$response2 = mysqli_query($conn, $sql);

$result2['Schedule'] = array();



// 1시간 = 3600;
$hour = 3600000;

$resultarray = array();

while ($row1 = mysqli_fetch_array($response2)) {

 $schedule = $row1['0'];


  $schedule2 = $schedule + $hour*$timezone;



  array_push($resultarray, $schedule2);
}

 $string = implode("_",$resultarray);
  
     
 if ($response1) { //정상일떄  
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
  