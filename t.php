<?php

include("./conn.php");


//Class_List에 수업 목록확인  
$sql = "SELECT * FROM Class_List WHERE User_Id = '32'";
$response1 = mysqli_query($conn, $sql);


$result1['data'] = array();
$result2['timeprice'] = array();


while ($row1 = mysqli_fetch_array($response1)){
  echo $clid= $row1['0'];

  $send['class_id'] = $row1['0'];
  $send['clname'] = $row1['2'];
  $send['cldisc'] = $row1['3'];
  $send['clpeople'] = $row1['4'];
  $send['cltype'] = $row1['5'];
 

//Class_List_Time_Price 수업 시간, 가격 확인   
$sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
$response2 = mysqli_query($conn, $sql);

while ($row2 = mysqli_fetch_array($response2)){

   $tp['Time'] = $row2['2'];
   $tp['Price'] = $row2['3'];; 

 array_push($result2['timeprice'],$tp);

 }
//  echo json_encode($result2);

 $send['tp'] = $result2['timeprice'];

array_push($result1['data'],$send);
$result2['timeprice'] = array();
}

$result1["success"] = "1";
echo json_encode($result1);

mysqli_close($conn);
?>
 