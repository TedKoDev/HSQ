
<?php 
// == 강사 찾기 페이지  프로세스==  추후 출력항목 추가될 예정 
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 구조
// 1. 토큰 수령후 User_Id 값 추출 (사용자)  
// 2. 필요한 정보  (아래 참고사항 확인하기 )
//  (강사의 User_Id, U_D_Img, U_Name, U_T_Special, U_D_Language, U_T_Intro, U_D_Intro, Price(Class_List, Class_List_Time_Price 정리)

// 3. 정보 모아 프론트로 전달. 


// {"User_Id":"32","U_T_Intro":"\uc18c\uac1c15","U_T_Special":"USER_1669268662.zip","U_D_Img":"1669356350PNG","U_D_Language":"{\"\uc601\uc5b4\":\"B1\",\"\uc911\uad6d\uc5b4\":\"A1\"}","U_Name":"\uc548\ud574\uc77822","class_id":"34","Time":"30","Price":"10"},


//     ## 참고사항  - 현재까지 진행상황 상 지금 처리해야 할 부분 :
//     - 강사 id → 강사 클릭 했을 때 강사 상세 화면으로 이동하기 위해
//     - 강사 프로필 이미지
//     - 강사 이름
//     - 강사 자격 (전문강사 or 튜터)
//     - 강사의 구사 가능 언어 및 구사 수준
//     - 강사 소개 (강사가 강사 등록할 때 작성한 강사 소개)
//     - 자기 소개 
//     - 수업료 (30분 이건 60분이건 강사가 등록한 수업중 가장 저렴한 수업료 보냄) -->




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
