<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("../conn.php");
include("../jwt.php");

file_get_contents("php://input") . "<br/>";

// $email = json_decode(file_get_contents("php://input"))->{"user_email"};
// $password = json_decode(file_get_contents("php://input"))->{"password"};
$email = 'ghdxodml@naver.com';
$password = '12345678';

$stmt = $db->prepare("SELECT * FROM User WHERE user_email = :email");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$hashedPassword = $row['user_password'];

$email = $row['user_email'];
$tokenemail = base64_encode($email);

$userid = $row['user_id'];
$tokenuserid = base64_encode($userid);

$name = $row['user_name'];
$tokenusername = base64_encode($name);

$stmt = $db->prepare("SELECT user_timezone FROM User_Detail WHERE user_id = :userid");
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();
$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
$timezone = $row1['user_timezone'];

$tokentimezone = base64_encode($timezone);

$jwt = new JWT();
$passwordResult = password_verify($password, $hashedPassword);
if ($passwordResult === true) {

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
    $db= null;

} else {

    $send["token"] = "no";
    $send["user_name"] = "no";
    $send["success"] = "no";

    echo json_encode($send);
    $db = null;

}
