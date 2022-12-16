<?php



include("./conn.php");
include("./jwt.php");


$Student_ReserveClassList_Sql = "SELECT * FROM HANGLE.Class_Add ";

// $Student_ReserveClassList_Sql = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list , convert_tz( Class_Add.class_register_date ,'+00:00','+10:00') FROM Class_Add where Class_Add.user_id_teacher =324 ;";


$SRCList_Result = mysqli_query($conn, $Student_ReserveClassList_Sql);
$row = mysqli_fetch_array($response1);

echo $total = $row['total']; // 전체글수
 ;

// $timezone = '-1'; //사용자(학생)의 TimeZone

// if($timezone>=0){
//   $plus_minus = '+';
// }else{
//   $plus_minus = '';
// }


// $timezone2 =  $plus_minus.$timezone.':00'; //사용자(학생)의 TimeZ
// // $timezone2 =  $plus_minus.$timezone.':00'; //사용자(학생)의 TimeZ

// echo $timezone ; 
// echo $timezone2 ; 