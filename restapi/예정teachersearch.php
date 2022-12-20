<?php

/***
강사정보  RestAPI
teacherinfo.php
분기 조건 
1. teacher userid가 있다/없다.
2. 항목 별 값이 있다/없다. 
출력정보  
1. 강사상세  (강사명, 강사이미지, 강사 자기소개, 자기소개, 강사국가, 강사 거주지, 강사 전문성, 강사언어)
{"timg"};     // 강사이미지
{"tname"};    // 강사이름
{"tintro"};    // 강사자기소개
{"intro"};    // 자기소개
{"tcountry"};    // 강사국가
{"tresidence"};    // 강사거주지
{"tspecial"};    // 강사전문성
{"tlanguage"};    // 강사언어 
2. 강사목록  (강사명, 및 기타 정보  + plus 가 있는경우 페이징 동작함)
수업이 있는 강사만 출력함.
 
 */



include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$tusid      =   json_decode(file_get_contents("php://input"))->{"user_id_teacher"}; // 선택된 강사의 userid 
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"}; // utc 


$timg           =   json_decode(file_get_contents("php://input"))->{"teacher_img"};     // 강사이미지
$tname          =   json_decode(file_get_contents("php://input"))->{"teacher_name"};    // 강사이름
$tintro         =   json_decode(file_get_contents("php://input"))->{"teacher_intro"};    // 강사자기소개
$intro          =   json_decode(file_get_contents("php://input"))->{"user_intro"};    // 자기소개
$tcountry       =   json_decode(file_get_contents("php://input"))->{"teacher_country"};    // 강사국가
$tresidence     =   json_decode(file_get_contents("php://input"))->{"teacher_residence"};    // 강사거주지
$tspecial       =   json_decode(file_get_contents("php://input"))->{"teacher_special"};    // 강사전문성
$tlanguage      =   json_decode(file_get_contents("php://input"))->{"teacher_language"};    // 강사언어 


$plus          =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 




// 강사상세 출력인지 목록 출력인지 
if ($tusid != null) {
  //해당 tusid에 해당하는 상세정보를 가져옴 
  //tusid 가 있으면 작동


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


//배열생성 
$result3['result'] = array();
$result1['data'] = array();
$result2['timeprice'] = array();


if($token != null){

//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT user_timezone FROM User_Detail WHERE user_id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1);


$timezone = $row1['0'];
$send['CONNECT_USER_TIMEZONE'] = $row1['0'];


}else {

  $timezone = $utc;
  $send['CONNECT_USER_TIMEZONE'] = $utc;

}


//Class_List에 수업 목록확인  
$sql = "SELECT 
User.user_name, 
User_Teacher.teacher_special,  
User_Detail.user_img,
User_Detail.user_language,
User_Detail.user_intro,
User_Teacher.teacher_intro ,
User_Detail.user_country,
User_Detail.user_residence
FROM User
JOIN User_Detail
  ON User.user_id = User_Detail.user_id
JOIN User_Teacher
  ON User_Teacher.user_id = User_Detail.user_id 
 where User.user_id = '$tusid' ";
$response1 = mysqli_query($conn, $sql);



$row1 = mysqli_fetch_array($response1);

$send['user_name'] = $row1['0'];

if ($tspecial != null) {
$send['teacher_special'] = $row1['1'];}

if ($timg != null) {
$send['user_img'] = $row1['2'];}

if ($tlanguage != null) {
$send['user_language'] = $row1['3'];}

if ($intro != null) {
$send['user_intro'] = $row1['4'];}

if ($tintro != null) {
$send['teacher_intro'] = $row1['5'];}

if ($tcountry != null) {
$send['user_country'] = $row1['6'];}

if ($tresidence != null) {
$send['user_residence'] = $row1['7'];
}



array_push($result3['result'], $send);
// $result1["success"] = "1";
$result3["success"] = "1";
echo json_encode($result3);




mysqli_close($conn);






} else {
  //tusid 가 없으면 작동 전체 목록 


  $i= 0 ;




  $start =  $i + (20* $plus);
  $till = 20;
  
  
  
  //Class_List에 수업 목록확인  
  $sql = "SELECT * FROM User_Teacher order by  user_teacher_id DESC LIMIT $start, $till ";
  $response1 = mysqli_query($conn, $sql);
  
  
  $result1['data'] = array();
  while ($row1 = mysqli_fetch_array($response1)) {
      $tusid = $row1['1'];
  
      $send['user_id'] = $row1['1'];
      $send['teacher_intro'] = $row1['2'];
      $send['teacher_special'] = $row1['4'];
  
  
      //User_Detail 에서 이미지, 언어 수업 시간, 가격 확인   
      $sql = "SELECT * FROM User_Detail WHERE user_id = '$tusid'";
      $response2 = mysqli_query($conn, $sql);
  
      $row2 = mysqli_fetch_array($response2);
  
      $send['user_img'] = $row2['2'];
      $send['user_language'] = $row2['8'];
      $send['user_intro'] = $row2['12'];
  
      //User 에서 유저 이름    
      $sql = "SELECT * FROM User WHERE user_id = '$tusid'";
      $response3 = mysqli_query($conn, $sql);
  
      $row3 = mysqli_fetch_array($response3);
  
      $send['user_name'] = $row3['3'];
  
  
  

  
      // Class_List에 수업 목록확인   강사의 수업이 있는지 확인하는 절차 없으면 넣지않으려함 .
      $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$tusid}'";
      $response4 = mysqli_query($conn, $sql);
  
      $row4 = mysqli_fetch_array($response4);
      $clid = $row4['0'];
      $send['class_id'] = $row4['0'];
  
  
      //Class_List_Time_Price 수업 시간, 가격 확인   
      $sql = "SELECT Class_List_Time_Price.class_id, Class_List_Time_Price.class_time, Class_List_Time_Price.class_price FROM HANGLE.Class_List Join Class_List_Time_Price 
  On Class_List.class_id = Class_List_Time_Price.class_id where Class_List.user_id_teacher = '{$tusid}' order by Class_List_Time_Price.class_price asc limit 1";

      $response5 = mysqli_query($conn, $sql);
  
      $row5 = mysqli_fetch_array($response5);
      $send['class_time'] = $row5['1'];
      $send['class_price'] = $row5['2'];
  
      if ($send['class_id'] != null) { // 수업이 없는 것은 넣지 않는다. 
          array_push($result1['data'], $send);
      }
  }
  
  
  $result1["success"] = "1";
  echo json_encode($result1);
  
  mysqli_close($conn);
  
  
}