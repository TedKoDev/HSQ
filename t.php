<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "schedule" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 




include("./conn.php");



// UTC -12,-11,-10,-9,-8,-7,-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14
// $plan = '1_2_3_4_5_6_7_8';


$plan = "333_334_335_336";
// print_r(explode("_", $plan));
$result = (explode("_", $plan));

// echo $result;
  
$result1 = array();
//
$timezone = '2';
foreach($result as $val){

  $val."</br>";

  $save = $val + $timezone*2;
   $save;

  if($save > 336) {

    $save = $save - 336; 
  }


  
  array_push($result1,$save);

}


// echo json_encode($result1);
// echo '</br>';
// echo $plan;
// echo '</br>';


echo $string = implode("_",$result1);


// U_D에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM Teacher_Schedule where User_Id = '18'";
$checkresult = mysqli_query($conn, $check);

// error_log("$time_now,'ddd', $User_ID, $U_Name, $U_Email \n", "3", "/php.log");



// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows <1) {
    // date_default_timezone_set('Asia/Seoul');
    // $time_now = date("Y-m-d H:i:s");
    // // error_log("$time_now,'???', $User_ID, $U_Name, $U_Email \n", "3", "../php.log");
    // error_log("$time_now, 's'\n", "3", "../php.log");
    
    // 중복값이 없을때 때 실행할 내용
    // 없으면 insert로  data 만들고  
    // 아래의 update로 data 삽입 
    $result = "INSERT INTO Teacher_Schedule (User_Id, Schedule) VALUES ('18', ' $string') ";
    $insert = mysqli_query($conn, $result);
    //   $send["message"] = "no";
    //   $send["message"] = "no";

    // echo json_encode($send);
    // mysqli_close($conn);
}else {
  
// $result = "INSERT INTO User_Detail (User_Id) VALUES ('$User_ID') ";
// $insert = mysqli_query($conn, $result);



$select = "UPDATE Teacher_Schedule SET Schedule = '$string' where User_Id = '18' ";

$insert = mysqli_query($conn, $select);

}