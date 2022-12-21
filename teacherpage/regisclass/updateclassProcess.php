<?php
// 작성중!!!
// == 수업 수정 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 

//1. "token"    : "토큰값".
//2. "class_id"    : "수업 idx 값".


// 보낼 줄 때 형태 
// {
// "token"    : "토큰값".
// "class_id"    : "수업 idx 값"
// }


include("../../conn.php");
include("../../jwt.php");




$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token              =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$class_id            =   json_decode(file_get_contents("php://input"))->{"update_class_id"}; // 수업 id  
$class_name                      =   json_decode(file_get_contents("php://input"))->{"update_class_name"}; // 수업명 
$class_description      =   json_decode(file_get_contents("php://input"))->{"update_class_description"}; // 수업소개
$class_people                   =   json_decode(file_get_contents("php://input"))->{"update_class_people"}; // 수업인원
$class_type                =   json_decode(file_get_contents("php://input"))->{"update_class_type"}; // 수업종류
$class_level                  =   json_decode(file_get_contents("php://input"))->{"update_class_level"}; // 수업수준 
$class_timeprice              =   json_decode(file_get_contents("php://input"))->{"update_class_timeprice"}; // 수업 시간 금액 묶음  

// $class_timeprice = '[{"class_time":"30","class_price":"1"},{"class_time":"60","class_price":"2"}]' ; 
// $class_id      =   164; // 수업명 
// $User_ID =  320;


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);



// class_id 값을 기준으로 해당 항목의 user_id를 비교해서
// 다를경우  안된다고 돌려보내기 
// 동일 하면  수정 process시작 



//Class_List에 수업 목록확인  
$check = "SELECT * FROM Class_List where CLass_Id = '{$class_id}'";
$checkresult = mysqli_query($conn, $check);


$row = mysqli_fetch_array($checkresult);
$user_id_teacher = $row['user_id_teacher'];


// 
if ($user_id_teacher != $User_ID) {

  $send["success"]   =  "해당 사용자가 아님";
  echo json_encode($send);
  mysqli_close($conn);
} else {

  // update 코드 작성중  상세페이지 작성 이후 예정 



  // $updatesql = "UPDATE Class_List SET class_name = '수업1수정2', 
  // class_description = '수업1입니다 수정2', 
  // class_people = '1', class_type = '문법', class_level = 'A1_B1' where class_id ='164' ";



  $updatesql = "UPDATE Class_List SET class_name = '$class_name', class_description = '$class_description', class_people = '$class_people', class_type = '$class_type', class_level = '$class_level' where class_id = '$class_id' ";

  $response = mysqli_query($conn, $updatesql);



  $R = json_decode($class_timeprice, true);
  // json_decode : JSON 문자열을 PHP 배열로 바꾼다
  // json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.
  // $R : array data

  foreach ($R as $row) {
    $class_time = $row['class_time'];
    $class_price = $row['class_price'];

    $class_list_time_price_sql = "UPDATE Class_List_Time_Price SET class_price = '$class_price' where class_id = $class_id and class_time = '$class_time'";
    $updatetimeprice = mysqli_query($conn, $class_list_time_price_sql);
  }

  if ($response && $updatetimeprice) { //정상적으로 저장되었을때 

    $result["success"] = "업데이트 완료";
    echo json_encode($result);
    mysqli_close($conn);
  } else {

    $result["success"]   =  "업데이트 실패";
    echo json_encode($result);
    mysqli_close($conn);
  }
}
