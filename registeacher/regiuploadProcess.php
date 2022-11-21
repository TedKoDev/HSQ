<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );
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

// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$p_img = json_decode(file_get_contents("php://input"))->{"p_img"}; //항목
$name = json_decode(file_get_contents("php://input"))->{"name"}; //항목
$language = json_decode(file_get_contents("php://input"))->{"language"}; //항목
$country = json_decode(file_get_contents("php://input"))->{"country"}; //항목
$residence = json_decode(file_get_contents("php://input"))->{"residence"}; //항목
$tintro = json_decode(file_get_contents("php://input"))->{"tintro"}; //항목
$certi = json_decode(file_get_contents("php://input"))->{"certi"}; //항목
$file = json_decode(file_get_contents("php://input"))->{"file"}; //항목



date_default_timezone_set('Asia/Seoul');
$time_now = date("Y-m-d H:i:s");

// error_log("$time_now, $position, $desc\n", "3", "../php.log");



//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

//ar_dump($payload);


$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);




//이름
    $select = "UPDATE User SET U_Name = '$name' where User_Id = '$User_ID' ";
    $result1 = mysqli_query($conn, $select);

    
    if ($result1) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "name";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "name";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }
//이미지 
    //인스턴스내 www/html/image 폴더 내에 이미지 저장됨 (임시 추후 S3로 변경할 예정)
    // image 저장되는 루트 
    $saveroot = "image"; // 저장되는 루트 
    $imagestore = rand() . "_" . time() . ".jpeg";
    $saveroot = $saveroot . "/" . $imagestore;
    file_put_contents($saveroot, base64_decode($p_img));

    $select = "UPDATE User_Detail SET U_D_Img = '$imagestore' where User_Id = '$User_ID' ";
    $result2 = mysqli_query($conn, $select);

    if ($result2) { //정상적으로 이미지 저장되었을때 
        $send["position"]   =  "image";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "image";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }

//국가
    $select = "UPDATE User_Detail SET U_D_Country = '$country' where User_Id = '$User_ID' ";
    $result3 = mysqli_query($conn, $select);

    if ($result3) { //정상적으로 이미지 저장되었을때 
        $send["position"]   =  "country";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "country";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }


//거주지   
    $select = "UPDATE User_Detail SET U_D_Residence = '$desc' where User_Id = '$User_ID' ";
    $result4 = mysqli_query($conn, $select);
    if ($result4) { //정상적으로 이미지 저장되었을때 
        $send["position"]   =  "residence";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "residence";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }

 

//언어
    $select = "UPDATE User_Detail SET U_D_Language = '$language' where User_Id = '$User_ID' ";
    $result5 = mysqli_query($conn, $select);

    if ($result5) { //정상적으로 언어 저장되었을때 
        $send["position"]   =  "language";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "language";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }

//강사-자기소개
    $select = "UPDATE User_Teacher SET U_T_Intro = '$tintro' where User_Id = '$User_ID' ";
    $result6 = mysqli_query($conn, $select);
    
    if ($result6) { //정상적으로 자기소개 저장되었을때 
        $send["position"]   =  "tintro";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "tintro";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }


//자격증
    $select = "UPDATE User_Teacher SET U_T_Certificate = '$certi' where User_Id = '$User_ID' ";
    $result7 = mysqli_query($conn, $select);

    if ($result7) { //정상적으로 자격증 저장되었을때 
        $send["position"]   =  "certi";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "certi";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }


//첨부파일 
     date_default_timezone_set('Asia/Seoul');
     $time_now = date("Y-m-d H:i:s");
    
     $uploaded_file_name_tmp = $_FILES[ 'myfile' ][ 'tmp_name' ];
     $uploaded_file_name = "$User_ID" . $time_now .$file; 
     $upload_folder = "uploads/";
     move_uploaded_file( $uploaded_file_name_tmp, $upload_folder . $uploaded_file_name );
    
     
    
     $select = "UPDATE User_Teacher SET U_T_Intro = '$uploaded_file_name' where User_Id = '$User_ID' ";  
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