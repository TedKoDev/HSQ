<?php
require_once './vendor/autoload.php';
use Firebase\JWT\JWT;
$secret_key = "this-is-the-secret";

// 데이터 입력
$id = "sysdocu";
$email = "sysdocu@sysdocu.tistory.com";
$addr = "seoul";
$phone = "010-1111-2222";
 
$data = array(
    'id' => $id,
    'email' => $email,
    'addr' => $addr,
    'phone' => $phone
);
 
$jwt = JWT::encode($data, $secret_key);
echo "encoded jwt: " . $jwt . "<br>";
 
//$decoded = JWT::decode($jwt, $secret_key, array('HS256'));
//print_r($decoded);
?>