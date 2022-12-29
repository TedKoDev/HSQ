<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');
// == 수업등록 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 



//업데이트 할때 
//1. "token"    : "토큰값"
//2. "kind"    : "GET"
//3. "user_meta_nickname"   : "닉네임"
//4. "getcharacterㅎ"     : " 1 ~ 16" 


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




// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "kind"    : ""GET/POST/UPDATE".
//  "class_description"   : "수업소개".
//  "class_timeprice"     :  "[{"class_time":"30","class_price":"10"},{"class_time":"40","class_price":"20"},{"class_time":"50","class_price":"30"}]" 

//  "class_people"   : "수업인원" 
//  "class_type"     : "수업유형" 
//  "class_level"     : "수업수준" 

// }

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



$token                 =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$user_meta_nickname    =   json_decode(file_get_contents("php://input"))->{"user_meta_nickname"}; //닉네임
$user_meta_id          =   json_decode(file_get_contents("php://input"))->{"user_meta_id"};  //캐릭터 종류 


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);

// $method = 'POST';
// $User_ID = 324;
// $user_meta_nickname    =   'nicktest'; //닉네임
// $user_meta_id          =  '1' ;  //캐릭터 종류 

if ($method == 'GET') {


   $user_meta_nickname = isset($_GET['user_meta_nickname']) ? $_GET['user_meta_nickname'] : die();

  $nickVertifyCheck = "SELECT * FROM User where user_meta_nickname = '$user_meta_nickname'";
  $checkresult = mysqli_query($conn, $nickVertifyCheck);
  //중복 값이 있는지 없는지 확인한다
  if ($checkresult->num_rows > 0) {
    // 중복값이 있을 때 실행할 내용
    $send["success"] = "no ";
    $send["message"] = "nickname 중복됨 사용불가";
    echo json_encode($send);
    mysqli_close($conn);
  } else {
    $send["success"] = "yes";
    $send["message"] = "nickname 사용가능";
    echo json_encode($send);
    mysqli_close($conn);
  }


} else if ($method == 'POST') {


    $add_nickname_sql = "UPDATE User SET user_meta_id = '$user_meta_id', user_meta_nickname = '$user_meta_nickname' where user_id = '$User_ID' ";
    $result = mysqli_query($conn, $add_nickname_sql);

    if ($result) { //정상적으로 저장되었을때 

      $send["success"]              = "yes";
      $send["message"]              =  "최초 닉네임 입력 및 캐릭터 선정 완료";
      $send["user_meta_id"]         =  $user_meta_id;
      $send["user_meta_nickname"]   =  $user_meta_nickname;
      echo json_encode($send);
      mysqli_close($conn);
    } else {
      $send["success"] = "no";
      $send["message"]   =  "최초 닉네임 입력 및 캐릭터 선정 실패";
      echo json_encode($send);
      mysqli_close($conn);
    }
    

} else if ($method == 'PUT') {

    $add_nickname_sql = "UPDATE User SET user_meta_id = '$user_meta_id', user_meta_nickname = '$user_meta_nickname' where user_id = '$User_ID' ";
    $result = mysqli_query($conn, $add_nickname_sql);

    if ($result) { //정상적으로 저장되었을때 
      $send["success"]              = "yes";
      $send["message"]              =  "캐릭터 및 닉네임 변경 완료";
      $send["user_meta_id"]         =  $user_meta_id;
      $send["user_meta_nickname"]   =  $user_meta_nickname;
      echo json_encode($send);
      mysqli_close($conn);
    } else {
      $send["success"] = "no";
      $send["message"]   =  "캐릭터 및 닉네임 변경 실패";
      echo json_encode($send);
      mysqli_close($conn);
    }

}
