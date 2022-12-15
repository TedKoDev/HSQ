<?php

// error_reporting(E_ALL);
//     ini_set('display_errors', '1');

include("./conn.php");
include("./jwt.php");


// 필터관련 
// 1. 진행상태  wait, approved , cancel, done    clReserveCheck 의 차이로 결정 
// 2. 학생이름  
// 3. 시작시간 끝 시간 

$User_ID =324;

$clReserveCheck = 'all';


if ($clReserveCheck == 'all') {
  $sqlWhere = 'where Class_Add.user_id_teacher ='.$User_ID;       
} else if ($clReserveCheck != 'all') {
  if ($clReserveCheck == 'wait' ) {
    $clRCValue = '0';
  } else if ($clReserveCheck == 'approved') {
    $clRCValue = '1';
  } else if ($clReserveCheck == 'cancel') {
    $clRCValue = '2';
  } else if ($clReserveCheck == 'done') {
    $clRCValue = '3';
  }
  $sqlWhere = 'where Class_Add.user_id_teacher = '.$User_ID.' and Class_Add.class_register_status = '.$clRCValue;
} 


$user_id_teacher =324;
$User_ID =324;

$clReserveCheck = 'wait';

 $Student_ReserveClassList_Sql = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list  FROM Class_Add  $sqlWhere ";


$SRCList_Result = mysqli_query($conn, $Student_ReserveClassList_Sql);

$result['result'] = array();


while ($row1 = mysqli_fetch_array($SRCList_Result)) {


  $class_time = $row1['class_time']; //수업 30분  60분  시간 
  $schedule_list = $row1['schedule_list']; //수업상태 

  $hour = 3600000; // 시간의 밀리초     
  $save = $schedule_list + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
 


  
  $class_id = $row1['class_id']; //수업id



  $Sql3 = "SELECT Class_List.class_name FROM Class_List where  Class_List.class_id = ' $class_id'";
  $SRCList_Result3 = mysqli_query($conn, $Sql3);

  $row3 = mysqli_fetch_array($SRCList_Result3);

  

  $user_id_student = $row1['user_id_student']; //예약한 학생의 id 
  $Sql4 = "SELECT User_Detail.user_img, User.user_name FROM User_Detail LEFT  OUTER JOIN User ON User_Detail.user_id = User.user_id  where  User_Detail.user_id = '$user_id_student'";
  $SRCList_Result4 = mysqli_query($conn, $Sql4);

  $row4 = mysqli_fetch_array($SRCList_Result4);
 


  $Sql5 = "SELECT Class_List_Time_Price.class_price FROM Class_List_Time_Price where Class_List_Time_Price.class_time =  '$class_time'  and Class_List_Time_Price.class_id = '$class_id'";
  $SRCList_Result5 = mysqli_query($conn, $Sql5);

  $row5 = mysqli_fetch_array($SRCList_Result5);



  $send['class_register_id'] = $row1['class_register_id']; //예약한 수업 id 
  $send['class_id'] = $row1['class_id']; //강의 자체 id
  $send['user_img'] = $row4['user_img']; //사용자 이미지 
  $send['user_name'] = $row4['user_name']; //사용자 이름
  $send['class_name'] = $row3['class_name']; //수업이름
  $send['schedule_list']  = $save; //수업 일정  
  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간 
  $send['class_register_method'] = $row1['class_register_method']; //수업도구
  $send['class_register_status'] = $row1['class_register_status']; //수업상태
  $send['class_price'] = $row5['class_price']; //수업가격


  array_push($result['result'], $send);
 }


if ($rr1) { //정상적으로 저장되었을때 

  $result["success"] = "yes";
  echo json_encode($result);
  mysqli_close($conn);
} else {

  $result["success"]   =  "no";
  echo json_encode($result);
  mysqli_close($conn);
}