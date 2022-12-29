<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include("./conn.php");
include("./jwt.php");
require './aws/aws-autoloader.php';


use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use WGenial\S3ObjectsStreamZip\S3ObjectsStreamZip;
use WGenial\S3ObjectsStreamZip\Exception\InvalidParamsException;


 $s3Client = new S3Client([
	'version' => 'latest',
	'region'  => 'ap-northeast-2',
	'credentials' => [
		'key'    => 'AKIAWBRH4IMAJ3QJ45UC', 
		'secret' => 'rmbKH37I285yOhLN+GJ8aGt23x1/YJ3d+Sx1tC/O',
	]
]);


//formdata로 받은 이미지 받는곳 
if (isset($_FILES['sample_image'])) {


	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

	$new_name = 'P_IMG_'.$User_ID.'.' . $extension;

	error_log("'image  ', 	$new_name\n", "3", "./php.log");





  // Form 전송을 통해 업로드 할 경우에는 아래와 같이 사용됩니다.
  $s3_path = 'Teacher_Request_File/'.$new_name ; // 업로드할 위치와 파일명 입니다.
  $s3_path = 'Teacher_Request_File/'.$new_name ; // 업로드할 위치와 파일명 입니다.
  // $s3_path1 = 's3://hangle-square/Teacher_Request_File/'.$new_name ; // 업로드할 위치와 파일명 입니다.
  // s3://hangle-square/Teacher_Request_File/
  // https://hangle-square.s3.ap-northeast-2.amazonaws.com/Teacher_Request_File/
  



	



			$zip = new ZipArchive();
			$zip_time = time();

			// $zip_name1 = "../uploads/USER_" . $zip_time . ".zip";
			$zip_name1 = "s3://hangle-square/Teacher_Request_File/". $zip_time . ".zip";
			$zip_name2 = "USER_" . $zip_time . ".zip";

			// Create a zip target
			if ($zip->open($zip_name1, ZipArchive::CREATE) !== TRUE) {
					$error .= "Sorry ZIP creation is not working currently.<br/>";
			}

			$imageCount = count($_FILES['img']['name']);
			for ($i = 0; $i < $imageCount; $i++) {
			
					if ($_FILES['img']['tmp_name'][$i] == '') {
							continue;
					}
					// $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
				
					// Moving files to zip.
					$zip->addFromString($_FILES['img']['name'][$i], file_get_contents($_FILES['img']['tmp_name'][$i]));
			}
			$zip->close();




$file_path = $_FILES['sample_image']['tmp_name']; // Form 전송을 통해 받은 데이터 입니다.
$file_path = $zip; // Form 전송을 통해 받은 데이터 입니다.

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