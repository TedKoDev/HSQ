<?php
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

$bucket = 'hangle-square';
$source = 's3.php';
$uploadKey = uniqid('profile_', true) . '.' . end(explode('.', $source));
$uploader = new MultipartUploader($s3Client, $source, [
    'bucket' => $bucket,
    'key' => 'Image/'.$uploadKey,
]);

try {
    $result = $uploader->upload();
    echo "Upload complete: {$result['ObjectURL']}\n";
} catch (MultipartUploadException $e) {
    echo $e->getMessage() . "\n";
}

?>