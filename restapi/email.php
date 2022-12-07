<?php

/***

E-mail  RestAPI
email.php

동작 종류  (kind)  
1. key값 : 'regist' 용도: 회원가입시 이메일 인증 
  필요한값 :   // $kind      =   'regist'; // 종류
              // $email     =   'ghdxodml@naver.com'; // 이메일
              // $password  =   '12345678'; // 패스워드

  전달되는 링크 :   이메일 확인 링크   



2. key값 : 'findpw' 용도: 비밀번호 찾기 
  필요한값 :   // $kind      =   'findpw'; // 종류
              // $email     =   'ghdxodml@naver.com'; // 이메일

  전달되는 링크 : 비밀번호 수정 화면 



3. key값 : 'regicl' 용도: 수업 예약신청 하기 
  필요한값 :  강사 userid        tusid 
              토큰               token
             학생이름            sname
             선택일정            splan
             선택수업            sclass
             학생이메일          semail
               
  전달되는 링크 :    강사의 수업 예약수락 링크   
                    강사의 수업 예약거절 링크   
 
 */



include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
 
// $kind            =   'regist'; // 회원가입시 
// $kind            =   'findpw'; // 비번찾기
// $kind            =   'regicl'; // 수업예약 
// $email           =   'ghdxodml@naver.com'; // 이메일
// $password        =   '12345678'; // 패스워드

//회원인증시 필요 

$kind            =   json_decode(file_get_contents("php://input"))->{"kind"};     // 종류
$email           =   json_decode(file_get_contents("php://input"))->{"email"};    // 이메일
$password        =   json_decode(file_get_contents("php://input"))->{"password"}; // 패스워드


//회원가입시 필요 
$utc             =   json_decode(file_get_contents("php://input"))->{"utc"}; // utc 값 



// 학생의 수업 예약 
$token        =   json_decode(file_get_contents("php://input"))->{"token"};    // 토큰 
$tusid        =   json_decode(file_get_contents("php://input"))->{"tusid"};     // 강사 userid
$sname        =   json_decode(file_get_contents("php://input"))->{"sname"};     // 학생 이름
$splan        =   json_decode(file_get_contents("php://input"))->{"splan"};     // 학생 선택일정 
$sclass       =   json_decode(file_get_contents("php://input"))->{"sclass"};    // 학생 선택 수업 
$semail       =   json_decode(file_get_contents("php://input"))->{"semail"};    // 학생 이메일 



//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



// 회원가입시 이메일 인증 
if ($kind == 'regist') {


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
   {    // 값이 없을 때 실행할 내용
    $sql = " INSERT INTO User (U_Email, U_PW, U_Name, U_Google_key, U_Facebook_key, U_Character, U_Active, U_Register_Date)
             VALUES('{$email}', '{$hashedPassword}','{$name}', 'null', 'null','null','0', NOW() )";


    $result = mysqli_query($conn, $sql);


    $sql = "SELECT * FROM User WHERE U_Email = '{$email}'";
    $result = mysqli_query($conn, $sql);

    $row1 = mysqli_fetch_array($result);
    $User_ID = $row1['0'];
    $U_Name = $row1['2'];

    if ($result === false) {
        echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
        echo mysqli_error($conn);
    } else {

        $result = "INSERT INTO User_Detail (User_Id, U_D_Timezone) VALUES ('$User_ID','$utc') ";
        $insert = mysqli_query($conn, $result);

        $subject = 'Hangle Square vertify Email for register LINK';
        $message = '
        Thanks for signing up!'. "<br/>".'
        Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.'. "<br/>".'
         
        ------------------------'. "<br/>".'
        UserEmail: '.$email.''. "<br/>".'
        Name: '.$U_Name.''. "<br/>".'
        ------------------------'. "<br/>".'
         
        Please click this link to activate your account:'. "<br/>".'
        http://localhost/signup/verify.php?email='.$email.'&hash='.$hashedPassword.'
        '; // Our message above including the link;

        $mail = new PHPMailer(true);
        $mail->CharSet = "utf-8";   //한글이 안깨지게 CharSet 설정
        $mail->Encoding = "base64";
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "apswtrare@gmail.com";
        $mail->Password = "uxyexqvdxkumbexb";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('apswtrare@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        $mail->send();
    }
  }
} else if($kind == 'findpw'){
  //비밀번호 찾기  


  $sql = "SELECT * FROM User WHERE U_Email = '{$email}'";
  $result = mysqli_query($conn, $sql);

  $row1 = mysqli_fetch_array($result);
  $User_ID = $row1['0'];
  $U_Name = $row1['3'];

  $subject = 'Hangle Square change password Link';
  $message = '
  Click Link and change your Password'. "<br/>".'
  You can change your password.'. "<br/>".'
   
  ------------------------'. "<br/>".'
  UserEmail: '.$email.''. "<br/>".'
  Name: '.$U_Name.''. "<br/>".'
  ------------------------'. "<br/>".'
   
  Please click this link to change your account password:'. "<br/>".'
  http://localhost/findpw/변경화면.php?email='.$email.'
  '; // Our message above including the link;

  $mail = new PHPMailer(true);
  $mail->CharSet = "utf-8";   //한글이 안깨지게 CharSet 설정
  $mail->Encoding = "base64";
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  
  $mail->Host = "smtp.gmail.com";
  $mail->Username = "apswtrare@gmail.com";
  $mail->Password = "uxyexqvdxkumbexb";
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
  $mail->setFrom('apswtrare@gmail.com');
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $message;
  
  $mail->send();




}else if($kind == 'regicl'){

/***
강사 userid                  tusid
학생이름                     sname
선택일정                     splan
선택수업                     sclass
학생이메일                   semail



강사의 수업 예약확인 링크   
*/

$subject = 'Hangle Square : '.$sname.' want register your class';
$message = '
'.$sname.' want to make a reservation your class!'. "<br/>".'
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.'. "<br/>".'
 
------------------------'. "<br/>".'
Student-Email: '.$semail.''. "<br/>".'
Student-Name: '.$sname.''. "<br/>".'
Class-Name: '.$sclass.''. "<br/>".'
Plan: '.$splan.''. "<br/>".'
------------------------'. "<br/>".'
 
AGREE(예약승인) : Please click this link to accept reservation for class :'.$sclass.''. "<br/>".'
http://localhost/수업예약.php?email='.$email.'&plan='.$splan.'&class='.$sclass.'&name='.$sname.'&agree='.'0'.'
'. "<br/>".'
'. "<br/>".'

REFUSE(예약거절): Please click this link to accept reservation for class :'.$sclass.''. "<br/>".'
http://localhost/수업예약.php?email='.$email.'&plan='.$splan.'&class='.$sclass.'&name='.$sname.'&agree='.'1'.'


'; // Our message above including the link;

$mail = new PHPMailer(true);
$mail->CharSet = "utf-8";   //한글이 안깨지게 CharSet 설정
$mail->Encoding = "base64";
$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->Username = "apswtrare@gmail.com";
$mail->Password = "uxyexqvdxkumbexb";
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom('apswtrare@gmail.com');
$mail->addAddress($email);
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();














}
