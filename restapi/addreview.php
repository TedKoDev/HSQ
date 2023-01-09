<?php


// == add_review 프로세스==
//   #요구되는 파라미터 
//  token 
//  kind (teacher 또는 student) 작성자가 선생님인지 학생인지  확인하는 파라미터
//  class_register_id  (수업등록번호)
//  teacher_review  (선생님일 경우 - 학생에 대해 작성한 리뷰)
//  student_review (학생일경우     -  선생님에 대해 작성한 리뷰)
//  student_review_star  (학생일 경우 - 선생님에 대해 작성한 별점)



include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 

//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //강사/학생의 userid

$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone


$kind = json_decode(file_get_contents("php://input"))->{"kind"}; //kind
$class_register_id = json_decode(file_get_contents("php://input"))->{"class_register_id"}; //class_register_id
$teacher_review = json_decode(file_get_contents("php://input"))->{"teacher_review"}; //teacher_review 선생리뷰 
$student_review = json_decode(file_get_contents("php://input"))->{"student_review"}; //student_review 학생 리뷰 
$student_review_star = json_decode(file_get_contents("php://input"))->{"student_review_star"}; //student_review_star 별점 

// $User_ID = 324; //강사or 학생의 userid
// $kind = 'teacher'; //kind
// // $kind = 'student'; //kind
// $teacher_review = '선생님텍스트리뷰12'; //teacher_review 텍스트 
// $student_review = '학생텍스트리뷰1222'; //teacher_review 텍스트 
// $class_register_id = 358; //class_register_id
// $student_review_star = '1';

$hour = 3600000; // 시간의 밀리초 


// $timezone = '9'; //타임존




$Sql3 = "SELECT Class_Add.user_id_teacher, Class_Add.user_id_student, Class_Add.schedule_list FROM Class_Add where Class_Add.class_register_id =  '$class_register_id'";
$SRCList_Result3 = mysqli_query($conn, $Sql3);

$row3 = mysqli_fetch_array($SRCList_Result3);

$send['user_id_teacher'] = $row3['user_id_teacher']; //강사의 유저 번호  
$user_id_teacher = $row3['user_id_teacher']; //강사의 유저 번호  


$send['user_id_student'] = $row3['user_id_student']; //학생의 유저 번호  
$user_id_student = $row3['user_id_student']; //학생의 유저 번호  

$send['schedule_list'] = $row3['schedule_list']; //수업일정
$schedule_list = $row3['schedule_list']; //수업일정





