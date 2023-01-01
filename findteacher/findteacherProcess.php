<?php 
// == 강사 찾기 페이지  프로세스==  추후 출력항목 추가될 예정 
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
//  (강사의 User_Id, U_D_Img, U_Name, U_T_Special, U_D_Language, U_T_Intro, U_D_Intro, Price(Class_List, Class_List_Time_Price 정리)

// 3. 정보 모아 프론트로 전달. 


// {"User_Id":"32","U_T_Intro":"\uc18c\uac1c15","U_T_Special":"USER_1669268662.zip","U_D_Img":"1669356350PNG","U_D_Language":"{\"\uc601\uc5b4\":\"B1\",\"\uc911\uad6d\uc5b4\":\"A1\"}","U_Name":"\uc548\ud574\uc77822","class_id":"34","Time":"30","Price":"10"},



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



//Class_List에 수업 목록확인  
$sql = "SELECT * FROM User_Teacher order by  user_teacher_id DESC LIMIT $start, $till ";
$response1 = mysqli_query($conn, $sql);


$result1['data'] = array();
while ($row1 = mysqli_fetch_array($response1)) {
    $usid = $row1['user_id'];

    $send['user_id'] = $row1['user_id'];
    $send['teacher_intro'] = $row1['teacher_intro'];
    $send['teacher_special'] = $row1['teacher_special'];


    //User_Detail 에서 이미지, 언어 수업 시간, 가격 확인   
    $sql = "SELECT * FROM User_Detail WHERE user_id = '$usid'";
    $response2 = mysqli_query($conn, $sql);

    $row2 = mysqli_fetch_array($response2);

    $send['user_img'] = $row2['user_img'];
    $send['user_language'] = $row2['user_language'];
    $send['user_intro'] = $row2['user_intro'];

    //User 에서 유저 이름    
    $sql = "SELECT * FROM User WHERE user_id = '$usid'";
    $response3 = mysqli_query($conn, $sql);

    $row3 = mysqli_fetch_array($response3);

    $send['user_name'] = $row3['user_name'];




    //Class_List와  class_list_Time_Price 와 join 을 통해서 userid가 만든  class list의 class id 값을  class_List_Time_Price와의 fk로 해서 리스트를 얻는다. 
    // 그중 가장 낮은 가격의 값을 얻는다. 




    //Class_List에 수업 목록확인  
    $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$usid}'";
    $response4 = mysqli_query($conn, $sql);

    $row4 = mysqli_fetch_array($response4);
    $clid = $row4['class_id'];
    $send['class_id'] = $row4['class_id'];


    //Class_List_Time_Price 수업 시간, 가격 확인   

    $sql = "SELECT Class_List_Time_Price.class_id, Class_List_Time_Price.class_time, Class_List_Time_Price.class_price FROM HANGLE.Class_List Join Class_List_Time_Price 
On Class_List.class_id = Class_List_Time_Price.class_id where Class_List.user_id_teacher = '{$usid}' order by Class_List_Time_Price.class_price asc limit 1";

    // $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
    $response5 = mysqli_query($conn, $sql);

    $row5 = mysqli_fetch_array($response5);
    $send['class_time'] = $row5['class_time'];
    $send['class_price'] = $row5['class_price'];

    if ($send['class_id'] != null) {
        array_push($result1['data'], $send);
    }
}


$result1["success"] = "1";
echo json_encode($result1);

mysqli_close($conn);