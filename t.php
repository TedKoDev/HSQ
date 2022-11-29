

<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "schedule" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 




include("./conn.php");
include("./jwt.php");






$i= 0 ;

$plus = 2;


$start =  $i + (20* $plus);
$till = 20;



//Class_List에 수업 목록확인  
$sql = "SELECT * FROM User_Teacher order by  User_T_Id DESC LIMIT $start, $till ";
$response1 = mysqli_query($conn, $sql);



$result1['data'] = array();
while ($row1 = mysqli_fetch_array($response1)) {
    $usid = $row1['1'];

    $send['User_Id'] = $row1['1'];
    $send['U_T_Intro'] = $row1['2'];
    $send['U_T_Special'] = $row1['4'];


    //User_Detail 에서 이미지, 언어 수업 시간, 가격 확인   
    $sql = "SELECT * FROM User_Detail WHERE User_Id = '$usid'";
    $response2 = mysqli_query($conn, $sql);

    $row2 = mysqli_fetch_array($response2);

    $send['U_D_Img'] = $row2['2'];
    $send['U_D_Language'] = $row2['8'];
    $send['U_D_Intro'] = $row2['12'];

    //User 에서 유저 이름    
    $sql = "SELECT * FROM User WHERE User_ID = '$usid'";
    $response3 = mysqli_query($conn, $sql);

    $row3 = mysqli_fetch_array($response3);

    $send['U_Name'] = $row3['3'];




    //Class_List와  class_list_Time_Price 와 join 을 통해서 userid가 만든  class list의 class id 값을  class_List_Time_Price와의 fk로 해서 리스트를 얻는다. 
    // 그중 가장 낮은 가격의 값을 얻는다. 




    //Class_List에 수업 목록확인  
    $sql = "SELECT * FROM Class_List WHERE User_Id = '{$usid}'";
    $response4 = mysqli_query($conn, $sql);

    $row4 = mysqli_fetch_array($response4);
    $clid = $row4['0'];
    $send['class_id'] = $row4['0'];


    //Class_List_Time_Price 수업 시간, 가격 확인   
    $sql = "SELECT Class_List_Time_Price.CLass_Id, User_Id, Class_List_Time_Price.Time, Class_List_Time_Price.Price FROM HANGLE.Class_List Join Class_List_Time_Price 
On Class_List.CLass_Id = Class_List_Time_Price.CLass_Id where Class_List.User_Id = '{$usid}' order by Class_List_Time_Price.Price asc limit 1";

    // $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
    $response5 = mysqli_query($conn, $sql);

    $row5 = mysqli_fetch_array($response5);
    $send['Time'] = $row5['2'];
    $send['Price'] = $row5['3'];

    if ($send['class_id'] != null) {
        array_push($result1['data'], $send);
    }
}


$result1["success"] = "1";
echo json_encode($result1);

mysqli_close($conn);
