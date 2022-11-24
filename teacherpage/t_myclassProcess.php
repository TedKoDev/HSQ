<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 

// {"data":[{"class_id":"4","clname":"korean 1","cldisc":"koreanclass","clpeople":"1","cltype":"speaking"},{"class_id":"5","clname":"korean 2 ","cldisc":"koreanclass","clpeople":"1","cltype":"writing"}]}


// 각 key 값   62번쨰줄 이하 참고 while ($row = mysqli_fetch_array($response)){
// 'class_id'
// 'clname'
// 'cldisc' 
// 'clpeople'
// 'cltype' 



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




// Class_List에서 정보 가져오기 
$sql = "SELECT * FROM Class_List WHERE User_Id = '{$User_ID}'";
$response = mysqli_query($conn, $sql);



$result['data'] = array();
while ($row = mysqli_fetch_array($response)){
  $send['class_id'] = $row['0'];
  $send['clname'] = $row['2'];
  $send['cldisc'] = $row['4'];
  $send['clpeople'] = $row['5'];
  $send['cltype'] = $row['6'];

array_push($result['data'],$send);
}


echo json_encode($result);
mysqli_close($conn);