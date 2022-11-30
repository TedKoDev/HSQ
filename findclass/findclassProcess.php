<?php 
// == 수업 찾기 페이지  프로세스==  추후 출력항목 추가될 예정 

//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "plus"    : "더보기 ".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "plus"    : "더보기 1,2,3,4,".
// }

// 코드 전개 구조
// 1. 토큰 수령후 User_Id 값 추출 (사용자)  

// 2. 필요한 정보  (아래 참고사항 확인하기 )

// 3. 정보 모아 프론트로 전달. 

// 수업 id, usd


// {
//   "result": [
//       {
//           "class_id": "163",

//           "clname": "테스트22",
//           "cldisc": "테스ㅡ22",
//           "clpeople": "1",
//           "cltype": "회화 연습",
//           "cllevel": "A1_B1",
//           "name": "163",
//           "special": "163",
//           "tp": [
//               {
//                   "Time": "30",
//                   "Price": "30000"
//               },
//               {
//                   "Time": "60",
//                   "Price": "60000"
//               }
//           ]
//       },
//       {
//           "class_id": "162",

//           "clname": "테스트",
//           "cldisc": "테스트",
//           "clpeople": "1",
//           "cltype": "회화 연습",
//           "cllevel": "A1_C2",
//           "name": "162",
//           "special": "162",
//           "tp": [
//               {
//                   "Time": "30",
//                   "Price": "3000"
//               },
//               {
//                   "Time": "60",
//                   "Price": "6000"
//               }
//           ]
//       }
//   ],
//   "success": "yes"
// }


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"}; // 더보기 

//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


$i= 0 ;

$start =  $i + (20* $plus);
$till = 20;

$result1['result'] = array();
$result2['timeprice'] = array();

    //Class_List와  class_list_Time_Price 와 join 을 통해서 userid가 만든  class list의 class id 값을  class_List_Time_Price와의 fk로 해서 리스트를 얻는다. 
    // 그중 가장 낮은 가격의 값을 얻는다. 

    //Class_List에 수업 목록확인  
    $sql = "SELECT * FROM Class_List order by  Class_Id DESC LIMIT $start, $till";
    $response1 = mysqli_query($conn, $sql);

    while ($row1 = mysqli_fetch_array($response1)) {
      $clid = $row1['0'];
      $usid = $row1['1'];
    
      $send1['class_id'] = $row1['0'];
    
      $send1['clname'] = $row1['2'];
      $send1['cldisc'] = $row1['3'];
      $send1['clpeople'] = $row1['4'];
      $send1['cltype'] = $row1['5'];
      $send1['cllevel'] = $row1['6'];
    
      $sql = "SELECT U_Name FROM User where User_Id = $usid ";
      $response2 = mysqli_query($conn, $sql);
      $send1['name'] = $row1['0'];
    
      
      $sql = "SELECT U_T_Special FROM User_Teacher where User_Id = $usid ";
      $response2 = mysqli_query($conn, $sql);
      $send1['special'] = $row1['0'];
    
    
    
    
      //Class_List_Time_Price 수업 시간, 가격 확인   
      $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
      $response3 = mysqli_query($conn, $sql);
    
      while ($row2 = mysqli_fetch_array($response3)) {
    
        $tp['Time'] = $row2['2'];
        $tp['Price'] = $row2['3'];
    
        array_push($result2['timeprice'], $tp);
      }
      //  echo json_encode($result2);
    
      $send1['tp'] = $result2['timeprice'];
    
      array_push($result1['result'], $send1);
      $result2['timeprice'] = array();
    }

    if ($response2) { //정상적으로 저장되었을때 

      $result1["success"] = "yes";
      echo json_encode($result1);
      mysqli_close($conn);
    } else {
    
      $result1["success"]   =  "no";
      // echo json_encode($result1);
      mysqli_close($conn);
    }

