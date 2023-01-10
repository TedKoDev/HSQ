<?php


// == review 목록 반환 프로세스==
//   #요구되는 파라미터 
//  token 
//  kind (teacher 또는 student 또는 myreview) 
//강사페이지 - 강사유저가 '나의피드백'의 값을 얻으려면     'feedback_teacher'
//강사페이지 - 강사유저가 '학생 후기'에 대한 값을 얻으려면 'review_teacher' 
//학생유저가 자신이 쓴 후기 목록을 얻으려면              'review_student'  
//학생유저가 강사가 학생에게 후기 목록을 얻으려면         'feedback_student'
//  plus     // 더보기 페이징용 5개씩 페이징됨 



//반환되는값 
// teacher인경우 
// {
//   "result": [
//       {
//           "user_id": "320",
//           "user_name": "김학생",
//           "user_img": "P_IMG_320.PNG",
//           "class_register_id": "359",
//           "user_id_student": "320",
//           "user_id_teacher": "324",
//           "class_id": "196",
//           "class_time": "30",
//           "schedule_list": "1673431200000",
//           "teacher_review": "2222уадйиflqb리뷰",
//           "teacher_review_date": "2023-01-09 04:09:11"
//       }
//   ],
//   "success": "yes"
// }

// student인경우
// {
//   "result": [
//       {
//           "user_id": "320",
//           "user_name": "김학생",
//           "user_img": "P_IMG_320.PNG",
//           "class_register_id": "357",
//           "user_id_student": "320",
//           "user_id_teacher": "324",
//           "class_id": "196",
//           "class_time": "30",
//           "schedule_list": "1673332200000",
//           "student_review": "ㅠㄴ",
//           "student_review_star": "10",
//           "student_review_date": "2023-01-09 04:03:13"
//       }
//   ],
//   "success": "yes"

// myreview인경우
// {
//   "result": [
//       {
//           "user_id": "320",
//           "user_name": "김학생",
//           "user_img": "P_IMG_320.PNG",
//           "class_register_id": "357",
//           "user_id_student": "320",
//           "user_id_teacher": "324",
//           "class_id": "196",
//           "class_time": "30",
//           "schedule_list": "1673332200000",
//           "student_review": "ㅠㄴ",
//           "student_review_star": "10",
//           "student_review_date": "2023-01-09 04:03:13"
//       }
//   ],
//   "success": "yes"


include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 
$kind = json_decode(file_get_contents("php://input"))->{"kind"}; //kind

// 더보기 (페이징)처리 용 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 





//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //강사/학생의 userid

$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone




// $User_ID = 320; //강사or 학생의 userid
// $kind = 'teacher'; //kind
// $kind = 'student'; //kind
// $kind = 'myreview'; //kind

$hour = 3600000; // 시간의 밀리초 


// $timezone = '9'; //타임존



$i = 0;
$start =  $i + (5 * $plus);
$till = 5;

