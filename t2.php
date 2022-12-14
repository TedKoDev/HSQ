<?php

// error_reporting(E_ALL);
//     ini_set('display_errors', '1');

include("./conn.php");
include("./jwt.php");


//학생 이미지, 학생이름, 수업도구, 수업이름, 수업시간, 진행상태, 가격 

// user_img, user_name, class_method, class_name, schedule_list, class_register_method, class_price


//수업명, 수업 도구 , 수업 진행상태, 수업 시간, 강의 시간, 수강생 기준 시간 +타임존 


$user_id_teacher =324;
$class_register_id =41;

$Sql1 = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list  FROM Class_Add where Class_Add.user_id_teacher = '$user_id_teacher' and Class_Add.class_register_id ='$class_register_id'" ;


  $SRCList_Result1 = mysqli_query($conn, $Sql1);
  $row1 = mysqli_fetch_array($SRCList_Result1);

  $result['result'] = array();

  $send['class_register_id'] = $row1['class_register_id']; //예약한 수업 id 
  $user_id_student = $row1['user_id_student']; //예약한 학생의 id 


  $send['class_register_method'] = $row1['class_register_method']; //수업도구
  $send['class_register_status'] = $row1['class_register_status']; //수업상태
  $send['class_id'] = $row1['class_id']; //강의 자체 id
  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간  

  $send['schedule_list']  = $save; //수업 일정  
  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간 
  $send['class_price'] = $row1['class_price']; //수업가격
  $class_time = $row1['class_time']; //수업 30분  60분  시간  
  $class_id = $row1['class_id']; //수업id




  $schedule_list = $row1['schedule_list']; //수업상태
  $hour = 3600000; // 시간의 밀리초 
  $save = $schedule_list + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
  $send['teacher_schedule_list']  = $save; //수업 일정  
  $send['teacher_user_timezone']  = $timezone; //수업 일정  
 

  $Sql2 = "SELECT User_Detail.user_timezone  FROM User_Detail where  User_Detail.user_id = '$user_id_student'" ;
  $SRCList_Result2 = mysqli_query($conn, $Sql2);
  $row2 = mysqli_fetch_array($SRCList_Result2);
  $send['student_user_timezone'] = $row2['user_timezone']; //학생 타임존
  $student_timezone = $row2['user_timezone']; //학생 타임존

  
  $save = $schedule_list + $student_timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
  $send['student_schedule_list']  = $save; //수업 일정  
 

  

  $Sql3 = "SELECT Class_List_Time_Price.class_price FROM Class_List_Time_Price where Class_List_Time_Price.class_time =  '$class_time'  and Class_List_Time_Price.class_id = '$class_id'";
  $SRCList_Result3 = mysqli_query($conn, $Sql3);

  $row3 = mysqli_fetch_array($SRCList_Result3);

  $send['class_price'] = $row3['class_price']; //수업가격



  $Sql4 = "SELECT Class_List.class_name FROM Class_List where  Class_List.class_id = ' $class_id'";
  $SRCList_Result4 = mysqli_query($conn, $Sql4);

  $row4 = mysqli_fetch_array($SRCList_Result4);

  $send['class_name'] = $row4['class_name']; //수업이름



  
  array_push($result['result'], $send);



if ($SRCList_Result1) { //정상적으로 저장되었을때 

  $result["success"] = "yes";
  echo json_encode($result);
  mysqli_close($conn);
} else {

  $result["success"]   =  "no";
  echo json_encode($result1);
  mysqli_close($conn);
}