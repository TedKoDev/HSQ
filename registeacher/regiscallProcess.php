<?php
// == 강사등록시 최초 화면출력 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값  - token 



// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".

// }


//반환시 
// {
//   "userid": "33",
//   "name": "haein1",
//   "p_img": "default",
//   "bday": "default",
//   "sex": "default",
//   "country": "default",
//   "residence": "default",
//   "language": "default",
//   "tintro": "default",
//   "certi": "default",
//   "file": "default"
// }

//항목 
//이미지     -  "p_img"   
//이름       -  "name"
//생일       -  "bday"
//성별       -  "sex"
//연락처     -  "contact"
//국가       -  "country"
//거주지     -  "residence"
//가능언어   - "language" 
//한국어수준 -  "korean"
//강사자기소개   -  "tintro"
//자격증내역    - "certi"
//첨부파일     - "file"




include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 




date_default_timezone_set('Asia/Seoul');
$time_now = date("Y-m-d H:i:s");

// error_log("$time_now, $position, $desc\n", "3", "../php.log");



//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

//ar_dump($payload);


$User_ID =  base64_decode($payload['User_ID']);
// $User_ID = '33';

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);





// U_T에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM User_Teacher where User_Id = '$User_ID'";
$checkresult = mysqli_query($conn, $check);

error_log("$time_now,'ddd', $User_ID, $U_Name, $U_Email \n", "3", "/php.log");



// U_T에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows <1) {
    date_default_timezone_set('Asia/Seoul');
    $time_now = date("Y-m-d H:i:s");
    
    error_log("$time_now, 's'\n", "3", "../php.log");
    
    // 중복값이 없을때 때 실행할 내용
    // 없으면 insert로  data 만들고  
    // 아래의 update로 data 삽입 
    $result = "INSERT INTO User_Teacher (User_Id) VALUES ('$User_ID') ";
    $insert = mysqli_query($conn, $result);

}

// 있으면 시작 

// 값 불러 오기  
//2중 left join 으로  User 테이블, User_Detail 테이블, User_Teacher 테이블에서 필요 항목값을 토큰으로 부터 받은 User_ID 값을 기준으로 불러옴 



$select = "SELECT
User.User_ID, User.U_Name, User_Detail.U_D_Img, User_Detail.U_D_Bday,User_Detail.U_D_Sex, User_Detail.U_D_Country, User_Detail.U_D_Residence , User_Detail.U_D_Language , User_Teacher.U_T_Intro, User_Teacher.U_T_Certificate, User_Teacher.U_T_File
FROM User
JOIN User_Detail
  ON User.User_ID = User_Detail.User_Id
JOIN User_Teacher
  ON User_Teacher.User_Id = User_Detail.User_Id where User.User_Id = '$User_ID' ";

$result = mysqli_query($conn, $select);
$row = mysqli_fetch_array($result);


// 값 변수 설정 
 $userid      = $row['User_ID'];
 $name        = $row['U_Name'];
 $p_img       = $row['U_D_Img'];
 $bday       = $row['U_D_Bday'];
 $sex       = $row['U_D_Sex'];
 $country     = $row['U_D_Country'];
 $residence   = $row['U_D_Residence'];
 $language    = $row['U_D_Language'];
 $tintro    = $row['U_T_Intro'];
 $certi      = $row['U_T_Certificate'];
 $file     = $row['U_T_File'];



 $send["userid"]   =  $userid   ;
 $send["name"]   =  $name     ;
 $send["p_img"]   =  $p_img    ;
 $send["bday"]   =  $bday    ;
 $send["sex"]   =  $sex    ;
 $send["country"]   =  $country  ;
 $send["residence"]   =  $residence  ;
 $send["language"]   =  $language ;
 $send["tintro"]   =  $tintro  ;
 $send["certi"]   =  $certi  ;
 $send["file"]   =  $file  ;



 echo json_encode($send);
 mysqli_close($conn);






