
<?php




include("./conn.php");
include("./jwt.php");


 //tusid 가 없으면 작동 전체 목록 


 $i= 0 ;




 $start =  $i + (20* $plus);
 $till = 20;
 

 
 //Class_List에 수업 목록확인  
 $sql = "SELECT * FROM User_Teacher order by  User_T_Id DESC LIMIT $start, $till ";
 $response1 = mysqli_query($conn, $sql);
 
 
 $result1['data'] = array();
 while ($row1 = mysqli_fetch_array($response1)) {
     $tusid = $row1['1'];
     $tusid = 32;
     $send['User_Id'] = $row1['1'];
     $send['U_T_Intro'] = $row1['2'];
     $send['U_T_Special'] = $row1['4'];
 
 
     //User_Detail 에서 이미지, 언어 수업 시간, 가격 확인   
     $sql = "SELECT * FROM User_Detail WHERE User_Id = '$tusid'";
     $response2 = mysqli_query($conn, $sql);
 
     $row2 = mysqli_fetch_array($response2);
 
     $send['U_D_Img'] = $row2['2'];
     $send['U_D_Language'] = $row2['8'];
     $send['U_D_Intro'] = $row2['12'];
 
     //User 에서 유저 이름    
     $sql = "SELECT * FROM User WHERE User_ID = '$tusid'";
     $response3 = mysqli_query($conn, $sql);
 
     $row3 = mysqli_fetch_array($response3);
 
     $send['U_Name'] = $row3['3'];
 
 
 

 
     // Class_List에 수업 목록확인   강사의 수업이 있는지 확인하는 절차 없으면 넣지않으려함 .
     $sql = "SELECT * FROM Class_List WHERE User_Id_t = '{$tusid}'";
     $response4 = mysqli_query($conn, $sql);
 
     $row4 = mysqli_fetch_array($response4);
     $clid = $row4['0'];
     $send['class_id'] = $row4['0'];
 
 
     //Class_List_Time_Price 수업 시간, 가격 확인   
     $sql = "SELECT Class_List_Time_Price.CLass_Id, Class_List_Time_Price.Time, Class_List_Time_Price.Price FROM HANGLE.Class_List Join Class_List_Time_Price 
 On Class_List.CLass_Id = Class_List_Time_Price.CLass_Id where Class_List.User_Id_t = '{$tusid}' order by Class_List_Time_Price.Price asc limit 1";

     $response5 = mysqli_query($conn, $sql);
 
     $row5 = mysqli_fetch_array($response5);
     $send['Time'] = $row5['1'];
     $send['Price'] = $row5['2'];
 
     if ($send['class_id'] != null) { // 수업이 없는 것은 넣지 않는다. 
         array_push($result1['data'], $send);
     }
 }
 
 
 $result1["success"] = "1";
 echo json_encode($result1);
 
 mysqli_close($conn);
 