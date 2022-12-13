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

$email = json_decode(file_get_contents("php://input"))->{"user_email"};
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
 $email = $row['U_Email'];
$tokenemail = base64_encode($email);

 $userid = $row['User_ID'];
$tokenuserid = base64_encode($userid);


 $name = $row['U_Name'];
$tokenusername = base64_encode($name);




// DB 정보 가져오기 

$sql = "SELECT user_timezone FROM User_Detail WHERE user_id = '{$userid}'";
$result = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($result);
$timezone = $row1['0'];

//토큰화를 base64인코딩을 진행 

$tokentimezone = base64_encode($timezone);






// DB 정보를 가져왔으니 
// 비밀번호 검증 로직을 실행하면 된다.
$jwt = new JWT();
$passwordResult = password_verify($password, $hashedPassword);
if ($passwordResult === true) {
    // 로그인 성공
    // 토큰 생성  id, name, email 값 저장

    $time = time();
    $token = $jwt->hashing(
        array(
            'exp' => $time + (60*360), // 만료기간
            'iat' => $time, // 생성일
              'User_ID' => $tokenuserid,
        'U_Name'  =>  $tokenusername,
        'U_Email' => $tokenemail,   
        'TimeZone' => $tokentimezone 
        )
    );


    $send["token"] = "$token";
    $send["user_name"] = "$name";
    $send["success"] = "yes";

    echo json_encode($send);
    mysqli_close($conn);

} else {
    // 로그인 실패 
    $send["token"] = "no";
    $send["user_name"] = "no";
    $send["success"] = "no";

    echo json_encode($send);
    mysqli_close($conn);

}

?>


