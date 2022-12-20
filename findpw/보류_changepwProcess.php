<?php


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$email           =   json_decode(file_get_contents("php://input"))->{"email"}; // email
$newpassword     =   json_decode(file_get_contents("php://input"))->{"password"}; // 새 이메일 



$sql = "UPDATE User SET U_PW = '$newpassword' WHERE U_Email = '$email'";
$result = mysqli_query($conn, $sql);
// DB 정보를 가져왔으니 
// 비밀번호 업데이트 로직을 실행하면 된다.


if ($result) {
    // 변경성공

    $send["message"] = "yes";

    echo json_encode($send);
    mysqli_close($conn);

} else {
    // 변경실패 

    $send["message"] = "no";

    echo json_encode($send);
    mysqli_close($conn);

}