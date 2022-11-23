<?php

//upload.php
// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$position = json_decode(file_get_contents("php://input"))->{"position"}; //항목
$desc = json_decode(file_get_contents("php://input"))->{"desc"};  //내용
$aa=$_FILES['sample_image']['name'];


error_log("123,2, 4c\n", "3", "./php.log");

error_log("test, $token, $position, $desc,$aa\n", "3", "./php.log");


if(isset($_FILES['sample_image']))
{

  date_default_timezone_set('Asia/Seoul');
  $time_now = date("Y-m-d h-m-s");

	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

  $new_name = $time_now .'.'.'userid'.'.'. $extension;

	move_uploaded_file($_FILES['sample_image']['tmp_name'], 'image/' . $new_name);

	$data = array(
		'image_source'		=>	'image/' . $new_name
	);

	echo json_encode($data);

}


?>