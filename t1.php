<?php


include("./conn.php");
include("./jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
// 토큰 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; 
// $plan      =   json_decode(file_get_contents("php://input"))->{"plan"};  // 일정 
$plan      =  '2000_4000';


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
// $User_ID =  base64_decode($payload['User_ID']);
$User_ID =  32;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);






$hour = 3600;










//U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1); 
$timezone = $row1['0'].'</br>';




  
$check = "SELECT * FROM Teacher_Schedule where User_Id = '{$User_ID}'";
$checkresult = mysqli_query($conn, $check);


// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$result = (explode("_", $plan));


$resultarray= array();
foreach($result as $val){

 $val;

 $save = $val - $timezone* $hour;

array_push($resultarray,$save);


}

json_encode($resultarray);



    //  $result = "DELETE FROM Teacher_Schedule   WHERE User_Id = '32' ";
     $result = "DELETE FROM Teacher_Schedule   WHERE User_Id = '{$User_ID}' ";
     $response = mysqli_query($conn, $result);

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


// //U_D_Timeze 값을 가져옴   
// $sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
// $response1 = mysqli_query($conn, $sql);
// $row1 = mysqli_fetch_array($response1); 
// echo $timezone = $row1['0'].'</br>';



// $sql = "SELECT Schedule FROM Teacher_Schedule WHERE User_Id = '{$User_ID}'";
// $response2 = mysqli_query($conn, $sql);

// $result2['Schedule'] = array();



// // 1시간 = 3600;
// $hour = 3600;

// $resultarray = array();

// while ($row1 = mysqli_fetch_array($response2)) {

//  $schedule = $row1['0'];


//   $schedule2 = $schedule - $hour*$timezone;



//   array_push($resultarray, $schedule2);
//   // array_push($resultarray,$save);
// }
// // $string = implode("_",$resultarray);
  

//  $string = implode("_",$resultarray);
  
     
//  if ($response1) { //정상일떄  
//   $data = array(
//     'schedule'	=>	$string,
//     'success'        	=>	'yes'
//   );
//   echo json_encode($data);
//   mysqli_close($conn);
// } else {//비정상일떄 
//   $data = array(
//     'schedule'	=>	'no',
//     'success'        	=>	'no'
//   );
//   echo json_encode($data);
//   mysqli_close($conn);
// }
  
 