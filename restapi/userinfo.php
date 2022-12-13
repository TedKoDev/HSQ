<?php

/***
유저정보  RestAPI
userinfo.php

분기 조건 
1. 얻고자하는 list의 종류를 kind에 담아 보낸다 

// 유저목록        : kind = 'ulist' 
1-1. 필요 항목 값넣기
// 유저상세        : kind = 'udetail'    
1-2. 필요 항목 값넣기

2. 항목 별 값이 있다/없다. 
항목종류: 
Table User. 

 uemail  =   U_Email (Email)
 uname   =   U_Name (이름)
 uchar   =   U_Character (메타버스 캐릭터)
 uactive =   U_Active (활성화 여부)
 udate   =   U_Register_Date (최초등록일시)


Table User_Detail.
 udimg   =   U_D_Img (이미지)
 udbday  =   U_D_Bday (생일)
 udsex   =   U_D_Sex (성별)
 udcon   =   U_D_Contact (연락처)
 udcoun  =   U_D_Country (국적)
 udresi  =   U_D_Residence (거주지)
 udlang  =   U_D_Language (사용가능언어)
 udkore  =   U_D_Korean (한국어수준)
 udtadd  =   U_D_T_add (강사신청여부)
 udintro =   U_D_Intro (자기소개)
 udtz    =   U_D_Timezone (사용자 타임존) 


Table User_Teacher.
 utintro =   U_T_Intro (강사 자기소개)
 utcerti =   U_T_Certificate (자격증정보)
 utagree =   U_T_Agreement (강사 허가 여부) 
 utspec  =   U_T_Special (전문가 여부 ) 
 utdate  =   U_T_Date (강사 신청일) 

*/


include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";




# 필요값 
// 어떤 내용이 필요한지를 표시 ( clist-수업목록, cdetail-수업상세, tclist-강사의 수업목록)
$kind          =   json_decode(file_get_contents("php://input"))->{"kind"}; // 필요 정보 종류 
// $kind          =  'ulist'; // 필요 정보 종류 
// $kind          =  'udetail'; // 필요 정보 종류 
$fusid         =   json_decode(file_get_contents("php://input"))->{"fusid"}; // 필요 정보 종류 
// $fusid         =   4; // 필요 정보 종류 
//ulist    유저리스트 
//udetail  유저 상세 (검색할 user_id가 필요함  fusid ) 


//====================================================================================================

// 필요한 아래의 항목에 (아무런) 값을 넣어 보내줘야 출력됨.  



$uemail       =   json_decode(file_get_contents("php://input"))->{"uemail"};   // U_Email (Email)
$uname        =   json_decode(file_get_contents("php://input"))->{"uname"};    // U_Name (이름)
$uchar        =   json_decode(file_get_contents("php://input"))->{"uchar"};    // U_Character (메타버스 캐릭터)
$uactive      =   json_decode(file_get_contents("php://input"))->{"uactive"};  // U_Active (활성화 여부)
$udate        =   json_decode(file_get_contents("php://input"))->{"udate"};    // U_Register_Date (최초등록일시)

$udimg        =   json_decode(file_get_contents("php://input"))->{"udimg"};    // U_D_Img (이미지)
$udbday       =   json_decode(file_get_contents("php://input"))->{"udbday"};   // U_D_Bday (생일)
$udsex        =   json_decode(file_get_contents("php://input"))->{"udsex"};    // U_D_Sex (성별)
$udcon        =   json_decode(file_get_contents("php://input"))->{"udcon"};    // U_D_Contact (연락처)
$udcoun       =   json_decode(file_get_contents("php://input"))->{"udcoun"};   // U_D_Country (국적)
$udresi       =   json_decode(file_get_contents("php://input"))->{"udresi"};   // U_D_Residence (거주지)
$udlang       =   json_decode(file_get_contents("php://input"))->{"udlang"};   // U_D_Language (사용가능언어)
$udkore       =   json_decode(file_get_contents("php://input"))->{"udkore"};   // U_D_Korean (한국어수준)
$udtadd       =   json_decode(file_get_contents("php://input"))->{"udtadd"};   // U_D_T_add (강사신청여부)
$udintro      =   json_decode(file_get_contents("php://input"))->{"udintro"};  // U_D_Intro (자기소개)
$udtz         =   json_decode(file_get_contents("php://input"))->{"udtz"};     // U_D_Timezone (사용자 타임존) 