if ($kind == 'teacher') {

  $class_register_review = '1';


  $select = "UPDATE Teacher_Schedule INNER JOIN Class_Add ON Teacher_Schedule.user_id_teacher = Class_Add.user_id_teacher SET 
  Class_Add.class_register_review = '$class_register_review' 
  where Class_Add.class_register_id = '$class_register_id' and Class_Add.user_id_teacher = '$user_id_teacher' and Class_Add.schedule_list = '$schedule_list' and Teacher_Schedule.schedule_list = '$schedule_list' and Teacher_Schedule.user_id_teacher = '$user_id_teacher'";
  $response = mysqli_query($conn, $select);




  if ($response) { //정상적으로 파일 저장되었을때 



    if ($timezone >= 0) {
      $plus_minus = '-' . $timezone;
    } else {

      $plus_minus = '-1' * $timezone;
      $plus_minus = '+' . $plus_minus;
    }

    $timezone2 =  $plus_minus; //수업이 신청된 시간에 timezone을 적용하여 출력함. 

    $tz = $timezone2;
    // echo '타임존' . $tz = "-9";

    $time = time(); //현재 시간을 가져옴

    $teacher_review_date = date("Y-m-d H:i:s ", $time);
    // echo  $timezone적용 = strtotime($tz);
    // $timezone적용 =  strtotime(" $teacher_review_date  $tz ");
    $timezone적용 =  strtotime(" $teacher_review_date  ");

    $teacher_review_date2 = date("Y-m-d H:i:s ", $timezone적용);
    // echo  $student_review_date3 = date("Y-m-d H:i:s ", $timezone적용2);






    $select1 = "INSERT INTO Class_Teacher_Review (class_register_id,user_id_teacher, user_id_student , teacher_review, teacher_review_date) VALUES ('$class_register_id','$user_id_teacher','$user_id_student','$teacher_review' ,'$teacher_review_date') ";
    $response1 = mysqli_query($conn, $select1);
    mysqli_close($conn);

    if ($response1) { //정상적으로 파일 저장되었을때 

      $send["class_register_id"]   =  'Class_Teacher_Review 값 insert 성공 ';
      $send["teacher_review"]   =  $teacher_review;
      $send["teacher_review_date"]   =  $teacher_review_date2;
      $send["success"]   =  "yes";
      echo json_encode($send);
    } else {
      $send["class_register_id"]   =  'Class_Teacher_Review 값 insert 실패';
      $send["teacher_review"]   =  $teacher_review;
      $send["success"]   =  "no";
      echo json_encode($send);
    }
  } else {
    $send["class_register_id"]   =  'Teacher_Schedule 업뎃 실패';
    $send["teacher_review"]   =  $teacher_review;
    $send["success"]   =  "no";
    echo json_encode($send);
  }
} else if ($kind == 'student') {

  $class_register_review = '1';

  $select = "UPDATE Teacher_Schedule INNER JOIN Class_Add ON Teacher_Schedule.user_id_teacher = Class_Add.user_id_teacher SET 
  Class_Add.class_register_review_student = '$class_register_review' 
  where Class_Add.class_register_id = '$class_register_id' and Class_Add.user_id_teacher = '$user_id_teacher' and Class_Add.schedule_list = '$schedule_list' and Teacher_Schedule.schedule_list = '$schedule_list' and Teacher_Schedule.user_id_teacher = '$user_id_teacher'";
  $response = mysqli_query($conn, $select);




  if ($response) { //정상적으로 파일 저장되었을때 



    // $timezone = '9'; //타임존

    if ($timezone >= 0) {
      $plus_minus = '-' . $timezone;
    } else {

      $plus_minus = '-1' * $timezone;
      $plus_minus = '+' . $plus_minus;
    }

    $timezone2 =  $plus_minus; //수업이 신청된 시간에 timezone을 적용하여 출력함. 

    $tz = $timezone2;
    // echo '타임존' . $tz = "-9";

    $time = time(); //현재 시간을 가져옴

    $student_review_date = date("Y-m-d H:i:s ", $time);
    // echo  $timezone적용 = strtotime($tz);
    // $timezone적용 =  strtotime(" $student_review_date  $tz ");
    $timezone적용 =  strtotime(" $student_review_date  ");

    $student_review_date2 = date("Y-m-d H:i:s ", $timezone적용);
    // echo  $student_review_date3 = date("Y-m-d H:i:s ", $timezone적용2);

    $select1 = "INSERT INTO Class_Student_Review (class_register_id, user_id_teacher, user_id_student , student_review, student_review_star, student_review_date) VALUES ('$class_register_id','$user_id_teacher','$user_id_student', '$student_review','$student_review_star', '$student_review_date' )";
    $response1 = mysqli_query($conn, $select1);
    mysqli_close($conn);





    if ($response1) { //정상적으로 파일 저장되었을때 

      $send["class_register_id"]   =  'Class_Teacher_Review 값 insert 성공 ';
      $send["student_review"]   =  $student_review;
      $send["student_review_star"]   =  $student_review_star;


      $send["student_review_date"]   =  $student_review_date2;
      $send["success"]   =  "yes";
      echo json_encode($send);
    } else {
      $send["class_register_id"]   =  'Class_Teacher_Review 값 insert 실패';
      $send["student_review"]   =  $student_review;
      $send["student_review_star"]   =  $student_review_star;
      $send["success"]   =  "no";
      echo json_encode($send);
    }



    // $send["class_register_id"]   = '';
    // $send["teacher_review"]   =  $teacher_review;
    // $send["success"]   =  "yes";
    // echo json_encode($send);

  } else {
    $send["class_register_id"]   =  'Student_Schedule 업뎃완료';
    $send["teacher_review"]   =  $teacher_review;
    $send["success"]   =  "no";
    echo json_encode($send);
  }
}