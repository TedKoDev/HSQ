<?php


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$token           =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$email           =   $_GET['email']; // 이메일
$password        =   $_GET['hash']; // 패스워드

echo $email .'</br>'  ;
echo $password;

// DB 정보 가져오기 
$sql = "SELECT * FROM User WHERE U_Email = '{$email}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$hashedPassword = $row['U_PW'];
echo $hashedPassword.'</br>';



// DB 정보를 가져왔으니 
// 비밀번호 검증 로직을 실행하면 된다.
$jwt = new JWT();

if ($password == $hashedPassword) {
    // 로그인 성공
    // 토큰 생성  id, name, email 값 저장

    $sql = "UPDATE User SET U_Active = '1' WHERE U_Email = '$email'";
    $result = mysqli_query($conn, $sql);


    $send["message"] = "yes";

    echo json_encode($send);
    mysqli_close($conn);

} else {
    // 로그인 실패 

    $send["message"] = "no";

    echo json_encode($send);
    mysqli_close($conn);

}