<?php

// == editimage 프로세스==
//   #요구되는 파라미터 (fetch형태 formdat 형태로 요청 ) 
//1. 토큰값  - token 
//2. 이미지파일 - position 

  // form_data.append('sample_image', file); // 파일값 
	// form_data.append('token', 'token fjaoidfjl..');   // 토큰값 



	// fetch("fetchupload2.php", {

	// 	method:"POST",

  //   	body:form_data
		

	// }) ... 이하생략 fetch2.html 참고 




// 요청사항 



include("../conn.php");
include("../jwt.php");


$jwt = new JWT();


// 토큰값 받는곳 
if (isset($_POST['token'])) {
	$token = $_POST['token'];

	// error_log("'1!!!!!   ',$time_now, 	$token\n", "3", "../php.log");
}



//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);



// User_ID값 얻음 
$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);






// U_D에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM User_Detail where User_Id = '$User_ID'";
$checkresult = mysqli_query($conn, $check);

// error_log("$time_now,'ddd', $User_ID, $U_Name, $U_Email \n", "3", "/php.log");

// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows < 1) {


	// 중복값이 없을때 때 실행할 내용
	// 없으면 insert로  data 만들고  
	$result = "INSERT INTO User_Detail (User_Id) VALUES ('$User_ID') ";
	$insert = mysqli_query($conn, $result);
	//   $send["message"] = "no";
	//   $send["message"] = "no";

	// echo json_encode($send);
	// mysqli_close($conn);
}




//formdata로 받은 이미지 받는곳 
if (isset($_FILES['sample_image'])) {


	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

	$new_name = time()  . $extension;

	// error_log("'image  ', 	$User_ID\n", "3", "../php.log");




	$select = "UPDATE User_Detail SET U_D_Img = '$new_name' where User_Id = '$User_ID' ";

	$response = mysqli_query($conn, $select);


	// move_uploaded_file($_FILES['sample_image']['tmp_name'], 'image/' . $new_name);
	// move_uploaded_file($_FILES['sample_image']['tmp_name'], 'https://hangle-square.s3.ap-northeast-2.amazonaws.com/Image/' . $new_name);
	move_uploaded_file($_FILES['sample_image']['tmp_name'], 's3://hangle-square/Image/' . $new_name);

	// 1670316352PNG
	// 1670316402PNG



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