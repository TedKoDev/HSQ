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

 uemail  =   user_email (Email)
 uname   =   user_name (이름)
 uchar   =   user_character (메타버스 캐릭터)
 uactive =   user_active (활성화 여부)
 udate   =   user_register_date (최초등록일시)


Table User_Detail.
 udimg   =   user_img (이미지)
 udbday  =   user_birthday (생일)
 udsex   =   user_sex (성별)
 udcon   =   user_contact (연락처)
 udcoun  =   user_country (국적)
 udresi  =   user_residence (거주지)
 udlang  =   user_language (사용가능언어)
 udkore  =   user_korean (한국어수준)
 udtadd  =   teacher_register_check (강사신청여부)
 udintro =   user_intro (자기소개)
 udtz    =   user_timezone (사용자 타임존) 


Table User_Teacher.
 utintro =   teacher_intro (강사 자기소개)
 utcerti =   teacher_certification (자격증정보)
 utagree =   teacher_agreement (강사 허가 여부) 
 utspec  =   teacher_special (전문가 여부 ) 
 utdate  =   teacher_register_date (강사 신청일) 

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
$fusid         =   json_decode(file_get_contents("php://input"))->{"user_id"}; // 
// $fusid         =   324; // 
// $fusid         =   4; // 필요 정보 종류 
//ulist    유저리스트 
//udetail  유저 상세 (검색할 user_id가 필요함  fusid ) 


//====================================================================================================

// 필요한 아래의 항목에 (아무런) 값을 넣어 보내줘야 출력됨.  



$uemail       =   json_decode(file_get_contents("php://input"))->{"user_email"};   // user_email (Email)
$uname        =   json_decode(file_get_contents("php://input"))->{"user_name"};    // user_name (이름)
$uchar        =   json_decode(file_get_contents("php://input"))->{"user_character"};    // user_character (메타버스 캐릭터)
$uactive      =   json_decode(file_get_contents("php://input"))->{"user_active"};  // user_active (활성화 여부)
$udate        =   json_decode(file_get_contents("php://input"))->{"user_register_date"};    // user_register_date (최초등록일시)

$udimg        =   json_decode(file_get_contents("php://input"))->{"user_img"};    // user_img (이미지)
$udbday       =   json_decode(file_get_contents("php://input"))->{"user_birthday"};   // user_birthday (생일)
$udsex        =   json_decode(file_get_contents("php://input"))->{"user_sex"};    // user_sex (성별)
$udcon        =   json_decode(file_get_contents("php://input"))->{"user_contract"};    // user_contact (연락처)
$udcoun       =   json_decode(file_get_contents("php://input"))->{"user_country"};   // user_country (국적)
$udresi       =   json_decode(file_get_contents("php://input"))->{"user_residence"};   // user_residence (거주지)
$udlang       =   json_decode(file_get_contents("php://input"))->{"user_language"};   // user_language (사용가능언어)
$udkore       =   json_decode(file_get_contents("php://input"))->{"user_korean"};   // user_korean (한국어수준)
$udtadd       =   json_decode(file_get_contents("php://input"))->{"teacher_register_check"};   // teacher_register_check (강사신청여부)
$udintro      =   json_decode(file_get_contents("php://input"))->{"user_intro"};  // user_intro (자기소개)
$udtz         =   json_decode(file_get_contents("php://input"))->{"user_timezone"};     // user_timezone (사용자 타임존) 

$utintro      =   json_decode(file_get_contents("php://input"))->{"teacher_intro"};  // teacher_intro (강사 자기소개)
$utcerti      =   json_decode(file_get_contents("php://input"))->{"teacher_certification"};  // teacher_certification (자격증정보)
$utagree      =   json_decode(file_get_contents("php://input"))->{"teacher_agreement"};   // teacher_agreement (강사 허가 여부) 
$utspec       =   json_decode(file_get_contents("php://input"))->{"teacher_special"};   // teacher_special (전문가 여부 ) 
$utdate       =   json_decode(file_get_contents("php://input"))->{"teacher_register_date"};   // teacher_register_date (강사 신청일) 



$plus          =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 







