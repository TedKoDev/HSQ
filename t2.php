<?php
// 다운로드한 SDK 파일의 autoloader를 불러옵니다. 저는 그누보드에 사용해서 G5_PATH를 이용했습니다.
include_once('./aws/aws-autoloader.php');

// AWS S3에 파일 업로드할 때 필요한 클래스들을 불러옵니다.
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\Credentials\CredentialProvider;

// 파일 업로드 하기 전 설정
$s3Client = S3Client::factory(array(
  'region' => 'ap-northeast-2', // S3 리전을 입력합니다.(저는 서울 리전)
  'version' => 'latest',
  'signature' => 'v4',
  'credentials' => [
    'key'    => 'AKIAWBRH4IMAJ3QJ45UC', 
      'secret' => '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',
  ],
));


// Form 전송을 통해 업로드 할 경우에는 아래와 같이 사용됩니다.
$s3_path = 'https://hangle-square.s3.ap-northeast-2.amazonaws.com/Image/test.png'; // 업로드할 위치와 파일명 입니다.
$file_path = $_FILES['file']['tmp_name']; // Form 전송을 통해 받은 데이터 입니다.
$result = $s3Client->putObject(array(
  'Bucket' => '업로드 하려는 버킷명',
  'Key'    => $s3_path,
  'SourceFile' => $file_path,
  'ACL'    => 'public-read'
));