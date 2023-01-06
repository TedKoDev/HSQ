<?php



include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값 전달 받음 

$token = json_decode(file_get_contents("php://input"))->{"token"};
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"};
// $utc      =   9; 



if ($token != null) {

  //토큰 해체 
  $data = $jwt->dehashing($token);
  $parted = explode('.', base64_decode($token));
  $payload = json_decode($parted[1], true);
  $User_ID =  base64_decode($payload['User_ID']);
  // $User_ID =  324;
  $U_Name  = base64_decode($payload['U_Name']);
  $U_Email = base64_decode($payload['U_Email']);
  $timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone
  // $timezone      =   8;

} else {
  // echo 111;
  $timezone = $utc;
}




$sql = "SELECT post_id, user_id_post, category, title,author, post_date  FROM HANGLE.Post_Board ORDER BY post_date DESC";


$result = mysqli_query($conn, $sql);

//foreach array 
$send = array();
$send['post'] = array();

while ($row = mysqli_fetch_array($result)) {
  $post = array();
  $post['post_id'] = $row['post_id'];
  $post['user_id_post'] = $row['user_id_post'];
  $post['category'] = $row['category'];
  $post['title'] = $row['title'];
  $post['author'] = $row['author'];
  $post['post_date'] = $row['post_date'];
  array_push($send['post'], $post);
}

if ($result) {
  $send['result'] = "success";
  echo json_encode($send);
  mysqli_close($conn);
} else {
  $send['result'] = "fail";
  mysqli_close($conn);
}
