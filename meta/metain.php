<?php

// == 수업등록 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 



//업데이트 할때 
//1. "token"    : "토큰값"
//2. "kind"    : "GET"
//3. "user_meta_nickname"   : "닉네임"
//4. "user_meta_id"     : " 1 ~ 16" 


// 최초 메타버스 진입할때 닉네임 선택 및 캐릭터 이름 선정 
//1. "token"    : "토큰값".
//2. "kind"    : "POST".
//3. "user_meta_nickname"   : "닉네임".
//4. "user_meta_id"     : " 1 ~ 16" 


//업데이트 할때 
//1. "token"    : "토큰값".
//2. "kind"    : "UPDATE".
//3. "user_meta_nickname"   : "닉네임".
//4. "user_meta_id"     : " 1 ~ 16" 




include("../conn.php");
include("../jwt.php");


//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
$data = file_get_contents("php://input") . "<br/>";


// $token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
// $kind      =   json_decode(file_get_contents("php://input"))->{"kind"}; // 용도 
// $user_meta_nickname     =   json_decode(file_get_contents("php://input"))->{"user_meta_nickname"}; //닉네임
// $user_meta_id            =   json_decode(file_get_contents("php://input"))->{"user_meta_id"};  //캐릭터 종류 
$token                  =   $data["token"]; // 토큰 



//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$User_ID =  332;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);



 if ($method == 'POST') {

  $nickMetaIdandCharacter = "SELECT User.user_meta_nickname, User_Meta.* FROM User JOIN User_Meta On User.user_meta_id = User_Meta.user_meta_id where user_id = '$User_ID'";
  $response = mysqli_query($conn, $nickMetaIdandCharacter);


  $row = mysqli_fetch_array($response);

  $send['user_meta_nickname'] = $row['user_meta_nickname'];
  $send['user_meta_id'] = $row['user_meta_id'];
  $send['user_meta_width'] = $row['user_meta_width'];
  $send['user_meta_height'] = $row['user_meta_height'];
  $send['user_meta_character_full'] = $row['user_meta_character_full'];
  $send['user_meta_character_thumnail'] = $row['user_meta_character_thumnail'];



  $result1['result'] = array();

  array_push($result1['result'], $send);

  //
  if ($response) {
    // 
    $result1["success"] = "yes";
    $result1["message"] = "캐릭정보 전달성공";
    echo json_encode($result1);  
    mysqli_close($conn);
  } else {
    $result1["success"] = "no";
    $result1["message"] = "캐릭정보 전달실패";
    // echo json_encode($result1);  
    mysqli_close($conn);
  }




}
