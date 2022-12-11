<?php


include("./conn.php");


$classid       =   32; // 수업번호 

$tusid       =  32; // 강사의 User_id 



$clname        =   1;   // 수업이름 
$cldisc        =   1;   // 수업설명 
$clpeople      =   1; // 수업인원 
$cltype        =   1;   // 수업유형 
$cllevel       =   1;  // 수업레벨 

$cltime        =   1;  // 수업가격
$clprice       =   1;  // 수업가격
$timg          =   1;     // 강사이미지
echo $tname    =   1;    // 강사이름



// 더보기 (페이징)처리 용 
$plus  =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 

 


$result1['data'] = array();
$result3['result'] = array();

$result2['timeprice'] = array();



$list = array();
array_push($list, 'CLass_Id');
if ($clname != null) {
  array_push($list, 'CL_Name');
}
if ($cldisc != null) {
  array_push($list, 'CL_Disc');
}
if ($clpeople != null) {
  array_push($list, 'CL_People');
}
if ($cltype != null) {
  array_push($list, 'CL_Type');
}
if ($cllevel != null) {
  array_push($list, 'CL_Level');
}

 $string = implode(",", $list);


  //Class_List에 수업 목록확인  
  $sql = "SELECT  $string FROM Class_List WHERE User_Id = '{$tusid}'";
  $response1 = mysqli_query($conn, $sql);

  foreach ($response1 as $key) {
    

    // echo key($key); // 키
    // echo current($key); // 값
    $clid = current($key); // 값
   
      array_push($result1['data'], $key);


 


    if ($clprice != null) {
    //Class_List_Time_Price 수업 시간, 가격 확인   
    $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
    $response2 = mysqli_query($conn, $sql);

    while ($row2 = mysqli_fetch_array($response2)) {
   
      $tp= $row2['3'];

      array_push($result2['timeprice'], $tp);
    }
    

    $send1['tp'] = $result2['timeprice'];
  }



    array_push($result1['data'], $send1);
    $result2['timeprice'] = array();
  }
  $send['class'] = $result1['data'];
  array_push($result3['result'], $send);
  $result3["success"] = "1";
  echo json_encode($result3);


  mysqli_close($conn);

