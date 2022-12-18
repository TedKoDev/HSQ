<?php

/***

수업정보  RestAPI
classinfo.php

분기 조건 
1. 얻고자하는 list의 종류를 kind에 담아 보낸다 
 ( clist-수업목록, cdetail-수업상세, tclist-강사의 수업목록)
// 수업목록        : kind = 'clist' 
// 수업상세        : kind = 'cdetail'    
// 강사의 수업목록  : kind = 'tclist'


2. 예약된 수업의 리스트 또는 상세 페이지  
$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"clReserveCheck"}; // 예약된 수업 리스트 / 상세 

-리스트의 경우 value = all, approved, cancel  ,done ,review
-상세의 경우  value = cdetail  와   
    $class_register_id       =   json_decode(file_get_contents("php://input"))->{"class_register_id"}; // 예약한 수업 번호 
    "class_register_id"(key) = 137(value) 값 이 필요함 ; // 예약한 수업 번호  






출력정보  


1. 수업상세  (수업명, 수업내용, 수업유형, 수업 레벨, 수업 가격)

2. 수업목록  (수업명, 및 기타 정보 + 수업오픈한 강사의 정보(이름,이미지 )   + plus 가 있는경우 페이징 동작함)
{"class_name"};   // 수업이름 
{"class_description"};   // 수업설명 
{"class_people"}; // 수업인원 
{"class_type"};   // 수업유형 
{"class_level"};  // 수업레벨 
{"class_time"};   // 수업시간
{"class_price"};  // 수업가격
{"teacher_img"};     // 강사이미지
{"teacher_name"};    // 강사이름
{"plus"};     // 더보기 

3. 특정 강사의 수업목록 

 
 */


include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 

//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //학생의 userid
// $User_ID = 320; //학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone



# 필요값 
// 어떤 내용이 필요한지를 표시 ( clist-수업목록, cdetail-수업상세, tclist-강사의 수업목록)
$kind          =   json_decode(file_get_contents("php://input"))->{"kind"}; // 
$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; // 예약된 수업 리스트 / 상세 




$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; // 예약된 수업 리스트 / 상세 

$filter_class_name                 =   json_decode(file_get_contents("php://input"))->  {"filter_class_name"}; // 수업 이름 검색 필터 
$filter_user_name                 =   json_decode(file_get_contents("php://input"))->   {"filter_user_name"}; // 학생 이름 검색 필터 
$filter_class_resister_time_from     =   json_decode(file_get_contents("php://input"))->{"filter_class_resister_time_from"}; //날짜 시작 시점 필터 
$filter_class_resister_time_to     =   json_decode(file_get_contents("php://input"))->  {"filter_class_resister_time_to"}; //날짜 종료 시점 필터 


// filter_class_resister_time_from
// filter_class_resister_time_to



 



// error_log("$kind ,   $clReserveCheck,  $User_ID \n", "3", "../php.log");


// $kind            =   'clist';         //  
// $kind            =   'cdetail';       //  
// $clReserveCheck  =   'detail';       // 예약된 수업 상세 페이지 

// $kind          =   'tcdetail';      // 
// $clReserveCheck  =  'all';          // 
// $clReserveCheck  =  'approved';     // 
// $clReserveCheck  =  'wait'; // 
// $clReserveCheck  =  'done';         // 
// $clReserveCheck  =  'review';        // 


// $kind          =   'cdetail'; // 강사의 User_id 
// 수업목록        : kind = clist 
// 수업상세        : kind = cdetail    
// 예약체크        : kind = clReserveCheck    // 전체 목록 또는 상세 정보 
// 예약체크 필요값 : value = all, approved, not_approved  ,done ,review
// value : 
// 1. all (해당 유저가 예약/완료한 모든 수업)
// 2. approved (예약 승인 되었지만 아직 수강은 안한 수업)
// 3. not_approved (예약 신청은 했는데 강사가 아직 예약 승인은 안한 수업)
// 4. done (완료한 수업) 






// 필요한 class의 id 값이 필요함 
$class_id       =   json_decode(file_get_contents("php://input"))->{"class_id"}; // 수업번호 
$class_register_id       =   json_decode(file_get_contents("php://input"))->{"class_register_id"}; // 예약한 수업 번호 


