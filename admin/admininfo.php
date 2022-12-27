<?php

/***
 관리자용 페이지 
총회원수 
총강사수
학생수
신규 신청 강사수 

강사 목록 


신규 신청한 강사 목록 


신규 신청한 강사의 상세 정보 ( )
문의 메세지 



총회원수               total_member_number
총회원리스트           total_member_list
총강사수               teacher_number
총강사리스트           teacher_list
학생수                 student_number
학생수리스트           student_list
   
   
전문강사 수            special_teacher_number
전문강사 리스트        special_teacher_list
   
커뮤니티 강사 수       community_teacher_number
커뮤니티 강사 리스트   community_teacher_list

강사상세 상세 정보         teacher_detail



신규신청강사수         new_teacher_number
신규신청강사수         new_teacher_list
신규강사 상세 정보     new_teacher_detail

    
게시판 내역           대기.    



 */


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 

//강사 상세출력시 필요 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$kind      =   json_decode(file_get_contents("php://input"))->{"kind"}; // 종류


$plus   =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 



//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone



// $kind = 'total_member_number';
// $kind = 'total_member_list';
$kind = 'teacher_number';
// $kind = 'teacher_list';



$i = 0;
$start =  $i + (20 * $plus);
$till = 20;



if ($kind == 'total_member_number') {
  //전체 회원 수  

  //배열생성 
  $result['result'] = array();
  //Class_List에 수업 목록확인  
  $sql = "SELECT  *  FROM User ";
  $response1 = mysqli_query($conn, $sql);
  $row1 = mysqli_num_rows($response1);
  array_push($result['result'], $row1);

  if ($response1) {
    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["success"]   =  "no";
    echo json_encode($result);
    mysqli_close($conn);
  }
} else if ($kind == 'total_member_list') {
  //전체 회원 리스트 

  //배열생성 
  $result['result'] = array();

  //Class_List에 수업 목록확인  ;
  $sql = "SELECT  User.user_id, 
  User.user_email,
  User.user_name,
  User.user_meta_nickname,
  User.user_active,
  User.user_register_date,
  User_Detail.user_img,
  User_Detail.user_birthday,
  User_Detail.user_sex,
  User_Detail.user_country,
  User_Detail.teacher_register_check,User_Teacher.teacher_special  FROM User LEFT join User_Detail ON User.user_id = User_Detail.user_id LEFT  join User_Teacher ON User_Detail.user_id = User_Teacher.user_id  order by User.user_id desc LIMIT $start, $till";
  $response1 = mysqli_query($conn, $sql);
  $key = mysqli_fetch_array($response1);


  foreach ($response1 as $key) {

    array_push($result['result'], $key);
  }

  if ($response1) {
    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["success"]   =  "no";
    echo json_encode($result);
    mysqli_close($conn);
  }
} else if ($kind == 'teacher_number') {
  //선생님 수
  //배열생성 
  $result['result'] = array();
  //Class_List에 수업 목록확인  
  $sql = "SELECT  *  FROM User_Teacher ";
  $response1 = mysqli_query($conn, $sql);
  $row1 = mysqli_num_rows($response1);
  array_push($result['result'], $row1);

  if ($response1) {
    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["success"]   =  "no";
    echo json_encode($result);
    mysqli_close($conn);
  }
} else if ($kind == 'teacher_list') {

  //선생님 목록 
  $sql = "SELECT User_Teacher.*,User_Detail.*,User.*  FROM User  join User_Detail ON User.user_id = User_Detail.user_id join User_Teacher ON User_Detail.user_id = User_Teacher.user_id  order by User.user_id desc ";

  $response1 = mysqli_query($conn, $sql);
  $key = mysqli_fetch_array($response1);


  foreach ($response1 as $key) {

    array_push($result['result'], $key);
  }

  if ($response1) {
    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["success"]   =  "no";
    echo json_encode($result);
    mysqli_close($conn);
  }


} else if ($kind == $student_number) {
} else if ($kind == $student_list) {
} else if ($kind == $special_teacher_number) {
} else if ($kind == $special_teacher_list) {
} else if ($kind == $community_teacher_number) {
} else if ($kind == $community_teacher_list) {
} else if ($kind == $teacher_detail) {
} else if ($kind == $new_teacher_list) {
} else if ($kind == $new_teacher_detail) {
}


