if ($kind == 'feedback_teacher') {


  $Sql = "SELECT * FROM Class_Add  join Class_Teacher_Review 
  on Class_Teacher_Review.class_register_id  = Class_Add.class_register_id  where Class_Add.user_id_teacher =  '$User_ID' order by Class_Add.class_register_id DESC LIMIT $start, $till ";
  $SRCList_Result3 = mysqli_query($conn, $Sql);

  $출력값['result'] = array();

  while ($row = mysqli_fetch_array($SRCList_Result3)) {
    $class_id = $row['class_id'];

    //sql 문으로 class_id를 이용해서 class_name을 가져온다.
    $Sql = "SELECT * FROM Class where class_id = '$class_id'";
    $SRCList_Result4 = mysqli_query($conn, $Sql);
    $row2 = mysqli_fetch_array($SRCList_Result4);
    $class_name = $row2['class_name'];



    $user_id_student = $row['user_id_student'];
    //sql 문으로 user_id_student를 이용해서 student_name을 가져온다.
    $Sql = "SELECT User.user_id,User.user_name,User_Detail.user_img FROM User join User_Detail on User.user_id = User_Detail.user_id where User.user_id = '$user_id_student'";
    $SRCList_Result5 = mysqli_query($conn, $Sql);

    $row2 = mysqli_fetch_array($SRCList_Result5);
    $send["user_id"] = $row2['user_id'];
    $send["user_name"] = $row2['user_name'];
    $send["user_img"] = $row2['user_img'];



    $send["class_register_id"] = $row['class_register_id'];
    $send["user_id_student"] = $row['user_id_student'];
    $send["user_id_teacher"] = $row['user_id_teacher'];
    $send["class_id"] = $row['class_id'];
    $send["class_time"] = $row['class_time'];
    $send["schedule_list"] = $row['schedule_list'];
    $send["teacher_review"] = $row['teacher_review'];
    $send["teacher_review_date"] = $row['teacher_review_date'];
    $send["schedule_list"] = $row['schedule_list'];


    array_push($출력값['result'], $send);
  }
  if ($SRCList_Result3) { //정상적으로 파일 저장되었을때 

    $출력값["success"]   =  "yes";
    echo json_encode($출력값);
  } else {

    $출력값["success"]   =  "no";
    $출력값["message"]   =  "sql문에 이상이있음";
    echo json_encode($출력값);
  }
} else if ($kind == 'review_teacher') {



  $Sql = "SELECT * FROM Class_Add  join Class_Student_Review 
  on Class_Student_Review.class_register_id  = Class_Add.class_register_id  where Class_Add.user_id_teacher =  '$User_ID' order by Class_Add.class_register_id DESC LIMIT $start, $till";
  $SRCList_Result3 = mysqli_query($conn, $Sql);

  $출력값['result'] = array();
  while ($row = mysqli_fetch_array($SRCList_Result3)) {
    $class_id = $row['class_id'];

    //sql 문으로 class_id를 이용해서 class_name을 가져온다.
    $Sql = "SELECT * FROM Class where class_id = '$class_id'";
    $SRCList_Result4 = mysqli_query($conn, $Sql);
    $row2 = mysqli_fetch_array($SRCList_Result4);
    $class_name = $row2['class_name'];



    $user_id_student = $row['user_id_student'];
    //sql 문으로 user_id_student를 이용해서 student_name을 가져온다.
    $Sql = "SELECT User.user_id,User.user_name,User_Detail.user_img FROM User join User_Detail on User.user_id = User_Detail.user_id where User.user_id = '$user_id_student'";
    $SRCList_Result5 = mysqli_query($conn, $Sql);

    $row2 = mysqli_fetch_array($SRCList_Result5);
    $send["user_id"] = $row2['user_id'];
    $send["user_name"] = $row2['user_name'];
    $send["user_img"] = $row2['user_img'];



    $send["class_register_id"] = $row['class_register_id'];
    $send["user_id_student"] = $row['user_id_student'];
    $send["user_id_teacher"] = $row['user_id_teacher'];
    $send["class_id"] = $row['class_id'];
    $send["class_time"] = $row['class_time'];
    $send["schedule_list"] = $row['schedule_list'];
    $send["student_review"] = $row['student_review'];
    $send["student_review_star"] = $row['student_review_star'];
    $send["student_review_date"] = $row['student_review_date'];
    $send["schedule_list"] = $row['schedule_list'];


    array_push($출력값['result'], $send);
  }


  if ($SRCList_Result3) { //정상적으로 파일 저장되었을때 



    $출력값["success"]   =  "yes";
    echo json_encode($출력값);
  } else {

    $출력값["success"]   =  "no";
    $출력값["message"]   =  "sql문에 이상이있음";
    echo json_encode($출력값);
  }
} else if ($kind == 'review_student') {

  echo $Sql = "SELECT * FROM Class_Add  join Class_Student_Review 
  on Class_Student_Review.class_register_id  = Class_Add.class_register_id  where Class_Add.user_id_student =  '$User_ID' order by Class_Add.class_register_id DESC LIMIT $start, $till";
  $SRCList_Result3 = mysqli_query($conn, $Sql);

  $출력값['result'] = array();
  while ($row = mysqli_fetch_array($SRCList_Result3)) {
    $class_id = $row['class_id'];

    //sql 문으로 class_id를 이용해서 class_name을 가져온다.
    $Sql = "SELECT * FROM Class where class_id = '$class_id'";
    $SRCList_Result4 = mysqli_query($conn, $Sql);
    $row2 = mysqli_fetch_array($SRCList_Result4);
    $class_name = $row2['class_name'];



    $user_id_student = $row['user_id_student'];
    //sql 문으로 user_id_student를 이용해서 student_name을 가져온다.
    $Sql = "SELECT User.user_id,User.user_name,User_Detail.user_img FROM User join User_Detail on User.user_id = User_Detail.user_id where User.user_id = '$user_id_student'";
    $SRCList_Result5 = mysqli_query($conn, $Sql);

    $row2 = mysqli_fetch_array($SRCList_Result5);
    $send["user_id"] = $row2['user_id'];
    $send["user_name"] = $row2['user_name'];
    $send["user_img"] = $row2['user_img'];



    $send["class_register_id"] = $row['class_register_id'];
    $send["user_id_student"] = $row['user_id_student'];
    $send["user_id_teacher"] = $row['user_id_teacher'];
    $send["class_id"] = $row['class_id'];
    $send["class_time"] = $row['class_time'];
    $send["schedule_list"] = $row['schedule_list'];
    $send["student_review"] = $row['student_review'];
    $send["student_review_star"] = $row['student_review_star'];
    $send["student_review_date"] = $row['student_review_date'];
    $send["schedule_list"] = $row['schedule_list'];


    array_push($출력값['result'], $send);
  }


  if ($SRCList_Result3) { //정상적으로 파일 저장되었을때 



    $출력값["success"]   =  "yes";
    echo json_encode($출력값);
  } else {

    $출력값["success"]   =  "no";
    $출력값["message"]   =  "sql문에 이상이있음";
    echo json_encode($출력값);
  }
} else if ($kind == 'feedback_student') {
}