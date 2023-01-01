<?php 

// 접속한 사용자의 Token을 수령한뒤 User_Id를 추출하여 
// 해당 사용자의 Timezone을 전달 해주는 역할을 함. 

include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
// $token      =   11; // 토큰 
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"};  //유저의 로컬 타임존 
// $utc      =   9;  //유저의 로컬 타임존 










if($token != null){

  //토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
// $User_ID =  324;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone
$login ='yes login';
// $timezone      =   8;
  
  }else {
// echo 111;
  $timezone = $utc;
    // $send['CONNECT_USER_TIMEZONE'] = $utc;
    $login ='not login';

    // $User_ID =  324;

  }











 
if ( $timezone) { //정상적으로 값이 나왔을 때  
  $send["login"]   =  "$login";
  $send["user_timezone"]   =  "$timezone";
  $send["user_id"]   =  "$User_ID";
  $send["success"]   =  "yes";
  echo json_encode($send);

} else {
  $send["user_timezone"]   =  "no";
  $send["success"]   =  "no";
  echo json_encode($send);
 
}