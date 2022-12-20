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

$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone



# 필요값 
// 어떤 내용이 필요한지를 표시 ( clist-수업목록, cdetail-수업상세, tclist-강사의 수업목록)
$kind          =   json_decode(file_get_contents("php://input"))->{"kind"}; // 
$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; // 예약된 수업 리스트 / 상세 




$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; // 예약된 수업 리스트 / 상세 



$filter_class_status_check                 =   json_decode(file_get_contents("php://input"))->{"filter_class_status_check"}; // 수업 상태 필터 

$filter_class_name                 =   json_decode(file_get_contents("php://input"))->{"filter_class_name"}; // 수업 이름 검색 필터 
$filter_user_name                 =   json_decode(file_get_contents("php://input"))->{"filter_user_name"}; // 학생 이름 검색 필터 
$filter_class_resister_time_from1     =   json_decode(file_get_contents("php://input"))->{"filter_class_resister_time_from"}; //날짜 시작 시점 필터 
// $filter_class_resister_time_from1     =  '1671321600000'; //날짜 시작 시점 필터 
$filter_class_resister_time_to1     =   json_decode(file_get_contents("php://input"))->{"filter_class_resister_time_to"}; //날짜 종료 시점 필터 
// $filter_class_resister_time_to1     =  '1671494400000'; //날짜 시작 시점 필터 

// 1671321600000
// 1671408000000
//1671494400000



if ($filter_class_resister_time_from1 != null) {
  $filter_class_resister_time_from =  date('Y-m-d ', $filter_class_resister_time_from1 / 1000);
}
if ($filter_class_resister_time_to1 != null) {
  $filter_class_resister_time_to   = date('Y-m-d ',   $filter_class_resister_time_to1 / 1000);
}




//테스트용 ! 
// $User_ID = 324; //학생의 userid
// $kind = 'tcdetail';
// $clReserveCheck  =  'all';
// $filter_class_status_check = 'all'; // 수업 상태 필터 
// $filter_class_name  =  '기';             
// $filter_user_name   =  'a';             
// $filter_class_resister_time_from =  '2022-12-19 02:21:41';
// $filter_class_resister_time_to   =  '2022-12-19 02:22:41';
// $timezone =9; //사용자(학생)의 TimeZone



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

$class_name     =   json_decode(file_get_contents("php://input"))->{"class_name"};   // 수업이름 
$class_description     =   json_decode(file_get_contents("php://input"))->{"class_description"};   // 수업설명 
$class_people   =   json_decode(file_get_contents("php://input"))->{"class_people"}; // 수업인원 
$class_type     =   json_decode(file_get_contents("php://input"))->{"class_type"};   // 수업유형 
$class_level    =   json_decode(file_get_contents("php://input"))->{"class_level"};  // 수업레벨 
$class_time     =   json_decode(file_get_contents("php://input"))->{"class_time"};   // 수업시간
$class_price    =   json_decode(file_get_contents("php://input"))->{"class_price"};  // 수업가격
$teacher_img       =   json_decode(file_get_contents("php://input"))->{"teacher_img"};     // 강사이미지
$teacher_name      =   json_decode(file_get_contents("php://input"))->{"teacher_name"};    // 강사이름




$filter_check      = json_decode(file_get_contents("php://input"))->{"filter_check"};    // 
$filter_teacher_special      = json_decode(file_get_contents("php://input"))->{"filter_teacher_special"};    // 
$filter_class_price_min      = json_decode(file_get_contents("php://input"))->{"filter_class_price_min"};    // 
$filter_class_price_max      = json_decode(file_get_contents("php://input"))->{"filter_class_price_max"};    // 
$filter_class_level          = json_decode(file_get_contents("php://input"))->{"filter_class_level"};    // 
$filter_teacher_country      = json_decode(file_get_contents("php://input"))->{"filter_teacher_country"};    // 
$filter_teacher_sex          = json_decode(file_get_contents("php://input"))->{"filter_teacher_sex"};    // 
$filter_class_type           = json_decode(file_get_contents("php://input"))->{"filter_class_type"};    // 
$filter_teacher_language     = json_decode(file_get_contents("php://input"))->{"filter_teacher_language"};    // 



