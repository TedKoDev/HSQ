<?php

// == regisupload 프로세스==
//   #요구되는 파라미터 (fetch형태 json 형태로 요청 ) 
//1. 토큰값  - token 
//2. 강사자기소개 - tintro 
//3. 자격증설명 - certi
//3. 첨부파일이름  - file


# 보낼 줄 때 형태 
// {
//  "token" : "토큰값 "
//  "tintro" : "강사자기소개 "
//  "certi" : "자격증설명 "
//  "file" : "첨부파일이름 "
// }

// 완료시 User_Detail 내 U_D_T_add 부분이 yes로 변경됨 (강사등록 완료 )





include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값 전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"};
$tintro = json_decode(file_get_contents("php://input"))->{"tintro"};
$certi = json_decode(file_get_contents("php://input"))->{"certi"};
$filename = json_decode(file_get_contents("php://input"))->{"filename"};



// 토큰값 받는곳 


//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);



// User_ID값 얻음 
$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);

// error_log("'1!!!!! User_ID  ',$U_Name, 	$User_ID\n", "3", "../php.log");

// U_D에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM User_Teacher where User_Id = '$User_ID'";
$checkresult = mysqli_query($conn, $check);

// error_log("$time_now,'ddd', $User_ID, $U_Name, $U_Email \n", "3", "/php.log");

// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows < 1) {


	// 중복값이 없을때 때 실행할 내용
	// 없으면 insert로  data 만들고  
	$result = "INSERT INTO User_Teacher (User_Id) VALUES ('$User_ID') ";
	$insert = mysqli_query($conn, $result);

}

$check1 = 0; // 강사자기소개 및 다른 데이터 저장 완료시   yes =1 no = 0







//강사-자기소개
//파일설명 (자격증설명)
//첨부파일 
$select = "UPDATE User_Teacher SET U_T_Intro = '$tintro', U_T_Certificate = '$certi' ,U_T_FILE = '$filename' where User_Id = '$User_ID' ";
$result6 = mysqli_query($conn, $select);

if ($result6) { //정상적으로 자기소개 저장되었을때 
  
    $send["success"]   =  "yes";
    echo json_encode($send);
    $check1 = 1 ;
} else {

    $send["success"]   =  "no";
    echo json_encode($send);
   
}






//강사등록완료 부분 

if($check1 = 1 ){
    $select = "UPDATE User_Detail SET U_D_T_add = 'yes' where User_Id = '$User_ID'";  
    $result9 = mysqli_query($conn, $select);

    
    $send["tadd"]   =  "yes";
    echo json_encode( $send);
 
}else {

    $send["tadd"]   =  "no";
    echo json_encode( $send);
}