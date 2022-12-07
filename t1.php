<?php


error_reporting(E_ALL);
ini_set('display_errors', '1');
require './aws/aws-autoloader.php';


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


// Form 전송을 통해 업로드 할 경우에는 아래와 같이 사용됩니다.
$s3_path = 'Image/'.time().'.png'; // 업로드할 위치와 파일명 입니다.
echo $file_path = $_FILES['file']['tmp_name']; // Form 전송을 통해 받은 데이터 입니다.
$result = $s3Client->putObject(array(
  'Bucket' => 'hangle-square',
  'Key'    => $s3_path,
  'SourceFile' => $file_path,

));



if ($result) { //정상적으로 이미지가 저장되었을때 
    $data = array(
        'image_source'		=>	'https://hangle-square.s3.ap-northeast-2.amazonaws.com/'.$s3_path ,
        'success'        	=>	'yes'
    );
    echo json_encode($data);
    mysqli_close($conn);
} else {
    $data = array(
        'image_source'		=>	'no',
        'success'        	=>	'no'
    );
    echo json_encode($data);
    mysqli_close($conn);
}
