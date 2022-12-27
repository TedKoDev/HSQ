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
// $sql = "SELECT User.User_ID, User.U_Name, User.U_Email,  U_D_Img, U_D_Bday, U_D_Sex, U_D_Contact, U_D_Country, U_D_Residence ,U_D_Point, U_D_Timezone, U_D_Language ,U_D_Korean, U_D_T_add , U_D_Intro FROM HANGLE.User left join User_Detail on User.User_ID = User_Detail.User_Id where User.User_ID = '{$User_ID}'";

$sql = "SELECT User.user_id, User.user_name, User.user_email,  User_Detail.user_img,  User_Detail.user_birthday,  User_Detail.user_sex,  User_Detail.user_contact,  User_Detail.user_country,  User_Detail.user_residence,  User_Detail.user_point,  User_Detail.user_timezone,  User_Detail.user_language,  User_Detail.user_korean,  User_Detail.teacher_register_check,  User_Detail.user_intro FROM HANGLE.User left join User_Detail on User.user_id = User_Detail.user_id where User.user_id = '{$User_ID}'";


$result = mysqli_query($conn, $sql);



$row = mysqli_fetch_array($result);


// 값 변수 설정 
 $send['user_id']                    = $row['user_id'];
 $send['user_name']                    = $row['user_name'];
 $send['user_email']                    = $row['user_email'];
 $send['user_img']                    = $row['user_img'];
 $send['user_birthday']                    = $row['user_birthday'];
 $send['user_sex']                    = $row['user_sex'];
 $send['user_contact']                    = $row['user_contact'];
 $send['user_country']                    = $row['user_country'];
 $send['user_residence']                    = $row['user_residence'];
 $send['user_point']                    = $row['user_point'];
 $send['user_timezone']                    = $row['user_timezone'];
 $send['user_language']                    = $row['user_language'];
 $send['user_korean']                    = $row['user_korean'];
 $send['teacher_register_check']                    = $row['teacher_register_check'];
 $send['user_intro']                    = $row['user_intro'];




//  $send["userid"]             =  $userid   ;
//  $send["name"]                 =  $name     ;
//  $send["email"]                   =  $email    ;
//  $send["p_img"]             =  $p_img    ;
//  $send["bday"]                 =  $bday     ;
//  $send["sex"]               =  $sex      ;
//  $send["contact"]            =  $contact  ;
//  $send["country"]        =  $country  ;
//  $send["residence"]                    =  $residence  ;
//  $send["point"]                    =                 $point    ;
//  $send["timezone"]                    =  $timezone    ;
//  $send["language"]                  =  $language ;
//  $send["korean"]                 =  $korean ;
//  $send["teacher"]                  =  $teacher  ;
//  $send["intro"]             =  $intro  ;



 echo json_encode($send);
 mysqli_close($conn);

?>