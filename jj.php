<?php
    
      error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
include("./jwt.php");


$jwt = new JWT();

$id = 10;
$id = base64_encode($id);
$email = "qqq";
$email = base64_encode($email); // .이 들어가도 JWT가 분리되지 않기 위한 base64 인코딩

$password = "qqq";
$password = base64_encode($password); // .이 들어가도 JWT가 분리되지 않기 위한 base64 인코딩


// 유저 정보를 가진 jwt 만들기
$token = $jwt->hashing(array(
//     'exp' => time() + (360 * 30), // 만료기간
//     'iat' => time(), // 생성일
    'id' => $id ,
    'email' => $email,
    'password' => $password
));
echo "<br/><br/>";


echo "qqqqqqqqqqqqqqq";
echo "<br/><br/>";
var_dump($token);
echo "<br/><br/>";
echo "!!!tokkken";
echo "<br/><br/>";
echo  $tt;
echo "<br/><br/>";echo "<br/><br/>";echo "<br/><br/>";
/*
* 
* (출력 결과)
* eyJhbGciOiJzaGEyNTYiLCJ0eXAiOiJKV1QifS57ImV4cCI6MTYyMTg1MjIxMiwiaWF0Ijox
* NjIxODQxNDEyLCJpZCI6MTAsImVtYWlsIjoiYzJsdGNHeGxRRzFoYVd3dVkyOXQiLCJwYXNz
* d29yZCI6ImNHRnpjM2R2Y21RdUxqRXlNelE9In0uZTg1YmMxY2JjNWYwNmEzZTk5NjAyZTdh
* YWY3ZTEwMmQ5YWQ0YzgxN2Y5ODk3MGM0M2FhZDc3YWMwYTFiYzQ0MA==
*
*/

$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

var_dump($payload);

echo "<br/><br/>";
echo $id=  base64_decode($payload['id']);
echo "<br/><br/>";
echo $email=  base64_decode($payload['email']);
echo "<br/><br/>";
echo $pw=  base64_decode($payload['password']);
echo "<br/><br/>";
echo $email;
echo "<br/><br/>";
echo $pw;




?>