<?php
require_once './vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'example_key';
$payload = [
    'iss' => 'http://example.org',
    'aud' => 'http://example.com',
    'iat' => 1356999524,
    'nbf' => 1357000000
];

//secret base64 encoded 적용 
// $jwt = JWT::encode($payload, $key, 'HS256');
// echo $jwt = JWT::encode($payload, $key, 'HS256');
// $decoded = JWT::decode($jwt, new Key($key, 'HS256'));


//base64 encoded 적용
echo $jwt = JWT::encode($payload, base64_encode($key), 'HS256');
