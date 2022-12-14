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
//   "teacher_intro": null
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
// $User_ID =  324;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);

// 

// DB 정보 가져오기 
// $sql = "SELECT User.User_ID, User.U_Name, User.U_Email,  U_D_Img, U_D_Bday, U_D_Sex, U_D_Contact, U_D_Country, U_D_Residence ,U_D_Point, U_D_Timezone, U_D_Language ,U_D_Korean, U_D_T_add , U_D_Intro FROM HANGLE.User left join User_Detail on User.User_ID = User_Detail.User_Id where User.User_ID = '{$User_ID}'";



// sql Payment 테이블에서 user_id로 검색해서 값 가져오기
$sql = "SELECT * FROM HANGLE.Payment_Link where user_id_payment = '{$User_ID}'";

$result = mysqli_query($conn, $sql);




$result1['payment_linkarray'] = array();
//배열생성
foreach ($result as $row) {
  $send1['payment_link'] = $row['payment_link'];

  array_push($result1['payment_linkarray'], $send1);
}





$sql = "SELECT User.user_id, User.user_name, User.user_email,  User_Detail.user_img,  User_Detail.user_birthday,  User_Detail.user_sex,  User_Detail.user_contact,  User_Detail.user_country,  User_Detail.user_residence,  User_Detail.user_point,  User_Detail.user_timezone,  User_Detail.user_language,  User_Detail.user_korean,  User_Detail.teacher_register_check,  User_Detail.user_intro, User_Teacher.teacher_intro FROM HANGLE.User left outer join User_Detail on User.user_id = User_Detail.user_id left outer join User_Teacher on  User_Detail.user_id = User_Teacher.User_id where User.user_id = '{$User_ID}'";


$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);







//평점
$sql = "SELECT AVG(student_review_star) as review_score FROM Class_Student_Review where user_id_teacher = '{$User_ID}'";
$response2 = mysqli_query($conn, $sql);
$row2 = mysqli_fetch_array($response2);





//수업횟수
$sql = "SELECT class_register_status, COUNT(*) AS cnt FROM Class_Add where user_id_teacher = '{$User_ID}' GROUP BY class_register_status;";
$response3 = mysqli_query($conn, $sql);

$result2['class_countArray'] = array();
//배열생성
foreach ($response3 as $row3) {
  $send2['class_register_status'] = $row3['class_register_status'];

  $send2['cnt'] = $row3['cnt'];

  array_push($result2['class_countArray'], $send2);
}



//수업횟수
$sql = "SELECT class_register_status, COUNT(*) AS cnt FROM Class_Add where user_id_student = '{$User_ID}' GROUP BY class_register_status";
$response4 = mysqli_query($conn, $sql);

$result3['class_countArray_as_student'] = array();
//배열생성
foreach ($response4 as $row4) {
  $send3['class_register_status'] = $row4['class_register_status'];

  $send3['cnt'] = $row4['cnt'];

  array_push($result3['class_countArray_as_student'], $send3);
}



//수업횟수
$sql = "SELECT class_register_status, COUNT(*) AS cnt FROM Class_Add where user_id_teacher = '{$User_ID}' GROUP BY class_register_status;";
$response3 = mysqli_query($conn, $sql);

$result2['class_countArray'] = array();
//배열생성
foreach ($response3 as $row3) {
  $send2['class_register_status'] = $row3['class_register_status'];

  $send2['cnt'] = $row3['cnt'];

  array_push($result2['class_countArray'], $send2);
}



//수업횟수
$sql = "SELECT class_register_status, COUNT(*) AS cnt FROM Class_Add where user_id_student = '{$User_ID}' GROUP BY class_register_status";
$response4 = mysqli_query($conn, $sql);

$result3['class_countArray_as_student'] = array();
//배열생성
foreach ($response4 as $row4) {
  $send3['class_register_status'] = $row4['class_register_status'];

  $send3['cnt'] = $row4['cnt'];

  array_push($result3['class_countArray_as_student'], $send3);
}


//수업횟수
$sql = "SELECT class_register_status, COUNT(*) AS cnt FROM Class_Add where user_id_student = '{$User_ID}' GROUP BY class_register_status";
$response4 = mysqli_query($conn, $sql);

$result3['class_countArray_as_student'] = array();
//배열생성
foreach ($response4 as $row4) {
  $send3['class_register_status'] = $row4['class_register_status'];

  $send3['cnt'] = $row4['cnt'];

  array_push($result3['class_countArray_as_student'], $send3);
}



// 값 변수 설정 
$send['user_id']                              = $row['user_id'];
$send['user_name']                             = $row['user_name'];
$send['user_email']                            = $row['user_email'];
$send['user_img']                               = $row['user_img'];
$send['user_birthday']                            = $row['user_birthday'];
$send['user_sex']                               = $row['user_sex'];
$send['user_contact']                              = $row['user_contact'];
$send['user_country']                              = $row['user_country'];
$send['user_residence']                             = $row['user_residence'];
$send['user_point']                              = $row['user_point'];
$send['user_timezone']                              = $row['user_timezone'];
$send['user_language']                              = $row['user_language'];
$send['user_korean']                                  = $row['user_korean'];
$send['teacher_register_check']                    = $row['teacher_register_check'];
$send['user_intro']                    = $row['user_intro'];
$send['teacher_intro']                    = $row['teacher_intro'];

$send['payment_link']                 = $result1['payment_linkarray'];
$send['review_score']    = $row2['review_score'];
$send['class_register_status_count_as_teacher']    = $result2['class_countArray'];
$send['class_register_status_count_as_student']    = $result3['class_countArray_as_student'];






echo json_encode($send);
mysqli_close($conn);
