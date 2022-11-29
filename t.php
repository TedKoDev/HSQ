<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "schedule" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 




include("./conn.php");
include("./jwt.php");


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



    $sql = " INSERT INTO User (U_Email, U_PW, U_Name, U_Google_key, U_Facebook_key, U_Register_Date)
 VALUES('{$email}', '{$hashedPassword}','{$name}', 'null', 'null', NOW() )";
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
