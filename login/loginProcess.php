<?php
include("../conn.php");
include("../jwt.php");

// == 일반 로그인 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1.이메일 - eamil 
//2.비밀번호 - password  

# 보낼때 형태 
// {
//  "email" : "qwe",
//  "password":"qwe"
// }


// #반환되는 데미터 
// ==성공시 
// 1. 토큰값 - token ('User_ID','U_Name', 'U_Email' 이 암호화 된 값) 
// 2. 이름 -  name   ("U_Name")
// 3. 메세지 - message ("yes")
# 반환형태 
// {"token":"eyJhbGciOiJz...(이하생략)",
//  "name":"qwe",
//  "message":"yes"}


// ==실패시 
// 1. 토큰값 - token ("no") 
// 2. 이름 -  name   ("no")
// 3. 메세지 - message ("no")
# 반환형태 
// {"token":"no","name":"no","message":"no"}





file_get_contents("php://input") . "<br/>";

$email = json_decode(file_get_contents("php://input"))->{"email"};
$password = json_decode(file_get_contents("php://input"))->{"password"};


//아이디 비교와 비밀번호 비교가 필요한 시점이다.
// 1차로 DB에서 비밀번호를 가져온다 
// 평문의 비밀번호와 암호화된 비밀번호를 비교해서 검증한다.
// $email = $_POST['email'];
// $password = $_POST['password'];

// DB 정보 가져오기 
$sql = "SELECT * FROM User WHERE U_Email = '{$email}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$hashedPassword = $row['U_PW'];


//토큰화를 base64인코딩을 진행 
 $tokenemail = $row['U_Email'];
$tokenemail = base64_encode($tokenemail);

 $tokenuserid = $row['User_ID'];
$tokenuserid = base64_encode($tokenuserid);

$tokenusername = $row['U_Name'];
 $name = $row['U_Name'];
$tokenusername = base64_encode($tokenusername);



// DB 정보를 가져왔으니 
// 비밀번호 검증 로직을 실행하면 된다.
$jwt = new JWT();
$passwordResult = password_verify($password, $hashedPassword);
if ($passwordResult === true) {
    // 로그인 성공
    // 토큰 생성  id, name, email 값 저장

    $token = $jwt->hashing(
        array(
              'User_ID' => $tokenuserid,
        'U_Name'  =>  $tokenusername,
        'U_Email' => $tokenemail,    
        )
    );


    $send["token"] = "$token";
    $send["name"] = "$name";
    $send["message"] = "yes";

    echo json_encode($send);
    mysqli_close($conn);

} else {
    // 로그인 실패 
    $send["token"] = "no";
    $send["name"] = "no";
    $send["message"] = "no";

    echo json_encode($send);
    mysqli_close($conn);

}

?>


