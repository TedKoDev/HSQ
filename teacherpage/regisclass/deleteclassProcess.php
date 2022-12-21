<?php
// 
// == 수업 삭제 프로세스==
//   #요구되는 파라미터 

//1. "token"    : "토큰값".
//2. "class_id"    : "수업 idx 값".



include("../../conn.php");
include("../../jwt.php");




$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$class_id      =   json_decode(file_get_contents("php://input"))->{"delete_class_id"}; // 수업 seq값 



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



  $updatesql = "DELETE FROM a,b  USING Class_List AS a  LEFT JOIN Class_List_Time_Price AS b  ON a.class_id = b.class_id WHERE b.class_id = '$class_id' ";

  $response = mysqli_query($conn, $updatesql);



  if ($response) { //정상적으로 저장되었을때 

    $result["success"] = "삭제 완료";
    echo json_encode($result);
    mysqli_close($conn);



  } else {

    $result["success"]   =  "삭제 실패";
    echo json_encode($result);
    mysqli_close($conn);
  }
}
