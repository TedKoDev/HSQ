<?php







include("./conn.php");
include("./jwt.php");


$jwt = new JWT();





// 토큰값 받는곳 
if(isset($_POST['token']))
{
	$token = $_POST['token'];

	error_log("'1!!!!!   ',$time_now, 	$token\n", "3", "./php.log");

}

error_log("'2!!!!!   ',$time_now, 	$token\n", "3", "./php.log");

//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

//ar_dump($payload);


$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);

error_log("'test@@', $User_ID, $U_Name, $U_Email \n", "3", "./php.log");











// U_D에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM User_Detail where User_Id = '$User_ID'";
$checkresult = mysqli_query($conn, $check);

// error_log("$time_now,'ddd', $User_ID, $U_Name, $U_Email \n", "3", "/php.log");



// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows <1) {
    date_default_timezone_set('Asia/Seoul');
    $time_now = date("Y-m-d H:i:s");
    
    // error_log("$time_now, 's'\n", "3", "../php.log");
    
    // 중복값이 없을때 때 실행할 내용
    // 없으면 insert로  data 만들고  
    // 아래의 update로 data 삽입 
    $result = "INSERT INTO User_Detail (User_Id) VALUES ('$User_ID') ";
    $insert = mysqli_query($conn, $result);
    //   $send["message"] = "no";
    //   $send["message"] = "no";

    // echo json_encode($send);
    mysqli_close($conn);
}







//이미지 받는곳 
if(isset($_FILES['sample_image']))
{

  date_default_timezone_set('Asia/Seoul');
  $time_now = date("Y-m-d h-m-s");

	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

  $new_name = $time_now .'.'.$User_ID.'.'. $extension;

	error_log("'image  ', 	$User_ID\n", "3", "./php.log");




	$select = "UPDATE User_Detail SET U_D_Img = '$new_name' where User_Id = '$User_ID' ";

	$response = mysqli_query($conn, $select);


	move_uploaded_file($_FILES['sample_image']['tmp_name'], 'image/' . $new_name);





	if ($response) { //정상적으로 이미지가 저장되었을때 
		$data = array(
			'image_source'		=>	'image/' . $new_name,
			'success'        	=>	'yes'
		);
			echo json_encode($data);
			mysqli_close($conn);
	} else {
		$data = array(
			'image_source'		=>	'no',
			'success'        	=>	'yes'
		);
			echo json_encode($data);
			mysqli_close($conn);
	}





}




?>