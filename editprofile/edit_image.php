<?php

include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 

date_default_timezone_set('Asia/Seoul');
$time_now = date("Y-m-d H:i:s");

error_log("$time_now, $token\n", "3", "../php.log");
error_log("$time_now, 123\n", "3", "../php.log");





//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
//ar_dump($payload);




$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);

error_log("$time_now,'dd', $User_ID, $U_Name, $U_Email \n", "3", "../php.log");


if(isset($_FILES['sample_image']))
{

	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

  $new_name = time() .'.'. $extension;

	move_uploaded_file($_FILES['sample_image']['tmp_name'], 'image/' . $new_name);


 // DB내 이미지 이름 저장 
 $select = "UPDATE User_Detail SET U_D_Img = '$new_name' where User_Id = '$User_ID' ";
 $response = mysqli_query($conn, $select);



 // echo json_encode($data);
 if ($response) { //정상적으로 이미지가 저장되었을때 
   // Json 화  'image_source' 이름으로 프론트에서 수령하기  
   $data = array(
     'image_source'		=>	'image/' . $new_name,
     'success'           =>  'yes'
 );
 } else {
 // Json 화  'image_source' 이름으로 프론트에서 수령하기  
 $data = array(
     'image_source'		=>	'no',
     'success'           =>  'no'
 );
 }


	echo json_encode($data);


}


?>