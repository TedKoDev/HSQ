<?php 

// 접속한 사용자의 Token을 수령한뒤 User_Id를 추출하여 
// 해당 사용자의 Timezone을 전달 해주는 역할을 함. 

include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT user_timezone FROM User_Detail WHERE user_id = '{$User_ID}'";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($result);
$timezone = $row1['0'];



 
if ($result) { //정상적으로 값이 나왔을 때  
  $send["user_timezone"]   =  "$timezone";
  $send["success"]   =  "yes";
  echo json_encode($send);

} else {
  $send["user_timezone"]   =  "no";
  $send["success"]   =  "no";
  echo json_encode($send);
 
}