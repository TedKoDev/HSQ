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
$find_user_id      =   json_decode(file_get_contents("php://input"))->{"find_user_id"}; // 종류
// $find_user_id      =   325; // 종류


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
// $kind = 'teacher_number';
// $kind = 'teacher_list';
// $kind = 'student_number';
// $kind = 'student_list';
// $kind = 'special_teacher_number';
// $kind = 'special_teacher_list';
// $kind = 'community_teacher_number';
// $kind = 'community_teacher_list';
// $kind = 'new_teacher_list';
// $kind = 'user_detail';



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



  //배열생성 
  $result['result'] = array();

  //선생님 목록 
  $sql = "SELECT  
  User_Teacher.teacher_special,
  User_Teacher.user_teacher_date,
  User_Teacher.teacher_accept,
  User.user_id, 
  User.user_email,
  User.user_name,
  User.user_active,
  User.user_register_date,
  User_Detail.user_img,
  User_Detail.user_birthday,
  User_Detail.user_sex,
  User_Detail.user_country,
  User_Detail.teacher_register_check
  FROM User_Teacher LEFT outer join User_Detail ON User_Teacher.user_id = User_Detail.user_id  LEFT outer join User ON User_Detail.user_id = User.user_id where teacher_register_check = 'yes'  order by User.user_id desc LIMIT $start, $till";
  $response1 = mysqli_query($conn, $sql);

  // $key = mysqli_fetch_array($response1);
  // foreach ($response1 as $key) {

  //   array_push($result['result'], $key);
  // }

  while ($row1 = mysqli_fetch_array($response1)) {

    $user_id              = $row1['user_id'];

    $result1['class_number'] = array();

    $Cltp_Sql = "SELECT * FROM Class_Add WHERE user_id_teacher = '$user_id'";
    $response2 = mysqli_query($conn, $Cltp_Sql);

    $row2 = mysqli_num_rows($response2);
    $send['class_number']           = $row2;

    $send['user_id']                = $row1['user_id'];
    $send['user_email']             = $row1['user_email'];
    $send['user_name']              = $row1['user_name'];
    $send['user_active']            = $row1['user_active'];
    $send['user_register_date']     = $row1['user_register_date'];
    $send['user_img']               = $row1['user_img'];
    $send['user_birthday']          = $row1['user_birthday'];
    $send['user_sex']               = $row1['user_sex'];
    $send['user_country']           = $row1['user_country'];
    $send['teacher_register_check'] = $row1['teacher_register_check'];
    $send['teacher_accept']         = $row1['teacher_accept'];
    $send['teacher_special']        = $row1['teacher_special'];
    $send['class_number']           = $row2;
    $send['user_teacher_date']      = $row1['user_teacher_date'];

    array_push($result['result'], $send);
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
} else if ($kind == 'student_number') {
  //학생 수
  //배열생성 
  $result['result'] = array();
  //Class_List에 수업 목록확인  
  $sql = "SELECT  *  FROM User_Detail where teacher_register_check = 'yes' ";
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
} else if ($kind == 'student_list') { //  ?? 필요할까? 
} else if ($kind == 'special_teacher_number') {
  //전문 강사 수
  //배열생성 
  $result['result'] = array();
  //Class_List에 수업 목록확인  
  $sql = "SELECT  *  FROM User_Teacher where teacher_special = 'yes' ";
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
} else if ($kind == 'special_teacher_list') {
  //전문강사 리스트 

  //배열생성 
  $result['result'] = array();

  //Class_List에 수업 목록확인  ;
  $sql = "SELECT  User.user_id, 
  User.user_email,
  User.user_name,
  User_Detail.user_img,
  User_Detail.user_country,
  User_Detail.teacher_register_check,User_Teacher.teacher_special  FROM User LEFT join User_Detail ON User.user_id = User_Detail.user_id LEFT  join User_Teacher ON User_Detail.user_id = User_Teacher.user_id  
  where teacher_special = 'yes'
  order by User.user_id desc LIMIT $start, $till";
  $response1 = mysqli_query($conn, $sql);
  $key = mysqli_fetch_array($response1);






  foreach ($response1 as $key) {
    $user_id              = $key['user_id'];
    $result1['class_number'] = array();
    $Cltp_Sql = "SELECT * FROM Class_Add WHERE user_id_teacher = '$user_id'";
    $response2 = mysqli_query($conn, $Cltp_Sql);
    $row2 = mysqli_num_rows($response2);
    $key['class_number']           = $row2;
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
} else if ($kind == 'community_teacher_number') {
  //커뮤니티 강사 수
  //배열생성 
  $result['result'] = array();
  //Class_List에 수업 목록확인  
  $sql = "SELECT  *  FROM User_Teacher where teacher_special = 'default' ";
  $response1 = mysqli_query($conn, $sql);
  $row1 = mysqli_num_rows($response1);
  array_push($result['result'], $row1);

  if ($response1) {
    $result["success"] = "yes 커뮤니티 강사 수";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["success"]   =  "no";
    echo json_encode($result);
    mysqli_close($conn);
  }
} else if ($kind == 'community_teacher_list') {
  //일반강사 리스트 

  //배열생성 
  $result['result'] = array();

  //Class_List에 수업 목록확인  ;
  $sql = "SELECT  User.user_id, 
  User.user_email,
  User.user_name,
  User_Detail.user_img,
  User_Detail.user_country,
  User_Detail.teacher_register_check,User_Teacher.teacher_special  FROM User LEFT join User_Detail ON User.user_id = User_Detail.user_id LEFT  join User_Teacher ON User_Detail.user_id = User_Teacher.user_id  
  where teacher_special = 'default'
  order by User.user_id desc LIMIT $start, $till";
  $response1 = mysqli_query($conn, $sql);
  $key = mysqli_fetch_array($response1);

  foreach ($response1 as $key) {
    $user_id              = $key['user_id'];
    $result1['class_number'] = array();
    $Cltp_Sql = "SELECT * FROM Class_Add WHERE user_id_teacher = '$user_id'";
    $response2 = mysqli_query($conn, $Cltp_Sql);
    $row2 = mysqli_num_rows($response2);
    $key['class_number']           = $row2;
    array_push($result['result'], $key);
  }

  if ($response1) {
    $result["success"] = "yes 커뮤니티 강사 리스트";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["success"]   =  "no";
    echo json_encode($result);
    mysqli_close($conn);
  }
} else if ($kind == 'new_teacher_list') {
  //신규 신청 강사 리스트 

  //배열생성 
  $result['result'] = array();
  $sql = "SELECT  User.user_id, 
  User.user_email,
  User.user_name,
  User_Detail.user_img,
  User_Detail.user_country,
  User_Detail.teacher_register_check,
  User_Teacher.teacher_special,
  User_Teacher.teacher_accept,  
  User_Teacher.user_teacher_date  
  FROM User 
  LEFT join User_Detail ON User.user_id = User_Detail.user_id 
  LEFT join User_Teacher ON User_Detail.user_id = User_Teacher.user_id  
  where User_Teacher.teacher_accept = 'wait'
  order by User.user_id desc LIMIT $start, $till";
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
} else if ($kind == 'user_detail') {
 //유저 상세 정보 

  //배열생성 
  $result['result'] = array();
  //Class_List에 수업 목록확인  ;
  $sql = "SELECT 
  User.user_id, 
  User.user_email,
  User.user_name,
  User.user_meta_id,
  User.user_meta_nickname,
  User.user_active,
  User.user_register_date,
  User_Detail.user_img,
  User_Detail.user_birthday,
  User_Detail.user_residence,
  User_Detail.user_language,
  User_Detail.user_korean,
  User_Detail.teacher_register_check,
  User_Detail.user_intro,
  User_Detail.user_timezone,
  User_Detail.user_sex,
  User_Detail.user_country,
  User_Detail.teacher_register_check,
  User_Teacher.teacher_special,  
  User_Teacher.teacher_intro,
  User_Teacher.teacher_certification,
  User_Teacher.teacher_file
  FROM User 
  left outer join User_Detail ON User.user_id = User_Detail.user_id 
  left outer join User_Teacher ON User_Detail.user_id = User_Teacher.user_id  
  where User.user_id = $find_user_id
  order by User.user_id desc  LIMIT $start, $till";
  $response1 = mysqli_query($conn, $sql);
  $key = mysqli_fetch_array($response1);

  foreach ($response1 as $key) {
    $user_id              = $key['user_id'];
    $result1['class_number'] = array();
    $Cltp_Sql = "SELECT * FROM Class_Add WHERE user_id_teacher = '$user_id'";
    $response2 = mysqli_query($conn, $Cltp_Sql);
    $row2 = mysqli_num_rows($response2);
    $key['class_number']           = $row2;
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
}
