<?php
mkdir ("./image",0777);

$photo = $_FILES['photo'];

$uploadDir = "./image/";
$fileName = $photo['name'];
$tmpName = $photo['tmp_name'];

$fileNames = array();

for($i=0; $i<count($fileName); $i++){
   move_uploaded_file($tmpName[$i], $uploadDir.$fileName[$i]); // 디렉토리에 저장하기
   array_push($fileNames, $fileName[$i]); // 가공해서 배열에 넣기
   $arrayString = implode(",", $fileNames); // 배열을 문자열로 만들기
}

$query = "insert into mysql(photo) values ('$arrayString')";
mysqli_query($connect,$query);
?>