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


  $result1['result'] = array();


  //수업 상세 정보 
  $sql = "SELECT User.User_Id, User.U_Email, User.U_Name, User.U_Character, User.U_Active, User.U_Register_Date,
  User_Detail.U_D_Img, User_Detail.U_D_Bday, User_Detail.U_D_Sex, User_Detail.U_D_Contact, User_Detail.U_D_Country,
  User_Detail.U_D_Residence, User_Detail.U_D_Language, User_Detail.U_D_Korean, User_Detail.U_D_T_add, User_Detail.U_D_Intro,
  User_Detail.U_D_Timezone, User_Teacher.U_T_Intro, User_Teacher.U_T_Certificate, User_Teacher.U_T_Agreement, User_Teacher.U_T_Special,
  User_Teacher.U_T_Date FROM HANGLE.User LEFT OUTER JOIN User_Detail
          ON User.User_ID = User_Detail.User_Id
          LEFT OUTER JOIN User_Teacher
          ON User_Teacher.User_Id = User_Detail.User_Id 
        where User.User_Id = {$fusid}";
  $response1 = mysqli_query($conn, $sql);

  $row1 = mysqli_fetch_array($response1);


  $clid = $row1['0'];
  $tusid = $row1['1'];


  $send['User_Id'] = $row1['0'];
  if ($uemail != null) {
  $send['U_Email'] = $row1['1'];}
  if ($uname != null) {
  $send['U_Name'] = $row1['2'];}
  if ($uchar != null) {
  $send['U_Character'] = $row1['3'];}
  if ($uactive != null) {
  $send['U_Active'] = $row1['4'];}
  if ($udate != null) {
  $send['U_Register_Date'] = $row1['5'];}
  if ($udimg != null) {
  $send['U_D_Img'] = $row1['6'];  }
  if ($udbday != null) {
  $send['U_D_Bday'] = $row1['7']; }
   if ($udsex != null) {
  $send['U_D_Sex'] = $row1['8'];  }
  if ($udcon != null) {
  $send['U_D_Contact'] = $row1['9']; }
   if ($udcoun != null) {
  $send['U_D_Country'] = $row1['10']; }
   if ($udresi != null) {
  $send['U_D_Residence'] = $row1['11'];  }
  if ($udlang != null) {
  $send['U_D_Language'] = $row1['12']; }
  if ($udkore != null) {
  $send['U_D_Korean'] = $row1['13']; }
   if ($udtadd != null) {
  $send['U_D_T_add'] = $row1['14'];  }
  if ($udintro != null) {
  $send['U_D_Intro'] = $row1['15']; }
   if ($udtz != null) {
  $send['U_D_Timezone'] = $row1['16'];  }
  if ($utintro != null) {
  $send['U_T_Intro'] = $row1['17'];  }
  if ($utcerti != null) {
  $send['U_T_Certificate'] = $row1['18']; }
   if ($utagree != null) {
  $send['U_T_Agreement'] = $row1['19']; }
   if ($utspec != null) {
  $send['U_T_Special'] = $row1['20']; }
  if ($utdate != null) {
  $send['U_T_Date'] = $row1['21'];}




  array_push($result1['result'], $send);
  echo json_encode($result1);
  mysqli_close($conn);



} else if ($kind == 'ulist') {
  //필요한 값이 fusid 이면  



  $i = 0;

  $start =  $i + (20 * $plus);
  $till = 20;

  $result1['result'] = array();


  //에 수업 목록확인  
  $sql = "SELECT User.User_Id, User.U_Email, User.U_Name, User.U_Character, User.U_Active, User.U_Register_Date,
  User_Detail.U_D_Img, User_Detail.U_D_Bday, User_Detail.U_D_Sex, User_Detail.U_D_Contact, User_Detail.U_D_Country,
  User_Detail.U_D_Residence, User_Detail.U_D_Language, User_Detail.U_D_Korean, User_Detail.U_D_T_add, User_Detail.U_D_Intro,
  User_Detail.U_D_Timezone, User_Teacher.U_T_Intro, User_Teacher.U_T_Certificate, User_Teacher.U_T_Agreement, User_Teacher.U_T_Special,
  User_Teacher.U_T_Date FROM HANGLE.User LEFT OUTER JOIN User_Detail
          ON User.User_ID = User_Detail.User_Id
        LEFT OUTER JOIN User_Teacher
          ON User_Teacher.User_Id = User_Detail.User_Id 
      order by  User_Id DESC LIMIT $start, $till;";

  $response1 = mysqli_query($conn, $sql);

  while ($row1 = mysqli_fetch_array($response1)) {

    $send['User_Id'] = $row1['0'];
    if ($uemail != null) {
    $send['U_Email'] = $row1['1'];}
    if ($uname != null) {
    $send['U_Name'] = $row1['2'];}
    if ($uchar != null) {
    $send['U_Character'] = $row1['3'];}
    if ($uactive != null) {
    $send['U_Active'] = $row1['4'];}
    if ($udate != null) {
    $send['U_Register_Date'] = $row1['5'];}
    if ($udimg != null) {
    $send['U_D_Img'] = $row1['6'];  }
    if ($udbday != null) {
    $send['U_D_Bday'] = $row1['7']; }
     if ($udsex != null) {
    $send['U_D_Sex'] = $row1['8'];  }
    if ($udcon != null) {
    $send['U_D_Contact'] = $row1['9']; }
     if ($udcoun != null) {
    $send['U_D_Country'] = $row1['10']; }
     if ($udresi != null) {
    $send['U_D_Residence'] = $row1['11'];  }
    if ($udlang != null) {
    $send['U_D_Language'] = $row1['12']; }
    if ($udkore != null) {
    $send['U_D_Korean'] = $row1['13']; }
     if ($udtadd != null) {
    $send['U_D_T_add'] = $row1['14'];  }
    if ($udintro != null) {
    $send['U_D_Intro'] = $row1['15']; }
     if ($udtz != null) {
    $send['U_D_Timezone'] = $row1['16'];  }
    if ($utintro != null) {
    $send['U_T_Intro'] = $row1['17'];  }
    if ($utcerti != null) {
    $send['U_T_Certificate'] = $row1['18']; }
     if ($utagree != null) {
    $send['U_T_Agreement'] = $row1['19']; }
     if ($utspec != null) {
    $send['U_T_Special'] = $row1['20']; }
    if ($utdate != null) {
    $send['U_T_Date'] = $row1['21'];}
     
    //  $send['User_Id'] = $row1['0'];
    //  $send['U_Email'] = $row1['1'];
    //  $send['U_Name'] = $row1['2'];
    //  $send['U_Character'] = $row1['3'];
    //  $send['U_Active'] = $row1['4'];
    //  $send['U_Register_Date'] = $row1['5'];
    //  $send['U_D_Img'] = $row1['6'];
    //  $send['U_D_Bday'] = $row1['7'];
    //  $send['U_D_Sex'] = $row1['8'];
    //  $send['U_D_Contact'] = $row1['9'];
    //  $send['U_D_Country'] = $row1['10'];
    //  $send['U_D_Residence'] = $row1['11'];
    //  $send['U_D_Language'] = $row1['12'];
    //  $send['U_D_Korean'] = $row1['13'];
    //  $send['U_D_T_add'] = $row1['14'];
    //  $send['U_D_Intro'] = $row1['15'];
    //  $send['U_D_Timezone'] = $row1['16'];
    //  $send['U_T_Intro'] = $row1['17'];
    //  $send['U_T_Certificate'] = $row1['18'];
    //  $send['U_T_Agreement'] = $row1['19'];
    //  $send['U_T_Special'] = $row1['20'];
    //  $send['U_T_Date'] = $row1['21'];
 


  array_push($result1['result'], $send);

}

$result1["success"] = "1";
echo json_encode($result1);
mysqli_close($conn);

}