$utintro      =   json_decode(file_get_contents("php://input"))->{"utintro"};  // U_T_Intro (강사 자기소개)
$utcerti      =   json_decode(file_get_contents("php://input"))->{"utcerti"};  // U_T_Certificate (자격증정보)
$utagree      =   json_decode(file_get_contents("php://input"))->{"utspec"};   // U_T_Agreement (강사 허가 여부) 
$utspec       =   json_decode(file_get_contents("php://input"))->{"utdate"};   // U_T_Special (전문가 여부 ) 
$utdate       =   json_decode(file_get_contents("php://input"))->{"utdate"};   // U_T_Date (강사 신청일) 

// $uemail       =  1;  // U_Email (Email)
// $uname        =  1;  // U_Name (이름)
// $uchar        =  1;  // U_Character (메타버스 캐릭터)
// $uactive      =  1;  // U_Active (활성화 여부)
// $udate        =  1;  // U_Register_Date (최초등록일시)

// $udimg        =  1;  // U_D_Img (이미지)
// $udbday       =  1;  // U_D_Bday (생일)
// $udsex        =  1;  // U_D_Sex (성별)
// $udcon        =  1;  // U_D_Contact (연락처)
// $udcoun       =  1;  // U_D_Country (국적)
// $udresi       =  1;  // U_D_Residence (거주지)
// $udlang       =  1;  // U_D_Language (사용가능언어)
// $udkore       =  1;  // U_D_Korean (한국어수준)
// $udtadd       =  1;  // U_D_T_add (강사신청여부)
// $udintro      =  1;  // U_D_Intro (자기소개)
// $udtz         =  1;  // U_D_Timezone (사용자 타임존) 

// $utintro      =  1;  // U_T_Intro (강사 자기소개)
// $utcerti      =  1;  // U_T_Certificate (자격증정보)
// $utagree      =  1;  // U_T_Agreement (강사 허가 여부) 
// $utspec       =  1;  // U_T_Special (전문가 여부 ) 
// $utdate       =  1;  // U_T_Date (강사 신청일) 






$plus          =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 







