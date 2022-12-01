<?php


include("./conn.php");
include("./jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";

// 토큰 
// $token     =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰값 
// // $repeat      =   json_decode(file_get_contents("php://input"))->{"repeat"}; // 몇주 반복 여부  4, 8, 12 주  
// $repeat    = 8; // 몇주 반복 여부  4, 8, 12 주  
// $utc       = 9;  // 일정 
// // $plan      =   json_decode(file_get_contents("php://input"))->{"plan"};  // 일정 
// // $plan      =  '1669894200_1669896000_1669897800';
$plan      =  '1000_2000';
$repeat    = 2; // 몇주 반복 여부  4, 8, 12 주  
$utc       = 1;  // 일정 

// 1시간 = 3600;
 $hour = 3600;

// 1주 = 604800
 $week = 604800;


// error_log("$time_now, $position, $desc\n", "3", "/php.log");

//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
// $User_ID =  base64_decode($payload['User_ID']);
$User_ID =  32;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


  
$check = "SELECT * FROM Teacher_Schedule where User_Id = '{$User_ID}'";
$checkresult = mysqli_query($conn, $check);


// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$result = (explode("_", $plan));


$resultarray= array();
foreach($result as $val){

 $val;
  
// echo  '==='."</br>";

 'utc적용 '.$save = $val - $hour*$utc;
// echo  '=@@='."</br>";
// $result = "INSERT INTO Teacher_Schedule (User_Id, Schedule) VALUES ('{$User_ID}', '$save') ";
// $response = mysqli_query($conn, $result);
array_push($resultarray,$save);

$i = 1;

while ($i <$repeat){

  // $save;
  //   array_push($resultarray,$save);
 $i.'주후'.$save = $save + $week;
  $i = $i +1;
  // $result = "INSERT INTO Teacher_Schedule (User_Id, Schedule) VALUES ('{$User_ID}', '$save') ";
  // $response = mysqli_query($conn, $result);
  array_push($resultarray,$save);
}


}
echo  "</br>";
echo  "</br>";
echo  "</br>";
json_encode($resultarray);




 foreach($resultarray as $val){

  $val;


  $result = "INSERT INTO Teacher_Schedule (User_Id, Schedule) VALUES ('{$User_ID}', '$val') ";
  $response = mysqli_query($conn, $result);


}

     
 if ($response) { //정상일떄  
  $data = array(
    'plan'            =>   $resultarray,
    'success'        	=>	'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else {//비정상일떄 
  $data = array(
 
    'success'        	=>	'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}
  