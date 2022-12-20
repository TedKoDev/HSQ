<?php 


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"}; // 더보기 



$email = $_GET["email"];
$CAID = $_GET["CAID"];
$agree = $_GET["agree"];


error_log("$email, $CAID, $agree\n", "3", "../php.log");







 $answerTime =    time();
//  $date = date('Y-m-d H:i:s', $answerTime);




$select = "UPDATE Class_Add SET class_register_status = '$agree', class_register_answer_date = $answerTime where class_register_id = '$CAID' ";
 $response = mysqli_query($conn, $select);
 mysqli_close($conn);


// 2022-12-08 03:36:30