<?php

// == User_Detail 작성완료 확인 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰".
//1. "user_id"    : "user_id".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰". (로그인한 사용자의 user_id를 얻어 사용자의 TIMEZONE을 얻음 )
//  "user_id"    : "user_id".
// }

// 코드 전개 구조
// 1.토큰에서 로그인한 사용자의 user_id를 얻어 사용자의 TIMEZONE을 얻음
// 2.선택된 강사의 userid (user_id)를 얻어 필요한 값들을 얻어옴 
// 3. 1번에서 얻은 timezone을 2번에서 얻어온 '강사의 수업가능시간'에 적용하여  값을 변화시킴 
// 4. 강사의 수업목록과  수업 목록 내 수업유형은 각각 (class배열 내 (td 배열)) 배열로 구성한다.  


// - 강사 이름                       User.U_Name 
// - 강사 이미지                     User_Detail.user_img
// - 강사 자격 (튜터 or 전문)        User_Teacher.teacher_special
// - 구사 가능 언어                  User_Detail.user_language
// - 자기 소개                      User_Detail.user_intro
// - 강사 소개          User_Teacher.teacher_intro 
// - 강사 출신 국가      User_Detail.U_Country
// - 강사 현재 거주 국가 User_Detail.U_Residence

// - 강사의 수업가능시간 (이때 웹페이지 보는 유저의 시간대를 고려해서 보내줘야함) Teacher_Schedule.Schedule


// - 수업 목록   (class)       Class_List.
//   - 수업 제목        Class_List.CL_Name
//   - 수업 설명        Class_List.CL_Disc
//   - 수업 가격        Class_List_Time_Price.Time, Class_List_Time_Price.Price
//   - 수업 레벨        Class_List.CL_Level
//   - 수업 유형 (td)       Class_List.CL_Type

// 



//{
//   "result": [
//     {
//         "U_Name": "안해인22",
//         "teacher_special": "default",
//         "user_img": "1669356350PNG",
//         "user_language": "{\"영어\":\"B1\",\"중국어\":\"A1\"}",
//         "user_intro": "안녕하세요~~2222",
//         "teacher_intro": "소개15",
//         "user_country": "대한민국",
//         "user_residence": "일본",
//         "Schedule": "-17_-16_82_83_127_128_129_130_131", <----- 타임존 적용되어 변경된값  
//         "class": [
//             {
//                 "class_id": "34",
//                 "clname": "테스트",
//                 "cldisc": "테스트입니다",
//                 "clpeople": "1",
//                 "cltype": "회화 연습,문법",
//                 "cllevel": "A1_C1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "24"
//                     }
//                 ]
//             }
// ],
// "success": "1"
// }






include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$tuser_id      =   json_decode(file_get_contents("php://input"))->{"user_id"}; // 선택된 강사의 userid 

$user_timezone      =   json_decode(file_get_contents("php://input"))->{"user_timezone"}; // user_timezone 


error_log("'111','token:',$token , 'user_id:',$tuser_id , 'user_timezone:',$user_timezone  \n", "3", "../php.log");


error_log("'111'  \n", "3", "/php.log");
//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);

// $user_id      =   324; // 선택된 강사의 userid 
//배열생성 
$result3['result'] = array();
$result1['data'] = array();
$result2['timeprice'] = array();


if($token != null){

//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE user_id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1);


$timezone = $row1['0'];
$send['CONNECT_USER_TIMEZONE'] = $row1['0'];


}else {

  $timezone = $user_timezone;
  $send['CONNECT_USER_TIMEZONE'] = $user_timezone;

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
 where User.user_id = '$tuser_id' ";
$response1 = mysqli_query($conn, $sql);



$row1 = mysqli_fetch_array($response1);


$send['user_name'] = $row1['0'];
$send['teacher_special'] = $row1['1'];
$send['user_img'] = $row1['2'];
$send['user_language'] = $row1['3'];
$send['user_intro'] = $row1['4'];
$send['teacher_intro'] = $row1['5'];
$send['user_country'] = $row1['6'];
$send['user_residence'] = $row1['7'];


$sql = "SELECT 
schedule_list,teacher_schedule_status
FROM Teacher_Schedule
 where user_id_teacher = '$user_id' ";
$response2 = mysqli_query($conn, $sql);



$row1 = mysqli_fetch_array($response2);
$plan1 = $row1['0'];


//db에서 가져온 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$planresult = (explode("_", $plan1));

// echo $planresult;



$resultarray = array();
//

foreach ($planresult as $val) {

  $val . "</br>";

  $save = $val - $timezone * 2;

  // echo $save;
  if ($save > 336) {

    $save = $save - 336;
  }


  array_push($resultarray, $save);
}


$string = implode("_", $resultarray);



$send['schedule_list'] = $string;

$send['schedule_status'] = $row1['1'];




//Class_List에 수업 목록확인  
$sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$tuser_id}'";
$response3 = mysqli_query($conn, $sql);



while ($row3 = mysqli_fetch_array($response3)) {
  $clid = $row3['0'];

  $send1['class_id'] = $row3['0'];
  $send1['class_name'] = $row3['2'];
  $send1['class_description'] = $row3['3'];
  $send1['class_people'] = $row3['4'];
  $send1['class_type'] = $row3['5'];
  $send1['class_level'] = $row3['6'];


  //Class_List_Time_Price 수업 시간, 가격 확인   
  $sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";
  $response2 = mysqli_query($conn, $sql);

  while ($row2 = mysqli_fetch_array($response2)) {

    $tp['class_time'] = $row2['2'];
    $tp['class_price'] = $row2['3'];

    array_push($result2['timeprice'], $tp);
  }
  //  echo json_encode($result2);

  $send1['tp'] = $result2['timeprice'];

  array_push($result1['data'], $send1);
  $result2['timeprice'] = array();
}
$send['class'] = $result1['data'];
array_push($result3['result'], $send);
// $result1["success"] = "1";
$result3["success"] = "1";
echo json_encode($result3);


mysqli_close($conn);