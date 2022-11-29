<?php   
//  error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );


// error_log("$error", "3", "/data/logs/php.log");

include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값 전달 받음 
// file_get_contents("php://input") ;
$token = json_decode(file_get_contents("php://input"))->{'token'};
// $token = 'eyJhbGciOiJzaGEyNTYiLCJ0eXAiOiJKV1QifS57IlVzZXJfSUQiOiJNemc9IiwiVV9OYW1lIjoiYUdGbGFXNDIiLCJVX0VtYWlsIjoiWVdodWFHRmxhVzQyUUc1aGRtVnlMbU52YlE9PSJ9LjYwZjZiMmE0NDUzOTlhZjg2MzNmOWEyZmZkZGJkNGQ3OTQzNGEzMWNhYWNmNzNlNmE0NDhmMWYxYjZhMGEwZjk=';


//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

// var_dump($payload);


 $User_ID =  base64_decode($payload['User_ID']);


 $U_Name  = base64_decode($payload['U_Name']);

 $U_Email = base64_decode($payload['U_Email']);






// DB 정보 가져오기 
$sql = "SELECT User.User_ID, U_Name, U_D_Img, U_D_T_add FROM HANGLE.User left join User_Detail on User.User_ID = User_Detail.User_Id where User.User_ID = '{$User_ID}'";
$result = mysqli_query($conn, $sql);



$row = mysqli_fetch_array($result);


// 값 변수 설정 
 $userid = $row['User_ID'];
 $name = $row['U_Name'];
 $p_img = $row['U_D_Img'];
 $teacher = $row['U_D_T_add'];


 $send["p_img"] = $p_img ;
 $send["name"] = $name;
 $send["teacher"] =  $teacher;

 echo json_encode($send);
 mysqli_close($conn);




?>