// 수업상세 출력인지 목록 출력인지 
if ($kind == 'udetail') {
  //해당 fusid (찾고자하는 유저) 해당하는 상세정보를 가져옴 



  $list = array();
  array_push($list, 'User.user_id');

  if ($uemail != null) {
    array_push($list, 'User.user_email');
  }
  if ($uname != null) {
    array_push($list, 'User.user_name');
  }
  if ($uchar != null) {
    array_push($list, 'User.user_character');
  }
  if ($uactive != null) {
    array_push($list, 'User.user_active');
  }
  if ($udate != null) {
    array_push($list, 'User.user_register_date');
  }
  if ($udimg != null) {
    array_push($list, 'User_Detail.user_img');
  }
  if ($udbday != null) {
    array_push($list, 'User_Detail.user_birthday');
  }
  if ($udsex != null) {
    array_push($list, 'User_Detail.user_sex');
  }
  if ($udcon != null) {
    array_push($list, 'User_Detail.user_contact');
  }
  if ($udcoun != null) {
    array_push($list, 'User_Detail.user_country');
  }
  if ($udresi != null) {
    array_push($list, 'User_Detail.user_residence');
  }
  if ($udlang != null) {
    array_push($list, 'User_Detail.user_language');
  }
  if ($udkore != null) {
    array_push($list, 'User_Detail.user_korean');
  }
  if ($udtadd != null) {
    array_push($list, 'User_Detail.teacher_register_check');
  }
  if ($udintro != null) {
    array_push($list, 'User_Detail.user_intro');
  }
  if ($udtz != null) {
    array_push($list, 'User_Detail.user_timezone');
  }
  if ($utintro != null) {
    array_push($list, 'User_Teacher.teacher_intro');
  }
  if ($utcerti != null) {
    array_push($list, 'User_Teacher.teacher_certification');
  }
  if ($utagree != null) {
    array_push($list, 'User_Teacher.teacher_agreement');
  }
  if ($utspec != null) {
    array_push($list, 'User_Teacher.teacher_special');
  }
  if ($utdate != null) {
    array_push($list, 'User_Teacher.teacher_register_date');
  }


  $string = implode(",", $list);



  $result1['result'] = array();


  //수업 상세 정보 
  $sql = "SELECT * FROM HANGLE.User LEFT OUTER JOIN User_Detail
          ON User.user_id = User_Detail.user_id
          LEFT OUTER JOIN User_Teacher
          ON User_Teacher.user_id = User_Detail.user_id 
        where User.user_id = {$fusid}";
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
} else if ($kind == 'ulist') {
  //필요한 값이 fusid 이면  



  $i = 0;

  $start =  $i + (20 * $plus);
  $till = 20;


  $list = array();
  array_push($list, 'User.user_id');

  if ($uemail != null) {
    array_push($list, 'User.user_email');
  }
  if ($uname != null) {
    array_push($list, 'User.user_name');
  }
  if ($uchar != null) {
    array_push($list, 'User.user_character');
  }
  if ($uactive != null) {
    array_push($list, 'User.user_active');
  }
  if ($udate != null) {
    array_push($list, 'User.user_register_date');
  }
  if ($udimg != null) {
    array_push($list, 'User_Detail.user_img');
  }
  if ($udbday != null) {
    array_push($list, 'User_Detail.user_birthday');
  }
  if ($udsex != null) {
    array_push($list, 'User_Detail.user_sex');
  }
  if ($udcon != null) {
    array_push($list, 'User_Detail.user_contact');
  }
  if ($udcoun != null) {
    array_push($list, 'User_Detail.user_country');
  }
  if ($udresi != null) {
    array_push($list, 'User_Detail.user_residence');
  }
  if ($udlang != null) {
    array_push($list, 'User_Detail.user_language');
  }
  if ($udkore != null) {
    array_push($list, 'User_Detail.user_korean');
  }
  if ($udtadd != null) {
    array_push($list, 'User_Detail.teacher_register_check');
  }
  if ($udintro != null) {
    array_push($list, 'User_Detail.user_intro');
  }
  if ($udtz != null) {
    array_push($list, 'User_Detail.user_timezone');
  }
  if ($utintro != null) {
    array_push($list, 'User_Teacher.teacher_intro');
  }
  if ($utcerti != null) {
    array_push($list, 'User_Teacher.teacher_certification');
  }
  if ($utagree != null) {
    array_push($list, 'User_Teacher.teacher_agreement');
  }
  if ($utspec != null) {
    array_push($list, 'User_Teacher.teacher_special');
  }
  if ($utdate != null) {
    array_push($list, 'User_Teacher.teacher_register_date');
  }

  $string = implode(",", $list);

  $result1['result'] = array();


  //에 수업 목록확인  
  $sql = "SELECT * FROM HANGLE.User LEFT OUTER JOIN User_Detail
          ON User.user_id = User_Detail.user_id
        LEFT OUTER JOIN User_Teacher
          ON User_Teacher.user_id = User_Detail.user_id 
      order by  user_id DESC LIMIT $start, $till;";

  $response1 = mysqli_query($conn, $sql);

  foreach ($response1 as $key) {

    array_push($result1['result'], $key);
  }
  // echo json_encode($result4);




  $result1["success"] = "1";
  echo json_encode($result1);
  mysqli_close($conn);
}