$filter_check      = 'ok';  
$kind = 'clist';
$clReserveCheck = null;

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


  if ($clReserveCheck  == null) {

    if ($filter_check  == null) {


      //Class_List에 수업 목록확인  
      $Clist_Sql = "SELECT * FROM Class_List order by class_id DESC LIMIT $start, $till";
      $response1 = mysqli_query($conn, $Clist_Sql);

      while ($row1 = mysqli_fetch_array($response1)) {
        $clid = $row1['class_id'];
        $usid = $row1['user_id_teacher'];
        $send1['user_id_teacher'] = $row1['user_id_teacher'];


        $send1['class_id'] = $row1['class_id'];
        $send1['class_name'] = $row1['class_name'];
        $send1['class_description'] = $row1['class_description'];
        $send1['class_people'] = $row1['class_people'];
        $send1['class_type'] = $row1['class_type'];
        $send1['class_level'] = $row1['class_level'];



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
      where User.user_id = '$usid'";
        $response2 = mysqli_query($conn, $teacher_Sql);
        $row2 = mysqli_fetch_array($response2);
        $send1['user_name'] = $row2['user_name'];
        $send1['teacher_special'] = $row2['teacher_special'];
        $send1['user_img'] = $row2['user_img'];

        //Class_List_Time_Price 수업 시간, 가격 확인   
        $CLTP_Sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";
        $response3 = mysqli_query($conn, $CLTP_Sql);

        while ($row2 = mysqli_fetch_array($response3)) {

          $tp['class_time'] = $row2['class_time'];
          $tp['class_price'] = $row2['class_price'];

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





    if ($filter_check  != null) {


      //Class_List에 수업 목록확인  
      $Clist_Sql = "SELECT * FROM Class_List order by class_id DESC LIMIT $start, $till";
      $response1 = mysqli_query($conn, $Clist_Sql);

      while ($row1 = mysqli_fetch_array($response1)) {
        $clid = $row1['class_id'];
        $usid = $row1['user_id_teacher'];
        $send1['user_id_teacher'] = $row1['user_id_teacher'];


        $send1['class_id'] = $row1['class_id'];
        $send1['class_name'] = $row1['class_name'];
        $send1['class_description'] = $row1['class_description'];
        $send1['class_people'] = $row1['class_people'];
        $send1['class_type'] = $row1['class_type'];
        $send1['class_level'] = $row1['class_level'];



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
      where User.user_id = '$usid'";
        $response2 = mysqli_query($conn, $teacher_Sql);
        $row2 = mysqli_fetch_array($response2);
        $send1['user_name'] = $row2['user_name'];
        $send1['teacher_special'] = $row2['teacher_special'];
        $send1['user_img'] = $row2['user_img'];

        //Class_List_Time_Price 수업 시간, 가격 확인   
        $CLTP_Sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";
        $response3 = mysqli_query($conn, $CLTP_Sql);

        while ($row2 = mysqli_fetch_array($response3)) {

          $tp['class_time'] = $row2['class_time'];
          $tp['class_price'] = $row2['class_price'];

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
  } else if ($clReserveCheck  != null) {
    // 학생(사용자)가 자신이 예약 신청한 수업 목록을 얻어옴 all , wait, approved, cancel, done, review

    if ($clReserveCheck == 'all') {
      $sqlWhere = 'where Class_Add.user_id_student =' . $User_ID;
    } else if ($clReserveCheck != 'all') {
      if ($clReserveCheck == 'wait') {

        $clRCValue = '0';
      } else if ($clReserveCheck == 'approved') {
        $clRCValue = '1';
      } else if ($clReserveCheck == 'cancel') {
        $clRCValue = '2';
      } else if ($clReserveCheck == 'done') {
        $clRCValue = '3';
      }
      $sqlWhere = 'where Class_Add.user_id_student = ' . $User_ID . ' and Class_Add.class_register_status = ' . $clRCValue;
    }

    //해당 Class_List 와 Class_Add 에서 값을 가져옴     
    $Student_ReserveClassList_Sql = "SELECT Class_List.*,Class_Add.schedule_list,Class_Add.class_register_status,Class_Add.class_register_answer_date,
    Class_Add.class_register_date,Class_Add.class_time,Class_Add.class_register_id,Class_Add.class_register_method  ,Class_Add.class_register_review
    
    FROM Class_Add LEFT  OUTER JOIN Class_List ON Class_Add.class_id = Class_List.class_id
     $sqlWhere  order by  class_id DESC LIMIT $start, $till";


    $SRCList_Result = mysqli_query($conn, $Student_ReserveClassList_Sql);
    $result['result'] = array();
    while ($row1 = mysqli_fetch_array($SRCList_Result)) {
      $send['class_id'] = $row1['class_id']; //수업id
      $send['user_id_teacher'] = $row1['user_id_teacher']; //강사의 userid
      $user_id_teacher = $row1['user_id_teacher']; //강사의 userid
      $send['class_name'] = $row1['class_name']; //수업 이름
      $send['class_description'] = $row1['class_description']; // 수업 설명
      $send['class_people'] = $row1['class_people']; // 수업인원
      $send['class_type'] = $row1['class_type']; // 수업 종류
      $send['class_level'] = $row1['class_level']; // 수업 레벨 
      // $send1['class_level'] = $row1['7'];


      $plan = $row1['8']; // utc 0 기준 예약한 시간 
      // $send1['orplan'] = $row1['8'];
      $explodePlan = (explode("_", $plan)); // _기준으로 string 분해 
      $hour = 3600000; // 시간의 밀리초 
      $splanArray = array(); // utc 적용한 값 담을 배열 

      foreach ($explodePlan as $val) {
        'User utc 기준 : 변환  ' . $save = $val + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
        array_push($splanArray, $save);
      }

      $utc_plan = implode("_", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 


      $send['class_start_time'] = $utc_plan;  //user의 timezone이 적용된 예약한 수업 일정 값 
      $send['class_register_status'] = $row1['class_register_status'];   //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done)
      $answerdate = $row1['class_register_answer_date']; //응답한 시간 
      $send['class_register_answer_date'] = $answerdate * 1000;  //응답한 시간 js 에서 밀리초 단위이기 때문에 *1000 적용      
      $send['class_register_date'] = $row1['class_register_date']; // 수업예약 신청한 시간 
      $send['class_time'] = $row1['class_time']; // 수업 시간 (30분, 60분)
      $send['class_register_id'] = $row1['class_register_id']; // 신청한 수업 리스트의 idx 값
      $send['class_register_method'] = $row1['class_register_method']; // 신청한 수업 도구
      $send['class_register_review'] = $row1['class_register_review']; // 신청한 수업 리뷰



      //해당 Class를 개설한 강사의 이미지와 이름(User_Detail TB)    
      $teacher_Sql = "SELECT 
      User.user_name, 
      User_Teacher.teacher_special,  
      User_Detail.user_img

      FROM User
      JOIN User_Detail
        ON User.user_Id = User_Detail.user_Id
      JOIN User_Teacher
        ON User_Teacher.user_Id = User_Detail.user_Id 
      where User.user_Id = '$user_id_teacher' ";
      $response2 = mysqli_query($conn, $teacher_Sql);
      $row2 = mysqli_fetch_array($response2);
      $send['user_name'] = $row2['user_name']; // 강사 이름 
      $send['teacher_special'] = $row2['teacher_special']; // 강사 전문성
      $send['user_img'] = $row2['user_img']; // 강사 이미지 


      array_push($result['result'], $send);
    }


    if ($response2) { //정상적으로 저장되었을때 

      $result["success"] = "yes";
      echo json_encode($result);
      mysqli_close($conn);
    } else {

      $result["success"]   =  "no";
      echo json_encode($result);
      mysqli_close($conn);
    }
  }
}
