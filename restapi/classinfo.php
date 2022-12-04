<?php

/***

수강정보  RestAPI
classinfo.php

분기 조건 
1. class id가 있다/없다.
2. 항목 별 값이 있다/없다. 

출력정보  


1. 수업상세  (수업명, 수업내용, 수업유형, 수업 레벨, 수업 가격)

2. 수업목록  (수업명, 및 기타 정보 + 수업오픈한 강사의 정보(이름,이미지 )   + plus 가 있는경우 페이징 동작함)
{"clname"};   // 수업이름 
{"cldisc"};   // 수업설명 
{"clpeople"}; // 수업인원 
{"cltype"};   // 수업유형 
{"cllevel"};  // 수업레벨 
{"cltime"};   // 수업시간
{"clprice"};  // 수업가격
{"timg"};     // 강사이미지
{"tname"};    // 강사이름
{"plus"};     // 더보기 


 
 */

//// 2. (선생)tuser_id가 있다/없다.

include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


$classid       =   json_decode(file_get_contents("php://input"))->{"classid"}; // 수업번호 
// $tuserid       =   json_decode(file_get_contents("php://input"))->{"tuserid"}; // 강사의 User_id 


$clname        =   json_decode(file_get_contents("php://input"))->{"clname"};   // 수업이름 
$cldisc        =   json_decode(file_get_contents("php://input"))->{"cldisc"};   // 수업설명 
$clpeople      =   json_decode(file_get_contents("php://input"))->{"clpeople"}; // 수업인원 
$cltype        =   json_decode(file_get_contents("php://input"))->{"cltype"};   // 수업유형 
$cllevel       =   json_decode(file_get_contents("php://input"))->{"cllevel"};  // 수업레벨 
$cltimeprice   =   json_decode(file_get_contents("php://input"))->{"cltime"};   // 수업시간
$clprice       =   json_decode(file_get_contents("php://input"))->{"clprice"};  // 수업가격
$timg          =   json_decode(file_get_contents("php://input"))->{"timg"};     // 강사이미지
$tname         =   json_decode(file_get_contents("php://input"))->{"tname"};    // 강사이름
 
 
$plus          =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 






// 수업상세 출력인지 목록 출력인지 
if ($classid != null) {
  //해당 classid에 해당하는 상세정보를 가져옴 
  //classid 가 있으면 작동

  $result1['result'] = array();
  $result2['timeprice'] = array();


  //수업 상세 정보 
  $sql = "SELECT * FROM Class_List WHERE Class_Id = '{$classid}'";
  $response1 = mysqli_query($conn, $sql);

  $row1 = mysqli_fetch_array($response1);


  $clid = $row1['0'];
  $tusid = $row1['1'];

  $send['CLass_Id'] = $row1['0'];

  $send['User_Id'] = $row1['1'];
  if ($clname != null) {
    $send['CL_Name'] = $row1['2'];
  }
  if ($cldisc != null) {
    $send['CL_Disc'] = $row1['3'];
  }
  if ($clpeople != null) {
    $send['CL_People'] = $row1['4'];
  }
  if ($cltype != null) {
    $send['CL_Type'] = $row1['5'];
  }
  if ($cllevel != null) {
    $send['CL_Level'] = $row1['6'];
  }




  //Class_List_Time_Price 수업 시간, 가격 확인   
  $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
  
  if ($cltime != null) {
    $response2 = mysqli_query($conn, $sql);

  while ($row2 = mysqli_fetch_array($response2)) {  
      $tp['Time'] = $row2['2'];
    }
  }
    

  if ($clprice != null) {
    $response2 = mysqli_query($conn, $sql);
  while ($row2 = mysqli_fetch_array($response2)) {

    $tp['Price'] = $row2['3'];
  }
}

    array_push($result2['timeprice'], $tp);

  $send['tp'] = $result2['timeprice'];



  array_push($result1['result'], $send);
  echo json_encode($result1);
  mysqli_close($conn);



} else {
  //classid 가 없으면 작동 전체 목록 



  $i = 0;

  $start =  $i + (20 * $plus);
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



      //해당 Class를 개설한 강사의 이미지와 이름(User_Detail TB)    
      $sql = "SELECT 
      User.U_Name, 
      User_Teacher.U_T_Special,  
      User_Detail.U_D_Img

      FROM User
      JOIN User_Detail
        ON User.User_ID = User_Detail.User_Id
      JOIN User_Teacher
        ON User_Teacher.User_Id = User_Detail.User_Id 
      where User.User_Id = '$usid' ";
      $response2 = mysqli_query($conn, $sql);
      $row2 = mysqli_fetch_array($response2);
      $send1['U_Name'] = $row2['0'];
      $send1['U_T_Special'] = $row2['1'];
      $send1['U_D_Img'] = $row2['2'];

    


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
}
