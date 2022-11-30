<?php


include("./conn.php");
include("./jwt.php");







$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$plus      =   json_decode(file_get_contents("php://input"))->{"plus"}; // 토큰 


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = 32;
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
      // $send1['user_id'] = $row1['1'];
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
    // $result1["success"] = "1";

    


    if ($response2) { //정상적으로 저장되었을때 

      $result1["success"] = "yes";
      echo json_encode($result1);
      mysqli_close($conn);
    } else {
    
      $result1["success"]   =  "no";
      // echo json_encode($result1);
      mysqli_close($conn);
    }

    