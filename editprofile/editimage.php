<?php



include("../conn.php");
include("../jwt.php");
require '../aws/aws-autoloader.php';


use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;


$s3Client = new S3Client([
	'version' => 'latest',
	'region'  => 'ap-northeast-2',
	'credentials' => [
		'key'    => 'AKIAWBRH4IMAJ3QJ45UC', 
		'secret' => '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',
	]
]);


$jwt = new JWT();


// 토큰값 받는곳 
if (isset($_POST['token'])) {
	$token = $_POST['token'];

	error_log("'1!!!!!   ',$time_now, 	$token\n", "3", "../php.log");
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

$check = "SELECT * FROM User_Detail where user_id = '$User_ID'";
$checkresult = mysqli_query($conn, $check);

error_log("'ddd', $User_ID, $U_Name, $U_Email \n", "3", "./php.log");

// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows < 1) {


	// 중복값이 없을때 때 실행할 내용
	// 없으면 insert로  data 만들고  
	$result = "INSERT INTO User_Detail (user_id) VALUES ('$User_ID') ";
	$insert = mysqli_query($conn, $result);
	//   $send["message"] = "no";
	//   $send["message"] = "no";

	// echo json_encode($send);
	// mysqli_close($conn);
}




//formdata로 받은 이미지 받는곳 
if (isset($_FILES['sample_image'])) {


	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

	$new_name = 'P_IMG_'.$User_ID.'.' . $extension;

	error_log("'image  ', 	$new_name\n", "3", "./php.log");




	// $select = "UPDATE User_Detail SET U_D_Img = '$new_name' where User_Id = '$User_ID' ";
	$select = "UPDATE User_Detail SET user_img = '$new_name' where user_id = '$User_ID' ";

	$response = mysqli_query($conn, $select);


	

// Form 전송을 통해 업로드 할 경우에는 아래와 같이 사용됩니다.
$s3_path = 'Profile_Image/'.$new_name ; // 업로드할 위치와 파일명 입니다.



$file_path = $_FILES['sample_image']['tmp_name']; // Form 전송을 통해 받은 데이터 입니다.
$result = $s3Client->putObject(array(
  'Bucket' => 'hangle-square',
  'Key'    => $s3_path,
  'SourceFile' => $file_path,

));




	if ($response) { //정상적으로 이미지가 저장되었을때 
		$data = array(
			'image_path'		=>	'https://hangle-square.s3.ap-northeast-2.amazonaws.com/'.$s3_path ,
			'success'        	=>	'yes'
		);
		echo json_encode($data);
		mysqli_close($conn);
	} else {
		$data = array(
			'image_path'		=>	'no',
			'success'        	=>	'yes'
		);
		echo json_encode($data);
		mysqli_close($conn);
	}
//2022.12.14 대공사 수정완료 db 테이블 칼럼 및  입출 변수 수정완료 .

}