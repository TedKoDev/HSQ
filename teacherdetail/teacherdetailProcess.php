<?php

// == User_Detail 작성완료 확인 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰".
//1. "usid"    : "usid".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰". (로그인한 사용자의 USER_ID를 얻어 사용자의 TIMEZONE을 얻음 )
//  "usid"    : "usid".
// }

// 코드 전개 구조
// 1.토큰에서 로그인한 사용자의 USER_ID를 얻어 사용자의 TIMEZONE을 얻음
// 2.선택된 강사의 userid (usid)를 얻어 필요한 값들을 얻어옴 
// 3. 1번에서 얻은 timezone을 2번에서 얻어온 '강사의 수업가능시간'에 적용하여  값을 변화시킴 
// 4. 강사의 수업목록과  수업 목록 내 수업유형은 각각 (class배열 내 (td 배열)) 배열로 구성한다.  


// - 강사 이름                       User.U_Name 
// - 강사 이미지                     User_Detail.U_D_Img
// - 강사 자격 (튜터 or 전문)        User_Teacher.U_T_Special
// - 구사 가능 언어                  User_Detail.U_D_Language
// - 자기 소개                      User_Detail.U_D_Intro
// - 강사 소개          User_Teacher.U_T_Intro 
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
//         "U_T_Special": "default",
//         "U_D_Img": "1669356350PNG",
//         "U_D_Language": "{\"영어\":\"B1\",\"중국어\":\"A1\"}",
//         "U_D_Intro": "안녕하세요~~2222",
//         "U_T_Intro": "소개15",
//         "U_D_Country": "대한민국",
//         "U_D_Residence": "일본",
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
//             },
//             {
//                 "class_id": "39",
//                 "clname": "한국어 수업1",
//                 "cldisc": "수업1입니다",
//                 "clpeople": "1",
//                 "cltype": "회화 연습,발음,철자",
//                 "cllevel": "A1_C1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "25"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "40",
//                 "clname": "한국어 중급",
//                 "cldisc": "중급 수업입니다",
//                 "clpeople": "1",
//                 "cltype": "회화 연습,문법,읽기,듣기",
//                 "cllevel": "A1_C1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "10"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "18"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "153",
//                 "clname": "wew",
//                 "cldisc": "wew",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "A1_C1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "33"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "33"
//                     },
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "24"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "154",
//                 "clname": "테스트ㅇㄴㅇㄴㅇ",
//                 "cldisc": "테스트22",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "A2_B2",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "10"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "20"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "155",
//                 "clname": "44444",
//                 "cldisc": "44444",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "444"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "444"
//                     },
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "13"
//                     },
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "13"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "156",
//                 "clname": "555",
//                 "cldisc": "555",
//                 "clpeople": "1",
//                 "cltype": "문법",
//                 "cllevel": "",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "55"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "55"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "157",
//                 "clname": "131313",
//                 "cldisc": "131313",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "A1_C2",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "13"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "158",
//                 "clname": "55",
//                 "cldisc": "55",
//                 "clpeople": "1",
//                 "cltype": "문법",
//                 "cllevel": "",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "55"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "55"
//                     },
//                     {
//                         "Time": "30",
//                         "Price": "13"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "13"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "159",
//                 "clname": "ㄱㄱ",
//                 "cldisc": "ㄱㄱ",
//                 "clpeople": "1",
//                 "cltype": "발음",
//                 "cllevel": "A1_C1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "111"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "111"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "160",
//                 "clname": "666",
//                 "cldisc": "666",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "A1_C1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "666"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "666"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "161",
//                 "clname": "17177",
//                 "cldisc": "171717",
//                 "clpeople": "1",
//                 "cltype": "철자",
//                 "cllevel": "C1_C2",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "12"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "14"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "162",
//                 "clname": "테스트",
//                 "cldisc": "테스트",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "A1_C2",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "3000"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "6000"
//                     }
//                 ]
//             },
//             {
//                 "class_id": "163",
//                 "clname": "테스트22",
//                 "cldisc": "테스ㅡ22",
//                 "clpeople": "1",
//                 "cltype": "회화 연습",
//                 "cllevel": "A1_B1",
//                 "tp": [
//                     {
//                         "Time": "30",
//                         "Price": "30000"
//                     },
//                     {
//                         "Time": "60",
//                         "Price": "60000"
//                     }
//                 ]
//             }
//         ]
//     }
// ],
// "success": "1"
// }






include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$tusid      =   json_decode(file_get_contents("php://input"))->{"usid"}; // 선택된 강사의 userid 


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);







//현재 로그인한 유저의 U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1);
$timezone = $row1['0'];


//배열생성 
$result3['result'] = array();
$result1['data'] = array();
$result2['timeprice'] = array();



//Class_List에 수업 목록확인  
$sql = "SELECT 
User.U_Name, 
User_Teacher.U_T_Special,  
User_Detail.U_D_Img,
User_Detail.U_D_Language,
User_Detail.U_D_Intro,
User_Teacher.U_T_Intro ,
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
$response1 = mysqli_query($conn, $sql);



$row1 = mysqli_fetch_array($response1);


$send['U_Name'] = $row1['0'];
$send['U_T_Special'] = $row1['1'];
$send['U_D_Img'] = $row1['2'];
$send['U_D_Language'] = $row1['3'];
$send['U_D_Intro'] = $row1['4'];
$send['U_T_Intro'] = $row1['5'];
$send['U_D_Country'] = $row1['6'];
$send['U_D_Residence'] = $row1['7'];

$plan1 = $row1['8'];


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

$send['Schedule'] = $string;




//Class_List에 수업 목록확인  
$sql = "SELECT * FROM Class_List WHERE User_Id = '{$usid}'";
$response1 = mysqli_query($conn, $sql);



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