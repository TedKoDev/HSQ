<?php
// == 강사등록시 최초 화면출력 프로세스==  작업중 
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값  - token 
//2. classid  - classid 

// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "classid"    : "classid".

// }



// #필요한 값 
// - 해당수업 제목        Class_List.CL_Name
// - 해당수업 설명        Class_List.CL_Disc
// - 해당수업 학생수      Class_List.CL_People
// - 해당수업 레벨        Class_List.CL_Level
// - 해당수업 유형 (td)   Class_List.CL_Type
// - 해당수업 가격        Class_List_Time_Price.Time, Class_List_Time_Price.Price

// - 강사 이름                       User.U_Name 
// - 강사 이미지                     User_Detail.U_D_Img
// - 강사 자격 (튜터 or 전문)        User_Teacher.U_T_Special
// - 강사 출신 국가      User_Detail.U_Country
// - 강사 현재 거주 국가 User_Detail.U_Residence

// - 강사의 수업가능시간 (이때 웹페이지 보는 유저의 시간대를 고려해서 보내줘야함) Teacher_Schedule.Schedule

// - 해당 강사의 다른 수업 목록   



// 돌아갈 값 
// {
//   "result": [
//       {
//           "CONNECT_USER_TIMEZONE": "0",  
//           "CLass_Id": "34",
//           "User_Id": "32",
//           "CL_Name": "테스트",
//           "CL_Disc": "테스트입니다",
//           "CL_People": "1",
//           "CL_Type": "회화 연습,문법",
//           "CL_Level": "A1_C1",
//           "tp": [
//               {
//                   "Time": "30",
//                   "Price": "12"
//               },
//               {
//                   "Time": "60",
//                   "Price": "24"
//               }
//           ],
//           "U_Name": "안해인22",
//           "U_T_Special": "default",
//           "U_D_Img": "1669356350PNG",
//           "U_D_Country": "대한민국",
//           "U_D_Residence": "일본",
//           "Schedule": "99_100_145_146_194_196_243",
//           "otherclasslist": [   // 해당 강사의 다른 수업 
//               {
//                   "class_id": "34",
//                   "clname": "테스트",
//                   "cldisc": "테스트입니다",
//                   "clpeople": "1",
//                   "cltype": "회화 연습,문법",
//                   "cllevel": "A1_C1",
//                   "cltp": null
//               },
//           ]
//       }
//   ],
//   "success": "1"
// }


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
// $classid = json_decode(file_get_contents("php://input"))->{"classid"}; // 수업id 



//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
// $User_ID =  base64_decode($payload['User_ID']);
$User_ID = 32;
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);

$classid =  34;

//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($result);
$timezone = $row1['0'];
$send['CONNECT_USER_TIMEZONE'] = $row1['0'];


//배열생성 
$result1['result'] = array();
$result2['timeprice'] = array();


//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT * FROM Class_List WHERE Class_Id = '{$classid}'";
$response1 = mysqli_query($conn, $sql);

$row1 = mysqli_fetch_array($response1);


$clid = $row1['0'];
$usid = $row1['1'];
$send['CLass_Id'] = $row1['0'];
$send['User_Id'] = $row1['1'];
$send['CL_Name'] = $row1['2'];
$send['CL_Disc'] = $row1['3'];
$send['CL_People'] = $row1['4'];
$send['CL_Type'] = $row1['5'];
$send['CL_Level'] = $row1['6'];


//Class_List_Time_Price 수업 시간, 가격 확인   
$sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
$response2 = mysqli_query($conn, $sql);

while ($row2 = mysqli_fetch_array($response2)) {

  $tp['Time'] = $row2['2'];
  $tp['Price'] = $row2['3'];

  array_push($result2['timeprice'], $tp);
}
$send['tp'] = $result2['timeprice'];




//Class_List에 수업 목록확인  
$sql = "SELECT 
User.U_Name, 
User_Teacher.U_T_Special,  
User_Detail.U_D_Img,
User_Detail.U_D_Country,
User_Detail.U_D_Residence,
Teacher_Schedule.Schedule
FROM User
JOIN User_Detail
  ON User.User_ID = User_Detail.User_Id
JOIN User_Teacher
  ON User_Teacher.User_Id = User_Detail.User_Id 
JOIN Teacher_Schedule
  ON Teacher_Schedule.User_Id = User_Detail.User_Id
 where User.User_Id = '$usid' ";
$response3 = mysqli_query($conn, $sql);

$row1 = mysqli_fetch_array($response3);


$send['U_Name'] = $row1['0'];
$send['U_T_Special'] = $row1['1'];
$send['U_D_Img'] = $row1['2'];
$send['U_D_Country'] = $row1['3'];
$send['U_D_Residence'] = $row1['4'];

$plan1 = $row1['5'];


//db에서 가져온 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$planresult = (explode("_", $plan1));
$resultarray = array();

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
$send['Schedule'] = $string;

//강사 다른 수업 관련 배열 

$result1["success"] = "1";

//Class_List에 수업 목록확인  
$sql = "SELECT * FROM Class_List WHERE User_Id = '{$usid}'";
$response1 = mysqli_query($conn, $sql);


//배열생성 
$result3['clist'] = array();
$result4['cltimepirce'] = array();

while ($row1 = mysqli_fetch_array($response1)) {
  $clid = $row1['0'];

  $send1['class_id'] = $row1['0'];
  $send1['clname'] = $row1['2'];
  $send1['cldisc'] = $row1['3'];
  $send1['clpeople'] = $row1['4'];
  $send1['cltype'] = $row1['5'];
  $send1['cllevel'] = $row1['6'];


  //Class_List_Time_Price 수업 시간, 가격 확인   
  $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
  $response2 = mysqli_query($conn, $sql);

  while ($row2 = mysqli_fetch_array($response2)) {

    $tp['Time'] = $row2['2'];
    $tp['Price'] = $row2['3'];

    array_push($result4['cltimeprice'], $tp);
  }
  //  echo json_encode($result2);

  $send1['cltp'] = $result4['cltimeprice'];

  array_push($result3['clist'], $send1);
  $result4['cltimeprice'] = array();
}
$send['otherclasslist'] = $result3["clist"];

array_push($result1['result'], $send);
echo json_encode($result1);
mysqli_close($conn);
