<?php

/***
학생정보 RestAPI
studentinfo.php




분기 조건 
1. user_id_student가 있다/없다. 
$susid = 324;

1-1.plus가 있다/없다. (페이징 처리 유무)  20개씩 


출력정보  

 */



include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 

$susid      =   json_decode(file_get_contents("php://input"))->{"user_id_student"}; // 선택된 강사의 userid 


$plus          =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);

// $susid  = 320;
// $User_ID = 324;
// $plus          = 1;

$i = 0;
$start =  $i + (20 * $plus);
$till = 20;


// 강사상세 출력인지 목록 출력인지 
if ($susid == null) {
  //susid 가 없으면 작동 전체 목록 




  //본인의 수업을 수강 완료한 학생 리스트 출력

  //학생이 강사의 수업을 수강한 횟수 

  //학생이 수강한 수업 중 가장 최근에 수강한 수업의 시간 (한개일 경우 그거 하나만, 2개 이상일 경우 그 중 가장 최신 시간)


  //   // Output a list of students who have completed their classes
  //   $sql = "SELECT DISTINCT Class_Add.user_id_student, User.user_name, User_Detail.user_img  
  //   FROM Class_Add left outer join User on User.user_id = Class_Add.user_id_student left outer join User_Detail on User.user_id = User_Detail.user_id = '{$User_ID}'  and class_register_status = 3 ";



  // //Number of times the student took the instructor's class
  // $sql = "SELECT COUNT(*) FROM Class_Add WHERE user_id_student = '{$susid}' and user_id_teacher = '{$User_ID}' and class_register_status = 3";


  // //Time of the most recent class taken by the student
  // $sql = "SELECT class_register_date FROM Class_Add WHERE user_id_student = '{$susid}' and user_id_teacher = '{$User_ID}' and class_register_status = 3 ORDER BY class_register_date DESC LIMIT 1";




  $result['result'] = array();

  //Class_List에 수업 목록확인  
  // $plus 유무에 따른 분기 
  if ($plus == null) {
    //plus가 없으면 페이징 없음 
    $sql = "SELECT SQL_CALC_FOUND_ROWS
  Class_Add_1.user_id_student, 
  User.user_name, 
  User_Detail.user_img, 
  (SELECT COUNT(*) FROM Class_Add WHERE user_id_student = Class_Add_1.user_id_student AND user_id_teacher = '{$User_ID}' AND class_register_status = 3) as class_count, 
  (SELECT schedule_list FROM Class_Add WHERE user_id_student = Class_Add_1.user_id_student AND user_id_teacher = '{$User_ID}' AND class_register_status = 3 ORDER BY schedule_list DESC LIMIT 1) as last_class_date
FROM 
  (SELECT DISTINCT Class_Add.user_id_student FROM Class_Add WHERE class_register_status = 3) Class_Add_1
  LEFT JOIN User ON User.user_id = Class_Add_1.user_id_student 
  LEFT JOIN User_Detail ON User.user_id = User_Detail.user_id 
order by  last_class_date DESC ";
  } else {
    // plus가 있으면 페이징  
    $sql = "SELECT SQL_CALC_FOUND_ROWS
    Class_Add_1.user_id_student, 
    User.user_name, 
    User_Detail.user_img, 
    (SELECT COUNT(*) FROM Class_Add WHERE user_id_student = Class_Add_1.user_id_student AND user_id_teacher = '{$User_ID}' AND class_register_status = 3) as class_count, 
    (SELECT schedule_list FROM Class_Add WHERE user_id_student = Class_Add_1.user_id_student AND user_id_teacher = '{$User_ID}' AND class_register_status = 3 ORDER BY schedule_list DESC LIMIT 1) as last_class_date
  FROM 
    (SELECT DISTINCT Class_Add.user_id_student FROM Class_Add WHERE class_register_status = 3) Class_Add_1
    LEFT JOIN User ON User.user_id = Class_Add_1.user_id_student 
    LEFT JOIN User_Detail ON User.user_id = User_Detail.user_id 
  order by  last_class_date DESC LIMIT $start, $till ";
  }
  $response1 = mysqli_query($conn, $sql);


  //전체 갯수
  $sql1 = " SELECT FOUND_ROWS() as result_count ";
  $response2 = mysqli_query($conn, $sql1);
  $row = mysqli_fetch_array($response2);
  // $result["result_count"] = $row['result_count'];
  $result["page"] = $plus;



  while ($r = mysqli_fetch_array($response1)) {

    $send['user_id_student'] = $r['user_id_student'];
    $send['user_name'] = $r['user_name'];
    $send['user_img'] = $r['user_img'];
    $send['class_count'] = $r['class_count'];
    $send['last_class_date'] = $r['last_class_date'];



    array_push($result['result'], $send);
  }

  //성공유무 분기 
  if ($response1) {
    $result["length"] = $row['result_count'];
    $result["page"] = $plus;
    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["length"] = $row['result_count'];
    $result["page"] = $plus;
    $result["success"] = "no";
    $result["message"] = "error로 값을 불러오지 못하였음";
    echo json_encode($result);
    mysqli_close($conn);
  }
} else if ($susid != null) {
  //susid는 학생의 user_id 이고 있으면 학생 상세 정보 
  //$User_ID는 강사의 user_id

  //학생이 수강 완료한 수업 리스트 출력 (최근 수업일수록 먼저 정렬되도록) 

  //학생이 수강 완료한 수업 리스트 출력
  $result['result'] = array();

  //Class_List에 수업 목록확인  

  // $plus 유무에 따른 분기 
  if ($plus == null) {
    //plus가 없으면 페이징 없음 

    // 수업시간, 수업id, 수업 스케쥴 출력
    $sql = "SELECT SQL_CALC_FOUND_ROWS
  class_time,
  Class_Add.class_id,
  Class_List.class_name,
  schedule_list, 
  Class_Teacher_Review.teacher_review,
  Class_Teacher_Review.teacher_review_date,
  Class_Student_Review.student_review,
  Class_Student_Review.student_review_star,
  Class_Student_Review.student_review_date
FROM 
  Class_Add
left outer  JOIN Class_List ON Class_Add.class_id = Class_List.class_id
 left outer   JOIN Class_Teacher_Review ON Class_Add.class_register_id = Class_Teacher_Review.class_register_id 
  left outer  JOIN Class_Student_Review ON Class_Add.class_register_id = Class_Student_Review.class_register_id
WHERE 
  Class_Add.user_id_student = '{$susid}' 
  AND Class_Add.user_id_teacher = '{$User_ID}' 
  AND Class_Add.class_register_status = 3 
ORDER BY schedule_list DESC ";
  } else if ($plus != null) {
    $sql = "SELECT SQL_CALC_FOUND_ROWS
    class_time,
    Class_Add.class_id,
    Class_List.class_name,
    schedule_list, 
    Class_Teacher_Review.teacher_review,
    Class_Teacher_Review.teacher_review_date,
    Class_Student_Review.student_review,
    Class_Student_Review.student_review_star,
    Class_Student_Review.student_review_date
  FROM 
    Class_Add
  left outer  JOIN Class_List ON Class_Add.class_id = Class_List.class_id
   left outer   JOIN Class_Teacher_Review ON Class_Add.class_register_id = Class_Teacher_Review.class_register_id 
    left outer  JOIN Class_Student_Review ON Class_Add.class_register_id = Class_Student_Review.class_register_id
  WHERE 
    Class_Add.user_id_student = '{$susid}' 
    AND Class_Add.user_id_teacher = '{$User_ID}' 
    AND Class_Add.class_register_status = 3 
  ORDER BY schedule_list  DESC LIMIT $start, $till ";
  }



  $response1 = mysqli_query($conn, $sql);







  //전체 갯수
  $sql1 = " SELECT FOUND_ROWS() as result_count ";
  $response2 = mysqli_query($conn, $sql1);
  $row = mysqli_fetch_array($response2);

  $result["page"] = $plus;

  while ($r = mysqli_fetch_array($response1)) {

    $send['class_time'] = $r['class_time'];
    $send['class_id'] = $r['class_id'];
    $send['class_name'] = $r['class_name'];
    $send['schedule_list'] = $r['schedule_list'];
    $send['teacher_review'] = $r['teacher_review'];
    $send['teacher_review_date'] = $r['teacher_review_date'];
    $send['student_review'] = $r['student_review'];
    $send['student_review_star'] = $r['student_review_star'];
    $send['student_review_date'] = $r['student_review_date'];




    array_push($result['result'], $send);
  }

  //성공유무 분기 
  if ($response1) {
    $result["length"] = $row['result_count'];
    $result["page"] = $plus;
    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {
    $result["length"] = $row['result_count'];
    $result["page"] = $plus;
    $result["success"] = "no";
    $result["message"] = "error로 값을 불러오지 못하였음";
    echo json_encode($result);
    mysqli_close($conn);
  }
}