// 수업상세 출력인지 목록 출력인지 
if ($kind == 'udetail') {
  //해당 fusid (찾고자하는 유저) 해당하는 상세정보를 가져옴 



  $list = array();
     array_push($list, 'User.User_Id');
 
  if ($uemail != null) {
    array_push($list, 'User.U_Email');
  }
  if ($uname != null) {
    array_push($list, 'User.U_Name');
  }
  if ($uchar != null) {
    array_push($list, 'User.U_Character');
  }
  if ($uactive != null) {
    array_push($list, 'User.U_Active');
  }
   if ($udate != null) {
    array_push($list, 'User.U_Register_Date');
  }
   if ($udimg != null) {
    array_push($list, 'User_Detail.U_D_Img');
  }
   if ($udbday != null) {
    array_push($list, 'User_Detail.U_D_Bday');
  }
   if ($udsex != null) {
    array_push($list, 'User_Detail.U_D_Sex');
  }
   if ($udcon != null) {
    array_push($list, 'User_Detail.U_D_Contact');
  }
   if ($udcoun != null) {
    array_push($list, 'User_Detail.U_D_Country');
  }
   if ($udresi != null) {
    array_push($list, 'User_Detail.U_D_Residence');
  }
   if ($udlang != null) {
    array_push($list, 'User_Detail.U_D_Language');
  }
   if ($udkore != null) {
    array_push($list, 'User_Detail.U_D_Korean');
  }
   if ($udtadd != null) {
    array_push($list, 'User_Detail.U_D_T_add');
  }
   if ($udintro != null) {
    array_push($list, 'User_Detail.U_D_Intro');
  }
   if ($udtz != null) {
    array_push($list, 'User_Detail.U_D_Timezone');
  }
   if ($utintro != null) {
    array_push($list, 'User_Teacher.U_T_Intro');
  }
   if ($utcerti != null) {
    array_push($list, 'User_Teacher.U_T_Certificate');
  }
   if ($utagree != null) {
    array_push($list, 'User_Teacher.U_T_Agreement');
  }
   if ($utspec != null) {
    array_push($list, 'User_Teacher.U_T_Special');
  }
   if ($utdate != null) {
    array_push($list, 'User_Teacher.U_T_Date');
  }
 

  $string = implode(",", $list);



  $result1['result'] = array();


  //수업 상세 정보 
  $sql = "SELECT $string FROM HANGLE.User LEFT OUTER JOIN User_Detail
          ON User.User_ID = User_Detail.User_Id
          LEFT OUTER JOIN User_Teacher
          ON User_Teacher.User_Id = User_Detail.User_Id 
        where User.User_Id = {$fusid}";
  $response1 = mysqli_query($conn, $sql);



  
  $row1 = mysqli_fetch_array($response1);


  foreach ($response1 as $key) {
      
  
    // echo key($key); // 키
    // echo current($key); // 값
    // $clid = current($key); // 값
   
      array_push($result1['result'], $key);
  }



  echo json_encode($result1);
  mysqli_close($conn);



}  else if ($kind == 'ulist') {
  //필요한 값이 fusid 이면  



  $i = 0;

  $start =  $i + (20 * $plus);
  $till = 20;


  $list = array();
     array_push($list, 'User.User_Id');
 
  if ($uemail != null) {
    array_push($list, 'User.U_Email');
  }
  if ($uname != null) {
    array_push($list, 'User.U_Name');
  }
  if ($uchar != null) {
    array_push($list, 'User.U_Character');
  }
  if ($uactive != null) {
    array_push($list, 'User.U_Active');
  }
   if ($udate != null) {
    array_push($list, 'User.U_Register_Date');
  }
   if ($udimg != null) {
    array_push($list, 'User_Detail.U_D_Img');
  }
   if ($udbday != null) {
    array_push($list, 'User_Detail.U_D_Bday');
  }
   if ($udsex != null) {
    array_push($list, 'User_Detail.U_D_Sex');
  }
   if ($udcon != null) {
    array_push($list, 'User_Detail.U_D_Contact');
  }
   if ($udcoun != null) {
    array_push($list, 'User_Detail.U_D_Country');
  }
   if ($udresi != null) {
    array_push($list, 'User_Detail.U_D_Residence');
  }
   if ($udlang != null) {
    array_push($list, 'User_Detail.U_D_Language');
  }
   if ($udkore != null) {
    array_push($list, 'User_Detail.U_D_Korean');
  }
   if ($udtadd != null) {
    array_push($list, 'User_Detail.U_D_T_add');
  }
   if ($udintro != null) {
    array_push($list, 'User_Detail.U_D_Intro');
  }
   if ($udtz != null) {
    array_push($list, 'User_Detail.U_D_Timezone');
  }
   if ($utintro != null) {
    array_push($list, 'User_Teacher.U_T_Intro');
  }
   if ($utcerti != null) {
    array_push($list, 'User_Teacher.U_T_Certificate');
  }
   if ($utagree != null) {
    array_push($list, 'User_Teacher.U_T_Agreement');
  }
   if ($utspec != null) {
    array_push($list, 'User_Teacher.U_T_Special');
  }
   if ($utdate != null) {
    array_push($list, 'User_Teacher.U_T_Date');
  }
 
  $string = implode(",", $list);

  $result1['result'] = array();


  //에 수업 목록확인  
  $sql = "SELECT $string FROM HANGLE.User LEFT OUTER JOIN User_Detail
          ON User.User_ID = User_Detail.User_Id
        LEFT OUTER JOIN User_Teacher
          ON User_Teacher.User_Id = User_Detail.User_Id 
      order by  User_Id DESC LIMIT $start, $till;";

  $response1 = mysqli_query($conn, $sql);

  foreach ($response1 as $key) {
  
    array_push($result1['result'], $key);
  }
  // echo json_encode($result4);




$result1["success"] = "1";
echo json_encode($result1);
mysqli_close($conn);

}