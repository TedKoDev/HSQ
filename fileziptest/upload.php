<?php


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

if ($_FILES && $_FILES['img']) {
    
    if (!empty($_FILES['img']['name'][0])) {
        
        $zip = new ZipArchive();
        // $zip_name = getcwd() . "/uploads/upload_" . time() . ".zip";
        $zip_name = "../uploads/upload_" . time() . ".zip";
        $zip_time = time();
        $zip_name2 = "USER_" . $zip_time . ".zip";
        
        // Create a zip target
        if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
            $error .= "Sorry ZIP creation is not working currently.<br/>";
        }
        
        $imageCount = count($_FILES['img']['name']);
        for($i=0;$i<$imageCount;$i++) {
        
            if ($_FILES['img']['tmp_name'][$i] == '') {
                continue;
            }
            $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
            
            // Moving files to zip.
            $zip->addFromString($_FILES['img']['name'][$i], file_get_contents($_FILES['img']['tmp_name'][$i]));
            
            // // moving files to the target folder.
            // move_uploaded_file($_FILES['img']['tmp_name'][$i], '../uploads/' . $newname);
          // Form 전송을 통해 업로드 할 경우에는 아래와 같이 사용됩니다.



        }
        $zip->close();


        $s3_path = 'Teacher_Request_File/'.$zip_name2 ; // 업로드할 위치와 파일명 입니다.               


        // $file_path = '../uploads/'.$zip_name2 ; // Form 전송을 통해 받은 데이터 입니다.
        // $file_path = 'http://localhost/uploads/'.$zip_name ; // Form 전송을 통해 받은 데이터 입니다.
      //   $file_data = file_get_contents($file_path); // Form 전송을 통해 받은 데이터 입니다.
        $file_data = $zip_name; // Form 전송을 통해 받은 데이터 입니다.
        $result = $s3Client->putObject(array(
          'Bucket' => 'hangle-square',
          'Key'    => $s3_path,
          'SourceFile' => $file_data ,
       
        ));
        // https://hangle-square.s3.ap-northeast-2.amazonaws.com/Teacher_Request_File/USER_1672304129.zip
        // Create HTML Link option to download zip
        // $success = file_get_contents('https://hangle-square.s3.ap-northeast-2.amazonaws.com/Teacher_Request_File/'.$zip_name);
        $success = 'https://hangle-square.s3.ap-northeast-2.amazonaws.com/'.$s3_path ;

        unlink($zip_name);


    } else {
        $error = '<strong>Error!! </strong> Please select a file.';
    }
}