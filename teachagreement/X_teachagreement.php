<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );
// == 강사등록 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값  - token 
//2. 이름 - givenname
//3. 성 - surname
//3. 확인체크 - check



// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "givenname"     : "이름" 
//  "surname" : "성"
//  "check"     : "yes" 
// }


//반환될때
// {"position":"taeeui:hong:yes",
//  "success":"yes"
// }




include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$givenname = json_decode(file_get_contents("php://input"))->{"givenname"}; //이름
// $givenname = 'taeeui'; //이름
$surname = json_decode(file_get_contents("php://input"))->{"surname"}; //성
// $surname = 'hong'; //성
$check = json_decode(file_get_contents("php://input"))->{"check"}; //체크여부
// $check = 'yes'; //체크여부

$agreement = $givenname.':'.$surname.':'.$check;




date_default_timezone_set('Asia/Seoul');
$time_now = date("Y-m-d H:i:s");

// error_log("$time_now, $position, $desc\n", "3", "../php.log");



//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);

//ar_dump($payload);


$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);




//이름
    $select = "UPDATE User_Teacher SET U_T_Agreement = '$agreement' where User_Id = '$User_ID' ";
    $result1 = mysqli_query($conn, $select);

    
    if ($result1) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "$agreement";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "$agreement";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }