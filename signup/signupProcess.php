<?php

    
    
    
// 일반 회원가입 
// 요구되는 파라미터 
// 1. email  - email 
// 2. 비밀번호 - password 
// 3. 이름     - name 


// # 사용가능할때는  (yes 일치한다 ) 
// # 사용이 불가할떄는 (no 일치하지 않는다 값)

// # 요청사항 
// 회원가입 완료시  로그인 페이지로 이동 


include("../conn.php"); 
include("../jwt.php");

 file_get_contents("php://input")."<br/>";
 $name = json_decode(file_get_contents("php://input"))->{"name"};
 $email = json_decode(file_get_contents("php://input"))->{"email"};
 $password = json_decode(file_get_contents("php://input"))->{"password"};


date_default_timezone_set('Asia/Seoul');
$time_now = date("Y-m-d H:i:s");

error_log("$time_now, $name, $email,$password \n", "3", "/php.log");
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);






//아이디 중복 체크 
$check = "SELECT * FROM User where U_Email = '{$email}'";
$checkresult = mysqli_query($conn, $check);


//중복 값이 있는지 없는지 확인한다
if ($checkresult->num_rows > 0) {
    // 중복값이 있을 때 실행할 내용
   
      $send["message"] = "no";
      $send["message1"] = "no";
    
    echo json_encode($send);
    mysqli_close($conn);

} else 
{
    // 값이 없을 때 실행할 내용



    $sql = " INSERT INTO User (U_Email, U_PW, U_Name, U_Google_key, U_Facebook_key, U_Character, U_Register_Date)
 VALUES('{$email}', '{$hashedPassword}','{$name}', 'null', 'null','null', NOW() )";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
        echo mysqli_error($conn);
    } else {

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

    // 로그인 성공
    // 토큰 생성  id, name, email 값 저장
  
    $token = $jwt->hashing(array(
        'User_ID' => $tokenuserid,
        'U_Name'  =>  $tokenusername,
        'U_Email' => $tokenemail,      
    ));

        $send["token"] = "$token";
        $send["name"] = "$name";
        $send["message"] = "yes";
        
        echo json_encode($send);
        mysqli_close($conn);

    }
}
?>
