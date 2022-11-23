<?php

// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
// == 강사등록 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값  - token 
//2. 항목    - p_img 
//3. 내용    - name
//3. 언어    - language
//3. 국가    - country
//3. 거주지    - residence
//3. 강사자기소개    - tintro
//3. 자격증여부    - certi
//3. 첨부파일     - file


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "name"     : "이름" 
//  "p_img" : "이미지"
//  "country"     : "국적" 
//  "residence"     : "거주지"
//  "language"     : "언어"  
//  "tintro"     : "강사자기소개" 
//  "certi"     : "자격증내역" 
//  "file"     : "첨부파일" 
// }






include("../conn.php");
include("../jwt.php");


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

error_log("'1!!!!! User_ID  ',$U_Name, 	$User_ID\n", "3", "../php.log");

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
	//   $send["message"] = "no";
	//   $send["message"] = "no";

	// echo json_encode($send);
	// mysqli_close($conn);
}

$check1 = 0; // 강사자기소개 저장  yes =1 no = 0
$check2 = 0; // 파일설명 저장 yes =1 no = 0



//formdata로 받은 이미지 받는곳 
if (isset($_POST['tintro'])) {
    $tintro = $_POST['tintro'];
    error_log("'1!!!!! intro  ',$tintro\n", "3", "../php.log");
//강사-자기소개
$select = "UPDATE User_Teacher SET U_T_Intro = '$tintro' where User_Id = '$User_ID' ";
$result6 = mysqli_query($conn, $select);

if ($result6) { //정상적으로 자기소개 저장되었을때 
    $send["position"]   =  $tintro;
    $send["success"]   =  "yes";
    echo json_encode($send);
    $check1 = 1 ;
} else {
    $send["position"]   =  "tintro";
    $send["success"]   =  "no";
    echo json_encode($send);
   
}
}




//파일설명 (자격증설명)

if (isset($_POST['certi'])) {


    $select = "UPDATE User_Teacher SET U_T_Certificate = '$certi' where User_Id = '$User_ID' ";
    $result7 = mysqli_query($conn, $select);

    if ($result7) { //정상적으로 자격증 저장되었을때 
        $send["position"]   =  "certi";
        $send["success"]   =  "yes";
        echo json_encode($send);
        $check2 = 1; 
    } else {
        $send["position"]   =  "certi";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }
 }
    



  


//첨부파일 

if (isset($_FILES['file'])) {
   
    if (!empty($_FILES['img']['name'][0])) {
        
        $zip = new ZipArchive();
        $zip_time = time();
        $zip_name1 = getcwd() . "/uploads/USER_" . $zip_time . ".zip";
        $zip_name2 = "USER_" . $zip_time . ".zip";
        
        // Create a zip target
        if ($zip->open($zip_name1, ZipArchive::CREATE) !== TRUE) {
            $error .= "Sorry ZIP creation is not working currently.<br/>";
        }
        
        $imageCount = count($_FILES['img']['name']);
        for($i=0;$i<$imageCount;$i++) {
        
            if ($_FILES['img']['tmp_name'][$i] == '') {
                continue;
            }
            // $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
            
            // Moving files to zip.
            $zip->addFromString($_FILES['img']['name'][$i], file_get_contents($_FILES['img']['tmp_name'][$i]));
            
            // // moving files to the target folder.
            // move_uploaded_file($_FILES['img']['tmp_name'][$i], './uploads/' . $newname);
        }
        $zip->close();
        
        // Create HTML Link option to download zip
        // $success = basename($zip_name1);
    } else {
        $error = '<strong>Error!! </strong> Please select a file.';
    }

    
    $select = "UPDATE User_Teacher SET U_T_FILE = '$zip_name2' where User_Id = '$User_ID'";  
    $result8 = mysqli_query($conn, $select);
      
    
   
    if ($result8) { //정상적으로 파일 저장되었을때 
        $send["position"]   =  "file";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "file";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }


 }
    



//강사 전환 부분 

if($check1 = 1 && $check2 =1 ){
    $select = "UPDATE User_Detail SET U_D_T_add = 'yes' where User_Id = '$User_ID'";  
    $result9 = mysqli_query($conn, $select);

    
    $send["tadd"]   =  "yes";
    echo json_encode( $send);
 
}else {

    $send["tadd"]   =  "no";
    echo json_encode( $send);
}