// $class_register_id       =  239; // 예약한 수업 번호 
// $class_id       =   34; // 수업번호 
// 강사의 수업목록 : kind = tclist
// 강사의 userid 값이 필요함 
$user_id_teacher       =   json_decode(file_get_contents("php://input"))->{"user_id_teacher"}; // 강사의 User_id 
// $user_id_teacher       =  32; // 강사의 User_id 


//====================================================================================================

//수업목록, 강사의 수업목록 이 필요할 경우 아래의 항목에 (아무런) 값을 넣어 보내줘야 출력됨.  

$class_name            =   json_decode(file_get_contents("php://input"))->{"class_name"};   // 수업이름 
$class_description     =   json_decode(file_get_contents("php://input"))->{"class_description"};   // 수업설명 
$class_people          =   json_decode(file_get_contents("php://input"))->{"class_people"}; // 수업인원 
$class_type            =   json_decode(file_get_contents("php://input"))->{"class_type"};   // 수업유형 
$class_level           =   json_decode(file_get_contents("php://input"))->{"class_level"};  // 수업레벨 
$class_time            =   json_decode(file_get_contents("php://input"))->{"class_time"};   // 수업시간
$class_price           =   json_decode(file_get_contents("php://input"))->{"class_price"};  // 수업가격
$teacher_img           =   json_decode(file_get_contents("php://input"))->{"teacher_img"};     // 강사이미지
$teacher_name          =   json_decode(file_get_contents("php://input"))->{"teacher_name"};    // 강사이름




// 더보기 (페이징)처리 용 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 


 if ($kind == 'clist') {
  //필요한 값이 class list 이면  

  $i = 0;

  $start =  $i + (20 * $plus);
  $till = 20;

  $result1['result'] = array();
  $result2['timeprice'] = array();

  //Class_List와  class_list_Time_Price 와 join 을 통해서 userid가 만든  class list의 class id 값을  class_List_Time_Price와의 fk로 해서 리스트를 얻는다. 
  // 그중 가장 낮은 가격의 값을 얻는다. 

// 수업수준, 수업 종류, 수업 가격 (최저~ 최대), 최근 수업 진행한 순서, 강사의 전문가 여부, 강사 국적, 강사 거주국, 강사 성별,  

  if ($clReserveCheck  == null) {
    //Class_List에 수업 목록확인  
    $Clist_Sql = "SELECT * FROM Class_List order by class_id DESC LIMIT $start, $till";
    $response1 = mysqli_query($conn, $Clist_Sql);

    while ($row1 = mysqli_fetch_array($response1)) {
      $clid = $row1['0'];
      $usid = $row1['1'];
      $send1['user_id_teacher'] = $row1['1'];
      $send1['class_id'] = $row1['0'];
      $send1['class_name'] = $row1['2'];
      $send1['class_description'] = $row1['3'];
      $send1['class_people'] = $row1['4'];
      $send1['class_type'] = $row1['5'];
      $send1['class_level'] = $row1['6'];



      //해당 Class를 개설한 강사의 이미지와 이름(User_Detail TB)    
      $teacher_Sql = "SELECT 
      User.user_name, 
      User_Teacher.teacher_special,  
      User_Detail.user_img

      FROM User
      JOIN User_Detail
        ON User.user_id = User_Detail.user_id
      JOIN User_Teacher
        ON User_Teacher.user_id = User_Detail.user_id 
      where User.user_id = '$usid' ";
      $response2 = mysqli_query($conn, $teacher_Sql);
      $row2 = mysqli_fetch_array($response2);
      $send1['user_name'] = $row2['0'];
      $send1['teacher_special'] = $row2['1'];
      $send1['user_img'] = $row2['2'];

      //Class_List_Time_Price 수업 시간, 가격 확인   
      $CLTP_Sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";
      $response3 = mysqli_query($conn, $CLTP_Sql);

      while ($row2 = mysqli_fetch_array($response3)) {

        $tp['class_time'] = $row2['2'];
        $tp['class_price'] = $row2['3'];

        array_push($result2['timeprice'], $tp);
      }
      //  echo json_encode($result2);

      $send1['tp'] = $result2['timeprice'];

      array_push($result1['result'], $send1);
      $result2['timeprice'] = array();
    }

    if ($response2) { //정상적으로 저장되었을때 

      $result1["success"] = "yes";
      echo json_encode($result1);
      mysqli_close($conn);
    } else {

      $result1["success"]   =  "no";
      echo json_encode($result1);
      mysqli_close($conn);
    }
  } 
}