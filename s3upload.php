<?php

require './aws/aws-autoloader.php';

$target_dir = "./uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-northeast-2',
    'credentials' => [
        'key' => 'AKIASOPA5YZJROQQIEL2',
        'secret' => '5gs8Gj2Q/HqsQmTZPo83qyj1s9F/jNLvsZZBRtf8'
    ]
]);

echo $_POST["submit"].'<br>' ;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}


if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    $bucket = 'hangle-square';
    $source = $file;
    $uploadKey = uniqid('profile_', true) . '.' . end(explode('.', $source));
    $uploader = new MultipartUploader($s3Client, $source, [
        'bucket' => $bucket,
        'key' => $uploadKey,
    ]);
    
    try {
        $result = $uploader->upload();
        echo "Upload complete: {$result['ObjectURL']}\n";
    } catch (MultipartUploadException $e) {
        echo $e->getMessage() . "\n";
    }
}
?>
