<?php


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$email           =   json_decode(file_get_contents("php://input"))->{"email"}; // email
$email           =   'ghdxodml@naver.com'; // email
$newpassword     =   json_decode(file_get_contents("php://input"))->{"password"}; // 새 이메일 
$newpassword     =   '12345678'; // 새 이메일 


// error_log("$time_now, $name, $email,$password \n", "3", "/php.log");
$hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);


$sql = "UPDATE User SET user_password = '$hashedPassword' WHERE user_email = '$email'";
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
