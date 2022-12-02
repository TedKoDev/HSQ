<?php
// == Myinfo 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값 이메일 - token 


# 보낼 줄 때 형태 
// {
//  "token" : "토큰값 "
// }


// #반환되는 데미터 
// ==성공시  (예시)
// {
//   "userid": null,  
//   "name": null,
//   "email": null,
//   "p_img": null,
//   "bday": null,
//   "sex": null,
//   "contact": null,
//   "country": null,
//   "residence": null,
//   "point": null,
//   "timezone": null,
//   "language": null,
//   "korean": null,
//   "teacher": null,
//   "intro": null
// }






include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값 전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"};

error_log(" $token\n", "3", "../php.log");
//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

//ar_dump($payload);


$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);

// 

// DB 정보 가져오기 
$sql = "SELECT User.User_ID, User.U_Name, User.U_Email,  U_D_Img, U_D_Bday, U_D_Sex, U_D_Contact, U_D_Country, U_D_Residence ,U_D_Point, U_D_Timezone, U_D_Language ,U_D_Korean, U_D_T_add , U_D_Intro FROM HANGLE.User left join User_Detail on User.User_ID = User_Detail.User_Id where User.User_ID = '{$User_ID}'";
// {$User_ID}

$result = mysqli_query($conn, $sql);



$row = mysqli_fetch_array($result);


// 값 변수 설정 
 $userid      = $row['User_ID'];
 $name        = $row['U_Name'];
 $email       = $row['U_Email'];
 $p_img       = $row['U_D_Img'];
 $bday        = $row['U_D_Bday'];
 $sex         = $row['U_D_Sex'];
 $contact     = $row['U_D_Contact'];
 $country     = $row['U_D_Country'];
 $residence   = $row['U_D_Residence'];
 $point       = $row['U_D_Point'];
 $timezone    = $row['U_D_Timezone'];
 $language    = $row['U_D_Language'];
 $korean      = $row['U_D_Korean'];
 $teacher     = $row['U_D_T_add'];
 $intro       = $row['U_D_Intro'];




 $send["userid"]   =  $userid   ;
 $send["name"]   =  $name     ;
 $send["email"]   =  $email    ;
 $send["p_img"]   =  $p_img    ;
 $send["bday"]   =  $bday     ;
 $send["sex"]   =  $sex      ;
 $send["contact"]   =  $contact  ;
 $send["country"]   =  $country  ;
 $send["residence"]   =  $residence  ;
 $send["point"]   =  $point    ;
 $send["timezone"]   =  $timezone    ;
 $send["language"]   =  $language ;
 $send["korean"]   =  $korean ;
 $send["teacher"]   =  $teacher  ;
 $send["intro"]   =  $intro  ;



 echo json_encode($send);
 mysqli_close($conn);

?>