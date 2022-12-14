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


$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"};  //유저의 로컬 타임존 










if ($token != null) {

  //토큰 해체 
  $data = $jwt->dehashing($token);
  $parted = explode('.', base64_decode($token));
  $payload = json_decode($parted[1], true);
  $User_ID =  base64_decode($payload['User_ID']);
  // $User_ID =  324;
  $U_Name  = base64_decode($payload['U_Name']);
  $U_Email = base64_decode($payload['U_Email']);
  $timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone
  $login = 'yes login';
  // $timezone      =   8;

} else {
  // echo 111;
  $timezone = $utc;
  // $send['CONNECT_USER_TIMEZONE'] = $utc;
  $login = 'not login';

  // $User_ID =  324;

}








# 필요값 
// 어떤 내용이 필요한지를 표시 ( clist-수업목록, cdetail-수업상세, tclist-강사의 수업목록)
$kind          =   json_decode(file_get_contents("php://input"))->{"kind"}; // 
$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; // 예약된 수업 리스트 / 상세 




$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; // 예약된 수업 리스트 / 상세 



$filter_class_status_check                 =   json_decode(file_get_contents("php://input"))->{"filter_class_status_check"}; // 수업 상태 필터 

$filter_class_name                 =   json_decode(file_get_contents("php://input"))->{"filter_class_name"}; // 수업 이름 검색 필터 
$filter_user_name                 =   json_decode(file_get_contents("php://input"))->{"filter_user_name"}; // 학생 이름 검색 필터 
$filter_class_resister_time_from1     =   json_decode(file_get_contents("php://input"))->{"filter_class_resister_time_from"}; //날짜 시작 시점 필터 
// $filter_class_resister_time_from     =  '1671321600000'; //날짜 시작 시점 필터 
$filter_class_resister_time_to1     =   json_decode(file_get_contents("php://input"))->{"filter_class_resister_time_to"}; //날짜 종료 시점 필터 
// $filter_class_resister_time_to     =  '1671494400000'; //날짜 시작 시점 필터 



$hour = 3600000;


if ($filter_class_resister_time_from1 != null) {
  $filter_class_resister_time_from =  $filter_class_resister_time_from1;
}
if ($filter_class_resister_time_to1 != null) {
  $filter_class_resister_time_to   = $filter_class_resister_time_to1;
}




//수업찾기 필터 
$filter_check      = json_decode(file_get_contents("php://input"))->{"filter_check"};    // 필터사용유무
$filter_search      = json_decode(file_get_contents("php://input"))->{"filter_search"};    // 검색어 필터 (수업명, 수업설명부분 필터 )
$filter_class_type           = json_decode(file_get_contents("php://input"))->{"filter_class_type"};    //  수업타입 필터  
$filter_class_price_min      = json_decode(file_get_contents("php://input"))->{"filter_class_price_min"};    // 최저가격
$filter_class_price_max      = json_decode(file_get_contents("php://input"))->{"filter_class_price_max"};    // 최대가격
$filter_teacher_special      = json_decode(file_get_contents("php://input"))->{"filter_teacher_special"};    // 강사 전문가 여부
$filter_teacher_country      = json_decode(file_get_contents("php://input"))->{"filter_teacher_country"};    // 강사 출신국가 
$filter_teacher_sex          = json_decode(file_get_contents("php://input"))->{"filter_teacher_sex"};        // 강사성별
$filter_teacher_language     = json_decode(file_get_contents("php://input"))->{"filter_teacher_language"};   // 강사 사용언어 

$filter_date           = json_decode(file_get_contents("php://input"))->{"filter_date"};   // 수업 일자   
$filter_time           = json_decode(file_get_contents("php://input"))->{"filter_time"};   // 시간   {0,1,2,3,4,5,6~23} array 형태 



if ($filter_class_price_min == null) {
  $filter_class_price_min = 0;
}

if ($filter_class_price_min == null) {
  $filter_class_price_max = 100000;
}



//수업찾기 필터 테스트용 
// $kind = 'clist';
// $clReserveCheck = null; //안해도됨
// $filter_check      = 'ok(아무값)';
// $filter_search     = '기초';  
// $filter_date       =  array("1671667200000", "1671753600000");
// $filter_hour_check = 'ok(아무값)';
// $filter_class_price_min = 0 ;
// $filter_class_price_max = 100000;
// $filter_teacher_special = 'default'; // 커뮤니티 강사 
// $filter_teacher_special = 'notdefault'; // 전문 강사 

// $filter_date = array("1671517800000","1671521400000");
// $filter_date = array("1671517800000");
// $filter_class_type = array("회화 연습","듣기");
// $filter_class_type = array("발음");
// $filter_teacher_sex  = '남성';
// $filter_teacher_country = '중국';
// $filter_teacher_language = array("러시아어","스페인어");












//테스트용 ! 
// $User_ID = 320; //학생의 userid

// $kind = 'clist';
// $clReserveCheck  =  'detail';
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
// $clReserveCheck  =  'detail';
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


// $class_register_id       =  258; // 예약한 수업 번호 
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




// 더보기 (페이징)처리 용 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 
// $plus       =   0;     // 더보기 



// $kind = 'tcdetail';

// $timezone = 9; //사용자(학생)의 TimeZone

// $User_ID = 324; //학생의 userid
// $class_register_id       =  258; // 예약한 수업 번호 

// error_log("$User_ID ,   $kind,  $clReserveCheck,   $filter_class_status_check, \n", "3", "../php.log");






// 수업찾기 필터 테스트용 
// $kind = 'clist';
// $timezone      =   9;  //유저의 로컬 타임존 
// $clReserveCheck = null; //안해도됨
// $filter_search     = '팀';
// $filter_time = array("9");
// $filter_date = "1672930800000";  //2023-01-05 15:00 기준 = 2023-01-06 00:00 (utc +9:00) 기준
// $filter_class_type = array("철자");
// $filter_teacher_country      = array("스페인");   // 강사 출신국가 
// $filter_teacher_sex  = '남성'; // 강사성별
// $filter_class_price_min = 0 ;
// $filter_class_price_max = 100000;
// $filter_teacher_special = 'default'; // 커뮤니티 강사 
// $filter_teacher_special = 'nondefault'; // 전문 강사 

// $filter_class_type = array("듣기", "철자");
// $filter_teacher_sex  = '여성';
// $filter_teacher_country = array("중국");
// $filter_teacher_language = array("러시아어", "스페인어"); // 강사 사용언어 


// cdetail 확인 
// $kind = 'cdetail';




// $kind = 'cdetail';
// $clReserveCheck = 'detail'; //안해도됨
// $User_ID = 320; //학생의 userid
// $class_register_id       =  258; // 예약한 수업 번호 


// $kind = 'clist';
// $clReserveCheck = 'all'; //안해도됨
// $User_ID = 320; //학생의 userid
// $kind = 'tclist';
// $clReserveCheck = 'all'; //안해도됨
// $User_ID = 324; //학생의 userid
// $plus = 1; //안해도됨
// $user_id_teacher = 320;

// 수업상세 출력인지 목록 출력인지 
if ($kind == 'cdetail') {
  //해당 classid에 해당하는 상세정보를 가져옴 
  //class_id 가 있으면 작동
  $list = array();
  if ($class_name != null) {
    array_push($list, 'class_name');
  }
  if ($class_description != null) {
    array_push($list, 'class_description');
  }
  if ($class_people != null) {
    array_push($list, 'class_people');
  }
  if ($class_type != null) {
    array_push($list, 'class_type');
  }
  if ($class_level != null) {
    array_push($list, 'class_level');
  }
  if ($class_price != null) {
    array_push($list, 'class_price');
  }

  $string = implode(",", $list);

  if ($clReserveCheck  == null) {


    $result1['result'] = array();
    $result2['timeprice'] = array();


    //수업 상세 정보 
    $Clist_Sql = "SELECT * FROM Class_List WHERE class_id = '{$class_id}'";
    $response1 = mysqli_query($conn, $Clist_Sql);

    $row1 = mysqli_fetch_array($response1);


    $clid = $row1['0'];
    $user_id_teacher = $row1['1'];

    $send['class_id'] = $row1['0'];

    $send['user_id'] = $row1['1'];
    if ($class_name != null) {
      $send['class_name'] = $row1['2'];
    }
    if ($class_description != null) {
      $send['class_description'] = $row1['3'];
    }
    if ($class_people != null) {
      $send['class_people'] = $row1['4'];
    }
    if ($class_type != null) {
      $send['class_type'] = $row1['5'];
    }
    if ($class_level != null) {
      $send['class_level'] = $row1['6'];
    }




    //Class_List_Time_Price 수업 시간, 가격 확인   
    $Cltp_Sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";


    if ($class_price != null) {
      $response2 = mysqli_query($conn, $Cltp_Sql);
      while ($row2 = mysqli_fetch_array($response2)) {

        $send1 = $row2['3'];
        array_push($result2['timeprice'], $send1);
      }
      $send['tp'] = $result2['timeprice'];
    }


    array_push($result1['result'], $send);
    echo json_encode($result1);
    mysqli_close($conn);
  } else if ($clReserveCheck  == 'detail') {

    $result1['result'] = array();
    //수업 상세 정보 
    $Clist_Sql = "SELECT Class_Add.*,Class_List.* FROM Class_Add LEFT OUTER JOIN Class_List ON Class_Add.class_id = Class_List.class_id 
      where Class_Add.user_id_student = '$User_ID' and class_register_id = '$class_register_id'";

    $response1 = mysqli_query($conn, $Clist_Sql);

    $row1 = mysqli_fetch_array($response1);

    $send['class_register_id'] = $row1['0']; //수업id

    $send['class_id'] = $row1['3']; //수업 id
    $send['class_time'] = $row1['4']; // 수업 시간 (30분 60분)
    $plan = $row1['5']; // utc 0 기준 예약한 시간 
    $explodePlan = (explode("_", $plan)); // _기준으로 string 분해 
    $hour = 3600000; // 시간의 밀리초 
    $splanArray = array(); // utc 적용한 값 담을 배열 

    foreach ($explodePlan as $val) {
      'User utc 기준 : 변환  ' . $save = $val; // user의 timezone을 적용한 값을  $save 저장 
      // 'User utc 기준 : 변환  ' . $save = $val + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
      array_push($splanArray, $save);
    }

    $utc_plan = implode("_", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 


    $send['class_start_time'] = $utc_plan;  //user의 timezone이 적용된 예약한 수업 일정 값 


    $send['class_register_memo'] = $row1['class_register_memo']; // 수업메모
    $send['class_register_status'] = $row1['class_register_status'];   //  신청한 수업 상태   
    $send['class_register_review'] = $row1['class_register_review'];   //  신청한 수업 선생님 review 작성여부 
    $send['class_register_review_student'] = $row1['class_register_review_student'];   //  신청한 수업 학생 review 작성여부   
    $send['class_register_method'] = $row1['class_register_method']; // 신청한 수업 진행 방식

    $answerdate = $row1['class_register_answer_date']; //응답한 시간 
    $send['class_register_answer_date'] = $answerdate * 1000;  //응답한 시간 js 에서 밀리초 단위이기 때문에 *1000 적용    

    $send['class_register_date'] = $row1['class_register_date']; // 수업예약 신청한 시간 
    $send['class_id'] = $row1['class_id'];  // 수업 id 
    $send['class_time'] = $row1['class_time'];  // 수업 id 
    $ctime = $row1['class_time'];  // 수업 id 
    $cid = $row1['class_id'];  // 수업 id 

    $cpricesql = "SELECT * FROM Class_List_Time_Price   where Class_List_Time_Price.class_id = '$cid' and Class_List_Time_Price.class_time = $ctime";
    $response3 = mysqli_query($conn, $cpricesql);

    $row3 = mysqli_fetch_array($response3);


    $send['class_price'] = $row3['class_price'];  // 수업가격

    $send['user_id_teacher'] = $row1['user_id_teacher'];  //강사의 userid
    $tusid = $row1['user_id_teacher'];  //강사의 userid
    $send['class_name'] = $row1['class_name']; //
    $send['class_description'] = $row1['class_description']; //
    $send['class_people'] = $row1['class_people']; //
    $send['class_type'] = $row1['class_type']; //
    $send['class_level'] = $row1['class_level']; //

    $tinfosql = "SELECT User.*, User_Detail.*, User_Teacher.* FROM User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id LEFT OUTER JOIN User_Teacher ON User_Teacher.user_id = User_Detail.user_id
    where User.user_id = '$tusid'";
    $response2 = mysqli_query($conn, $tinfosql);

    $row2 = mysqli_fetch_array($response2);

    $send['teacher_name'] = $row2['user_name']; //
    $send['teacher_img'] = $row2['user_img']; //
    $send['teacher_birthday'] = $row2['user_birthday']; //
    $send['teacher_country'] = $row2['user_country']; //
    $send['teacher_language'] = $row2['user_language']; //
    $send['teacher_intro'] = $row2['teacher_intro']; //
    $send['teacher_special'] = $row2['teacher_special']; //



    if ($timezone >= 0) {
      $plus_minus = '+' . $timezone . ':00';
    } else {
      $plus_minus = '' . $timezone . ':00';
    }


    $timezone2 = '"' . "$plus_minus" . '"'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 
    $timezero = '"' . "+00:00" . '"'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 



    //union 사용
    $teacherStudentReviewSql = "SELECT A.class_teacher_review_id, A.class_register_id, A.teacher_review, A.teacher_review_date,B.class_student_review_id, B.class_register_id, B.student_review, B.student_review_star,B.student_review_date FROM HANGLE.Class_Teacher_Review A left join Class_Student_Review B ON A.class_register_id = B.class_register_id where A.class_register_id ='$class_register_id'
     union 
    SELECT  A.class_teacher_review_id, A.class_register_id, A.teacher_review,A.teacher_review_date,B.class_student_review_id, B.class_register_id, B.student_review, B.student_review_star,B.student_review_date FROM HANGLE.Class_Student_Review B left join Class_Teacher_Review A ON B.class_register_id = A.class_register_id where B.class_register_id = '$class_register_id'";





    $response2 = mysqli_query($conn, $teacherStudentReviewSql);

    $row3 = mysqli_fetch_array($response2);

    $send['teacher_review'] = $row3['teacher_review']; //
    $send['teacher_review_date'] = $row3['teacher_review_date']; //
    $send['student_review'] = $row3['student_review']; //
    $send['student_review_star'] = $row3['student_review_star']; //
    $send['student_review_date'] = $row3['student_review_date']; //




    array_push($result1['result'], $send);
    echo json_encode($result1['result'],);
    mysqli_close($conn);
  }
} else if ($kind == 'clist') {
  //필요한 값이 class list 이면  
  $i = 0;
  $start =  $i + (20 * $plus);
  $till = 20;
  $result1['result'] = array();
  $result2['timeprice'] = array();

  //Class_List와  class_list_Time_Price 와 join 을 통해서 userid가 만든  class list의 class id 값을  class_List_Time_Price와의 fk로 해서 리스트를 얻는다. 
  // 그중 가장 낮은 가격의 값을 얻는다. 
  // echo ' 1. clist 진입';

  if ($clReserveCheck  == null) {

    // echo '  2. crcheck null 진입';
    // 전체





    $Clist_Sql = "SELECT distinct class_id, Teacher_Schedule.user_id_teacher, class_name, class_description, class_type, class_level , class_people FROM Class_List JOIN Teacher_Schedule 
         ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher
         order by class_id DESC LIMIT $start, $till";



    //시간필터관련 
    if ($filter_date != null || $filter_time != null) {

      // echo '  3. 시간 필터 진입';

      // $filter_date =  1671667200000;
      $hour = 3600000;
      $halfhour = 3600000 / 2;
      // $day =  3600000*24;

      $day = 86400000;

      $filter_hour_array1 = array(); // 배열 설정.

      //날짜만 있을때 
      if ($filter_date != null && $filter_time == null) {
        // echo '  3-1. 날짜만 있는경우 진입';
        //전달받은 $filter_date 에 timezone을 채크해서 hour을 적용해 utc 0 기준으로 바꾼다.

        // $filter_date_utc_zero1 = $filter_date - ($hour * $timezone); // user의 timezone을 적용해서 utc 0 기준으로 변경 
        $filter_date_utc_zero1 = $filter_date; // user의 timezone을 적용해서 utc 0 기준으로 변경 
        $filter_date_utc_zero2 = $filter_date_utc_zero1 + $day - 1; // user의 timezone을 적용해서 utc 0 기준으로 변경한 값의 24시간을 더한 값


        $filter_hour_add3  = 'schedule_list between ' . $filter_date_utc_zero1 . ' and ' . $filter_date_utc_zero2;

        //시간대만 있을때 
      } else if ($filter_date == null && $filter_time != null) {
        // echo '  3-2. 시간만 있는경우 진입';
        // echo 3;
        // utc 0 기준 당일날짜값 timestamp 가져온뒤 프론트에 맞춰 1000 곱해주기 

        $explode_filter_time = $filter_time;


        $filter_hour_array1 = array(); //검사 해야할 시간 기준 



        foreach ($explode_filter_time as $val) {


          $results = array();

          for ($i = 0; $i < 14; $i++) {
            $today2 = strtotime(date("Y-m-d", strtotime("+$i days"))) * 1000;


            // $오늘날짜더하기시간값 = $today2 + ($val - $timezone + 1) * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로   
            $오늘날짜더하기시간값 = $today2 + ($val - $timezone) * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로   
            $오늘날짜더하기시간값더하기한시간 = $오늘날짜더하기시간값 + $hour - 1; // 3을 선택한경우 3시부터 4시 사이의 값이 필요하기때문에 한시간을 더해줌 

            $filter_date_i = '(schedule_list between ' . '"' . $오늘날짜더하기시간값  . '"' . ' and ' . '"' . $오늘날짜더하기시간값더하기한시간  . '")'; // user의 timezone을 적용한 값을  $save 저장 
            array_push($filter_hour_array1, $filter_date_i);
          }
        }



        $filter_hour_add2 = implode(" or ", $filter_hour_array1); // 담긴 배열을 _기준으로 스트링으로 저장 

        $filter_hour_add3  =  $filter_hour_add2;



        //날짜와 시간이 모두 있을 때 
      } else if ($filter_date != null && $filter_time != null) {

        // echo '  3-3. 날짜와 시간이 있는경우 진입';

        $explode_filter_time = $filter_time;

        $filter_hour_array1 = array(); //검사 해야할 시간 기준 

        // $filter_date_utc_zero1 = $filter_date - ($hour * $timezone); // user의 timezone을 적용해서 utc 0 기준으로 변경 
        $filter_date_utc_zero1 = $filter_date; // user의 timezone을 적용해서 utc 0 기준으로 변경 

        foreach ($explode_filter_time as $val) {


          $날짜에시간을더함 = $filter_date_utc_zero1 + ($val - $timezone) * $hour * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로
          $날짜에시간을더함더하기한시간 = $날짜에시간을더함 + $hour; // 3을 선택한경우 3시부터 4시 사이의 값이 필요하기때문에 한시간을 더해줌

          $filter_date_i = '(schedule_list between ' . '"' . $날짜에시간을더함  . '"' . ' and ' . '"' . $날짜에시간을더함더하기한시간  . '")'; // user의 timezone을 적용한 값을  $save 저장 
          array_push($filter_hour_array1, $filter_date_i);
        }



        $filter_hour_add2 = implode(" or ", $filter_hour_array1); // 담긴 배열을 _기준으로 스트링으로 저장 
        $filter_hour_add3  =  $filter_hour_add2;
      }



      if ($filter_search != null) {
        // echo '  4. 검색  필터 진입';
        //Class_List에 수업 목록확인  
        // 전체
        $filter_search_sql_part = " (class_name LIKE '%$filter_search%' 
                or class_description LIKE '%$filter_search%')";


        $Clist_Sql = "SELECT distinct class_id, user_id_teacher, class_name, class_description, class_type, class_level , class_people  FROM (SELECT Class_List.*, Teacher_Schedule.schedule_list,Teacher_Schedule.teacher_schedule_status, Teacher_Schedule.teacher_schedule_review,
                                  Teacher_Schedule.teacher_schedule_date
                                  FROM Class_List JOIN Teacher_Schedule
                                  ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher  WHERE $filter_hour_add3) AS new_class_list where  $filter_search_sql_part   order by class_id DESC LIMIT $start, $till";


        if ($filter_class_type != null) {

          // echo '  5. 수업타입 필터 진입';
          // $explode_filter_class_type = (explode(",", $filter_class_type)); // _기준으로 string 분해 
          $explode_filter_class_type = $filter_class_type; // _기준으로 string 분해 
          $class_type_array = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_class_type as $val) {

            $filter_class_type_i = '  class_type like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($class_type_array, $filter_class_type_i);
          }

          $filter_class_type_add = implode(" or ", $class_type_array); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_class_type_val =  $filter_class_type_add;

          $Clist_Sql = "SELECT distinct class_id, user_id_teacher, class_name, class_description, class_type, class_level, class_people  FROM (SELECT Class_List.*, Teacher_Schedule.schedule_list,Teacher_Schedule.teacher_schedule_status, Teacher_Schedule.teacher_schedule_review,
                Teacher_Schedule.teacher_schedule_date
                FROM Class_List JOIN Teacher_Schedule
                ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher  WHERE $filter_hour_add3) AS new_class_list where $filter_class_type_val  and $filter_search_sql_part  and   $filter_hour_add3  order by class_id DESC LIMIT $start, $till";
        }
      } else if ($filter_search == null) {

        // echo '  4. 검색  없음 진입';
        $Clist_Sql = "SELECT distinct class_id, Teacher_Schedule.user_id_teacher, class_name, class_description, class_type, class_level , class_people FROM  Class_List JOIN Teacher_Schedule 
                  ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher where $filter_hour_add3 order by class_id DESC LIMIT $start, $till";

        // 수업타입 
        if ($filter_class_type != null) {
          // echo '  5. 검색없고 수업타입 필터 진입';

          // $explode_filter_class_type = (explode(",", $filter_class_type)); // _기준으로 string 분해 
          $explode_filter_class_type = $filter_class_type; // _기준으로 string 분해 
          $class_type_array = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_class_type as $val) {

            $filter_class_type_i = '  class_type like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($class_type_array, $filter_class_type_i);
          }

          $filter_class_type_add = implode(" or ", $class_type_array); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_class_type_val = 'where ' . $filter_class_type_add;

          $Clist_Sql = "SELECT distinct class_id, user_id_teacher, class_name, class_description, class_type, class_level , class_people  FROM (SELECT Class_List.*, Teacher_Schedule.schedule_list,Teacher_Schedule.teacher_schedule_status, Teacher_Schedule.teacher_schedule_review,
                Teacher_Schedule.teacher_schedule_date
                FROM Class_List JOIN Teacher_Schedule
                ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher  WHERE $filter_hour_add3) AS new_class_list $filter_class_type_val and $filter_hour_add3 order by class_id DESC LIMIT $start, $till";
        }
      }
    } else if ($filter_date == null && $filter_time == null) {
      // echo '  6. 날짜, 시간 필터 없음 진입';
      if ($filter_search != null) {
        // echo '  7. 날짜, 시간 필터 없고 검색 있음 진입';
        //Class_List에 수업 목록확인  
        // 전체
        $filter_search_sql_part = " (class_name LIKE '%$filter_search%' 
          or class_description LIKE '%$filter_search%')";

        $Clist_Sql = "SELECT  distinct class_id, Teacher_Schedule.user_id_teacher, class_name, class_description, class_type, class_level , class_people FROM Class_List JOIN Teacher_Schedule 
          ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher where $filter_search_sql_part order by class_id DESC LIMIT $start, $till";

        if ($filter_class_type != null) {

          // echo '  8. 날짜, 시간 필터 없고 검색 있고 수업타입 필터 진입';
          // $explode_filter_class_type = (explode(",", $filter_class_type)); // _기준으로 string 분해 
          $explode_filter_class_type = $filter_class_type; // _기준으로 string 분해 
          $class_type_array = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_class_type as $val) {

            $filter_class_type_i = ' ( class_type like ' . '"%' . $val . '%")'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($class_type_array, $filter_class_type_i);
          }

          $filter_class_type_add = implode(" or ", $class_type_array); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_class_type_val = 'where ' . $filter_class_type_add;

          $Clist_Sql = "SELECT distinct class_id, Teacher_Schedule.user_id_teacher, class_name, class_description, class_type, class_level, class_people  FROM Class_List JOIN Teacher_Schedule 
           ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher $filter_class_type_val  and $filter_search_sql_part order by class_id DESC LIMIT $start, $till";
        }
      } else if ($filter_search == null) {
        // echo '  9. 날짜, 시간 필터 없고 검색 없음 진입';
        // 수업타입 
        if ($filter_class_type != null) {
          // echo '  10. 날짜, 시간 필터 없고 검색 없고 수업타입 필터 진입';
          // $explode_filter_class_type = (explode(",", $filter_class_type)); // _기준으로 string 분해 
          $explode_filter_class_type = $filter_class_type; // _기준으로 string 분해 
          $class_type_array = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_class_type as $val) {

            $filter_class_type_i = '  class_type like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($class_type_array, $filter_class_type_i);
          }

          $filter_class_type_add = implode(" or ", $class_type_array); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_class_type_val = 'where ' . $filter_class_type_add;

          $Clist_Sql = "SELECT distinct class_id, Teacher_Schedule.user_id_teacher, class_name, class_description, class_type, class_level, class_people  FROM  Class_List JOIN Teacher_Schedule 
              ON Class_List.user_id_teacher = Teacher_Schedule.user_id_teacher $filter_class_type_val order by class_id DESC LIMIT $start, $till";
        }
      }
    }



    // echo '   sql 값 ' . $Clist_Sql;


    // $Clist_Sql = "SELECT * FROM Class_List order by class_id DESC LIMIT $start, $till";

    $response1 = mysqli_query($conn, $Clist_Sql);

    while ($row1 = mysqli_fetch_array($response1)) {
      $clid = $row1['class_id'];
      $tusid = $row1['user_id_teacher'];
      $send1['user_id_teacher'] = $row1['user_id_teacher'];

      $send1['class_id'] = $row1['class_id'];
      $send1['class_name'] = $row1['class_name'];
      $send1['class_description'] = $row1['class_description'];
      $send1['class_people'] = $row1['class_people'];
      $send1['class_type'] = $row1['class_type'];
      $send1['class_level'] = $row1['class_level'];



      // $filter_teacher_sex = '남성';


      // 강사 전문가 여부, 강사 출신국, 성별, 사용언어 

      // 성별
      if ($filter_teacher_sex != null) {
        // echo '  9. 성별 필터 있음 진입';
        $filter_teacher_sex_val = '"' . $filter_teacher_sex . '"';
      } else if ($filter_teacher_sex == null) {
        // echo '  10. 성별 필터 없음 진입';
        $filter_teacher_sex_val = "'%성%'";
      }

      $tsql_where = " where User.user_id = '$tusid' and user_sex like  $filter_teacher_sex_val ";



      if ($filter_teacher_special != null) {
        // echo '  11. 전문가 필터 있음 진입';
        $filter_teacher_special_val = '"' . $filter_teacher_special . '"';
      } else if ($filter_teacher_special == null) {
        // echo '  12. 전문가 필터 없음 진입';
        $filter_teacher_special_val = "'%default%'";
      }


      $tsql_where = " where User.user_id = '$tusid' and user_sex like  $filter_teacher_sex_val and teacher_special like  $filter_teacher_special_val ";




      if ($filter_teacher_country != null) {
        // echo '  13. 국가 필터 있음 진입';


        $explode_filter_teacher_country = $filter_teacher_country; // 
        $countryArray = array();
        foreach ($explode_filter_teacher_country as $val) {

          $filter_user_country_i = ' user_country  like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


          array_push($countryArray, $filter_user_country_i);
        }

        $filter_user_country_i_add = implode(" or ", $countryArray); // 담긴 배열을 _기준으로 스트링으로 저장 

        $filter_user_country_i_add_val = $filter_user_country_i_add;

        $tsql_where = "$tsql_where and ($filter_user_country_i_add_val) ";
      }





      if ($filter_teacher_language != null) {
        // echo '  14. 언어 필터 있음 진입';
        // $explode_filter_teacher_language = (explode("_", $filter_teacher_language)); // _기준으로 string 분해 
        $explode_filter_teacher_language = $filter_teacher_language; // _기준으로 string 분해 
        $splanArray = array(); // utc 적용한 값 담을 배열 
        foreach ($explode_filter_teacher_language as $val) {

          $filter_teacher_language_i = ' user_language  like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


          array_push($splanArray, $filter_teacher_language_i);
        }

        $filter_teacher_language_i_add = implode(" or ", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 

        $filter_teacher_language_i_val = $filter_teacher_language_i_add;

        $tsql_where = "$tsql_where and ($filter_teacher_language_i_val) ";
      }


      //해당 Class를 개설한 강사의 이미지와 이름(User_Detail TB)    
      $teacher_Sql = "SELECT 
          *
        FROM User
        JOIN User_Detail
         ON User.user_id = User_Detail.user_id
        JOIN User_Teacher
         ON User_Teacher.user_id = User_Detail.user_id  $tsql_where";


      $response2 = mysqli_query($conn, $teacher_Sql);

      $row2 = mysqli_fetch_array($response2);


      $send1['user_name'] = $row2['user_name'];
      $send1['user_sex'] = $row2['user_sex'];
      $send1['user_country'] = $row2['user_country'];
      $send1['user_language'] = $row2['user_language'];


      $send1['teacher_special'] = $row2['teacher_special']; // 강사 전문성


      $send1['user_img'] = $row2['user_img'];

      //Class_List_Time_Price 수업 시간, 가격 확인   

      //최저~최대 가격


      $CLTP_Sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid' and class_price Between 
        $filter_class_price_min and $filter_class_price_max ";
      $response3 = mysqli_query($conn, $CLTP_Sql);

      while ($row2 = mysqli_fetch_array($response3)) {

        $tp['class_time'] = $row2['class_time'];
        $tp['class_price'] = $row2['class_price'];

        array_push($result2['timeprice'], $tp);
      }
      //  echo json_encode($result2);

      $send1['tp'] = $result2['timeprice'];


      if (
        $send1['user_id_teacher'] != null  && $send1['class_id'] != null && $send1['class_name'] != null && $send1['class_description'] != null && $send1['class_people'] != null && $send1['class_type'] != null && $send1['class_level'] != null && $send1['user_name'] != null
        && $send1['user_sex'] != null && $send1['user_country'] != null && $send1['user_language'] != null && $send1['teacher_special'] != null && $send1['user_img'] != null
        && $send1['tp'] != null
      ) {
        array_push($result1['result'], $send1);
      }
      // array_push($result1['result'], $send1);
      $result2['timeprice'] = array();
    }

    if ($response1) { //정상적으로 저장되었을때 

      $result1["success"] = "yes";
      echo json_encode($result1);
      mysqli_close($conn);
    } else {

      $result["success"]   =  "no 값없음";
      echo json_encode($result1);
      mysqli_close($conn);
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

    if ($plus != null) {
      //해당 Class_List 와 Class_Add 에서 값을 가져옴     
      // echo 'yesplus';
      $Student_ReserveClassList_Sql = "SELECT Class_List.*,Class_Add.schedule_list,Class_Add.class_register_status,Class_Add.class_register_answer_date,
      Class_Add.class_register_date,Class_Add.class_time,Class_Add.class_register_id,Class_Add.class_register_method  ,Class_Add.class_register_review
    
      FROM Class_Add LEFT  OUTER JOIN Class_List ON Class_Add.class_id = Class_List.class_id
      $sqlWhere  order by  class_register_id DESC LIMIT $start, $till";
    } else if ($plus == null) {
      // echo 'noplus';
      $Student_ReserveClassList_Sql = "SELECT Class_List.*,Class_Add.schedule_list,Class_Add.class_register_status,Class_Add.class_register_answer_date,
      Class_Add.class_register_date,Class_Add.class_time,Class_Add.class_register_id,Class_Add.class_register_method  ,Class_Add.class_register_review
      
      FROM Class_Add LEFT  OUTER JOIN Class_List ON Class_Add.class_id = Class_List.class_id
       $sqlWhere  order by  class_register_id DESC";
    }



    // echo $Student_ReserveClassList_Sql;





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
        // 'User utc 기준 : 변환  ' . $save = $val + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
        'User utc 기준 : 변환  ' . $save = $val; // user의 timezone을 적용한 값을  $save 저장 
        array_push($splanArray, $save);
      }

      $utc_plan = implode("_", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 


      $send['class_start_time'] = $utc_plan;  //user의 timezone이 적용된 예약한 수업 일정 값 
      $send['class_register_status'] = $row1['class_register_status'];   //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done)
      $answerdate = $row1['10']; //응답한 시간 
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
      $send['user_name'] = $row2['0']; // 강사 이름 
      $send['teacher_special'] = $row2['1']; // 강사 전문성
      $send['user_img'] = $row2['2']; // 강사 이미지 


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
} else if ($kind == 'tclist') {
  // 필요한 값이 특정 강사의 수업 목록 이면 

  $i = 0;
  $start =  $i + (20 * $plus);
  $till = 20;

  if ($clReserveCheck == null) {

    $result3['result'] = array();
    $result1['data'] = array();
    $result2['timeprice'] = array();


    $countSql = "SELECT COUNT(*)AS cnt FROM Class_List WHERE user_id_teacher = '{$user_id_teacher}'  ";
    $countResult = mysqli_query($conn, $countSql);

    $row0 = mysqli_fetch_array($countResult);

    $result3['length']  = $row0['cnt'];



    if ($plus == null) {

      //Class_List에 수업 목록확인  
      $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$user_id_teacher}'  ";
      $response1 = mysqli_query($conn, $sql);
    } else if ($plus != null) {
      //Class_List에 수업 목록확인  
      $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$user_id_teacher}' order by class_id DESC LIMIT $start, $till ";
      $response1 = mysqli_query($conn, $sql);
    }


    while ($row1 = mysqli_fetch_array($response1)) {
      $clid = $row1['0'];


      // $send1['class_id'] = $row1['0'];
      // if ($class_name != null) {
      //   $send1['class_name'] = $row1['2'];
      // } //수업이름
      // if ($class_description != null) {
      //   $send1['class_description'] = $row1['3'];
      // } // 수업 소개 
      // if ($class_people != null) {
      //   $send1['class_people'] = $row1['4'];
      // }
      // if ($class_type != null) {
      //   $send1['class_type'] = $row1['5'];
      // }
      // if ($class_level != null) {
      //   $send1['class_level'] = $row1['6'];
      // }
      $send1['class_id'] = $row1['0'];

      $send1['class_name'] = $row1['2'];


      $send1['class_description'] = $row1['3'];

      $send1['class_people'] = $row1['4'];

      $send1['class_type'] = $row1['5'];

      $send1['class_level'] = $row1['6'];


      //Class_List_Time_Price 수업 시간, 가격 확인   
      $sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";
      $response2 = mysqli_query($conn, $sql);

      while ($row2 = mysqli_fetch_array($response2)) {

        $tp = $row2['3'];

        array_push($result2['timeprice'], $tp);



        $send1['tp'] = $result2['timeprice'];
      }



      array_push($result1['data'], $send1);
      $result2['timeprice'] = array();
    }
    $send['class'] = $result1['data'];


    array_push($result3['result'], $send);
    $result3['page'] = $plus;
    $result3["success"] = "1";
    echo json_encode($result3);
    mysqli_close($conn);
  } else if ($clReserveCheck != null) {
    //강사가 수업신청이 들어온 목록을 확인할때 

    if ($clReserveCheck == 'all') {


      if ($filter_class_status_check != null) {

        if ($filter_class_status_check == 'all') {

          if ($filter_class_resister_time_from != null && $filter_class_resister_time_to != null) {

            $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"' . ' and schedule_list <= ' . '"' . $filter_class_resister_time_to . '"';
          } else if ($filter_class_resister_time_from != null && $filter_class_resister_time_to == null) {

            $sqlWhere =  'where Class_Add.user_id_teacher = ' . $User_ID . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"';
          } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to != null) {


            $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . '  and schedule_list <=  ' . '"' . $filter_class_resister_time_to . '"';
          } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to == null) {
            $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID;
          }
        } else if ($filter_class_status_check  != 'all') {


          if ($filter_class_status_check == 'wait') {
            $filter_clRCValue = '0';
          } else if ($filter_class_status_check == 'approved') {
            $filter_clRCValue = '1';
          } else if ($filter_class_status_check == 'cancel') {
            $filter_clRCValue = '2';
          } else if ($filter_class_status_check == 'done') {
            $filter_clRCValue = '3';
          }

          if ($filter_class_resister_time_from != null && $filter_class_resister_time_to != null) {

            $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_status = ' . $filter_clRCValue . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"' . ' and schedule_list <= ' . '"' . $filter_class_resister_time_to . '"';
          } else if ($filter_class_resister_time_from != null && $filter_class_resister_time_to == null) {

            $sqlWhere =  'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_status = ' . $filter_clRCValue . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"';
          } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to != null) {


            $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_status = ' . $filter_clRCValue . '  and schedule_list <=  ' . '"' . $filter_class_resister_time_to . '"';
          } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to == null) {

            $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_status = ' . $filter_clRCValue;
          }
        }
      } else if ($filter_class_status_check == null) {



        if ($filter_class_resister_time_from != null && $filter_class_resister_time_to != null) {

          $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"' . ' and schedule_list <= ' . '"' . $filter_class_resister_time_to . '"';
        } else if ($filter_class_resister_time_from != null && $filter_class_resister_time_to == null) {

          $sqlWhere =  'where Class_Add.user_id_teacher = ' . $User_ID . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"';
        } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to != null) {


          $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . '  and schedule_list <=  ' . '"' . $filter_class_resister_time_to . '"';
        } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to == null) {
          $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID;
        }
      }
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

      if ($filter_class_resister_time_from != null && $filter_class_resister_time_to != null) {


        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.schedule_list = ' . $clRCValue . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"' . ' and schedule_list <= ' . '"' . $filter_class_resister_time_to . '"';
      } else if ($filter_class_resister_time_from != null && $filter_class_resister_time_to == null) {

        $sqlWhere =  'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.schedule_list = ' . $clRCValue . ' and schedule_list >=   ' . '"' . $filter_class_resister_time_from . '"';
      } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to != null) {


        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.schedule_list = ' . $clRCValue . '  and schedule_list <=  ' . '"' . $filter_class_resister_time_to . '"';
      } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to == null) {
        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.schedule_list = ' . $clRCValue;
      }
    }


    // $timezone = '9'; //사용자(학생)의 TimeZone
    // $timezone2 = +1; //사용자(학생)의 TimeZone




    if ($timezone >= 0) {
      $plus_minus = '+' . $timezone . ':00';
    } else {
      $plus_minus = '' . $timezone . ':00';
    }


    $timezone2 = '"' . "$plus_minus" . '"'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 
    $timezero = '"' . "+00:00" . '"'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 


    $countSql = "SELECT COUNT(*)AS cnt FROM Class_Add  $sqlWhere   order by class_register_id desc  ";
    $countResult = mysqli_query($conn, $countSql);

    $row0 = mysqli_fetch_array($countResult);

    $result['length']  = $row0['cnt'];



    if ($plus == null) {

      $Student_ReserveClassList_Sql = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list , Class_Add.class_register_date, Class_Add.class_register_review, Class_Add.class_register_memo FROM Class_Add  $sqlWhere   order by class_register_id desc  ";
    } else if ($plus != null) {
      $Student_ReserveClassList_Sql = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list , Class_Add.class_register_date, Class_Add.class_register_review, Class_Add.class_register_memo FROM Class_Add  $sqlWhere   order by class_register_id desc LIMIT $start, $till";
    }



    $SRCList_Result = mysqli_query($conn, $Student_ReserveClassList_Sql);

    $result['result'] = array();


    while ($row1 = mysqli_fetch_array($SRCList_Result)) {


      $class_time = $row1['class_time']; //수업 30분  60분  시간 
      $schedule_list = $row1['schedule_list']; //수업상태 

      $hour = 3600000; // 시간의 밀리초     
      // $save = $schedule_list + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
      $save = $schedule_list; // user의 timezone을 적용한 값을  $save 저장 




      $class_id = $row1['class_id']; //수업id


      $filter_class_name2 = '"%' . $filter_class_name . '%"';
      if ($filter_class_name != null) {
        //  $class_name_sqlwhere =  'Class_List.class_id = '  . $class_id .  ' and Class_List.class_name = ' .'"'. $filter_class_name.'"';
        $class_name_sqlwhere =  'Class_List.class_id = '  . $class_id .  ' and Class_List.class_name like ' . $filter_class_name2;
      } else {
        $class_name_sqlwhere =  'Class_List.class_id = '  . $class_id;
      }


      $Sql3 = "SELECT Class_List.class_name FROM Class_List where  $class_name_sqlwhere ";
      $SRCList_Result3 = mysqli_query($conn, $Sql3);

      $row3 = mysqli_fetch_array($SRCList_Result3);


      $user_id_student = $row1['user_id_student']; //예약한 학생의 id 

      $filter_user_name2 = '"%' . $filter_user_name . '%"';
      if ($filter_user_name != null) {
        //  echo '이름 있음 '."</br>";
        $user_name_sqlwhere = 'User_Detail.user_id = ' . $user_id_student . ' and User.user_name  like ' . $filter_user_name2;;
      } else {
        $user_name_sqlwhere =  'User_Detail.user_id = ' . $user_id_student;
      }


      $Sql4 = "SELECT User_Detail.user_id,User_Detail.user_img,User.user_name FROM User_Detail LEFT  OUTER JOIN User ON User_Detail.user_id = User.user_id  where  $user_name_sqlwhere  ";
      $SRCList_Result4 = mysqli_query($conn, $Sql4);

      $row4 = mysqli_fetch_array($SRCList_Result4);



      $Sql5 = "SELECT Class_List_Time_Price.class_price FROM Class_List_Time_Price where Class_List_Time_Price.class_time =  '$class_time'  and Class_List_Time_Price.class_id = '$class_id'";
      $SRCList_Result5 = mysqli_query($conn, $Sql5);

      $row5 = mysqli_fetch_array($SRCList_Result5);



      $send['class_register_id']   = $row1['class_register_id']; //예약한 수업 id 
      $send['class_id'] = $row1['class_id']; //강의 자체 id
      $send['user_id'] = $row4['user_id']; //사용자 이미지 
      $send['user_img'] = $row4['user_img']; //사용자 이미지 
      // $send['user_payment'] = $row4['user_point']; //사용자 페이먼트 링크
      $send['user_name'] = $row4['user_name']; //사용자 이름
      $send['class_name'] = $row3['class_name']; //수업이름
      $send['schedule_list']  = $save; //수업 일정  
      $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간 

      $send['class_register_memo'] = $row1['class_register_memo']; //수업도구


      $send['class_register_method'] = $row1['class_register_method']; //수업도구
      $send['class_register_status'] = $row1['class_register_status']; //수업상태
      $send['class_register_review'] = $row1['class_register_review']; //수업후기 
      $send['class_price'] = $row5['class_price']; //수업가격
      $send['class_register_date'] = $row1['7']; //수업신청일 


      if ($send['class_register_id'] != null &&  $send['class_id'] != null  && $send['user_img'] != null && $send['user_name'] != null && $send['class_name'] != null && $send['schedule_list'] != null && $send['class_time'] != null && $send['class_register_method'] != null && $send['class_register_status'] != null && $send['class_price'] != null && $send['class_register_date'] != null) {
        array_push($result['result'], $send);
      }
    }


    if ($SRCList_Result) { //정상적으로 저장되었을때 

      $result["success"] = "yes";
      $result['page'] = $plus;
      echo json_encode($result);
      mysqli_close($conn);
    } else {

      $result1["success"]   =  "no";
      echo json_encode($result1);
      mysqli_close($conn);
    }
  }
} else if ($kind == 'tcdetail') {



  $result['result'] = array();
  $result1['payment_link'] = array();












  $Sql1 = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_register_review, Class_Add.class_register_review_student,Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list,  Class_Add.class_register_memo   FROM Class_Add where Class_Add.user_id_teacher = '$User_ID' and Class_Add.class_register_id ='$class_register_id'";

  $SRCList_Result1 = mysqli_query($conn, $Sql1);
  $row1 = mysqli_fetch_array($SRCList_Result1);



  $send['class_register_id'] = $row1['class_register_id']; //예약한 수업 id 
  $user_id_student = $row1['user_id_student']; //예약한 학생의 id 


  $send['class_register_method'] = $row1['class_register_method']; //수업도구
  $send['class_register_memo'] = $row1['class_register_memo']; //수업도구
  $send['class_register_status'] = $row1['class_register_status']; //수업상태
  $send['class_register_review'] = $row1['class_register_review']; //강사의 수업리뷰  작성여부 
  $send['class_register_review_student'] = $row1['class_register_review_student']; //학생의 수업리뷰  작성여부


  $send['class_id'] = $row1['class_id']; //강의 자체 id
  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간  


  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간 
  $send['class_price'] = $row1['class_price']; //수업가격
  $class_time = $row1['class_time']; //수업 30분  60분  시간  
  $class_id = $row1['class_id']; //수업id




  $schedule_list = $row1['schedule_list']; //수업상태
  $hour = 3600000; // 시간의 밀리초 
  // $save = $schedule_list + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
  $save = $schedule_list; // user의 timezone을 적용한 값을  $save 저장 
  $send['teacher_schedule_list']  = $save; //수업 일정  
  $send['teacher_timezone']  = $timezone; //수업 일정  


  $Sql2 = "SELECT User_Detail.user_timezone   FROM User_Detail where  User_Detail.user_id = '$user_id_student'";


  $SRCList_Result2 = mysqli_query($conn, $Sql2);
  $row2 = mysqli_fetch_array($SRCList_Result2);
  $send['student_timezone'] = $row2['user_timezone']; //학생 타임존

  $student_timezone = $row2['user_timezone']; //학생 타임존


  // $save = $schedule_list + $student_timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
  $save = $schedule_list; // user의 timezone을 적용한 값을  $save 저장 
  $send['student_schedule_list']  = $save; //수업 일정  




  $Sql3 = "SELECT Class_List_Time_Price.class_price FROM Class_List_Time_Price where Class_List_Time_Price.class_time =  '$class_time'  and Class_List_Time_Price.class_id = '$class_id'";
  $SRCList_Result3 = mysqli_query($conn, $Sql3);

  $row3 = mysqli_fetch_array($SRCList_Result3);

  $send['class_price'] = $row3['class_price']; //수업가격



  $Sql4 = "SELECT Class_List.class_name FROM Class_List where  Class_List.class_id = '$class_id'";
  $SRCList_Result4 = mysqli_query($conn, $Sql4);

  $row4 = mysqli_fetch_array($SRCList_Result4);

  $send['class_name'] = $row4['class_name']; //수업이름




  //Class_List_Time_Price 수업 시간, 가격 확인   
  $Cltp_Sql = "SELECT * FROM Payment_Link WHERE user_id_payment = '$User_ID'";

  $response2 = mysqli_query($conn, $Cltp_Sql);
  while ($row2 = mysqli_fetch_array($response2)) {

    $send1 = $row2['2'];
    array_push($result1['payment_link'], $send1);
  }
  $send['payment_link'] = $result1['payment_link'];





  if ($timezone >= 0) {
    $plus_minus = '+' . $timezone . ':00';
  } else {
    $plus_minus = '' . $timezone . ':00';
  }


  $timezone2 = '"' . "$plus_minus" . '"'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 
  $timezero = '"' . "+00:00" . '"'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 



  //union 사용
  // $teacherStudentReviewSql = "SELECT A.class_teacher_review_id, A.class_register_id, A.teacher_review,A.teacher_review_date,B.class_student_review_id, B.class_register_id, B.student_review, B.student_review_star,B.student_review_date FROM HANGLE.Class_Teacher_Review A left join Class_Student_Review B ON A.class_register_id = B.class_register_id where A.class_register_id ='$class_register_id'
  //    union 
  //   SELECT  A.class_teacher_review_id, A.class_register_id, A.teacher_review,A.teacher_review_date,B.class_student_review_id, B.class_register_id, B.student_review, B.student_review_star,B.student_review_date FROM HANGLE.Class_Student_Review B left join Class_Teacher_Review A ON B.class_register_id = A.class_register_id where B.class_register_id = '$class_register_id'";
  // //union 사용
  $teacherStudentReviewSql = "SELECT A.class_teacher_review_id, A.class_register_id, A.teacher_review, (CONVERT_TZ (A.teacher_review_date, $timezero ,$timezone2))as teacher_review_date,B.class_student_review_id, B.class_register_id, B.student_review, B.student_review_star,(CONVERT_TZ (B.student_review_date, $timezero ,$timezone2))as student_review_date FROM HANGLE.Class_Teacher_Review A left join Class_Student_Review B ON A.class_register_id = B.class_register_id where A.class_register_id ='$class_register_id'
     union 
    SELECT  A.class_teacher_review_id, A.class_register_id, A.teacher_review,(CONVERT_TZ (A.teacher_review_date, $timezero ,$timezone2))as teacher_review_date,B.class_student_review_id, B.class_register_id, B.student_review, B.student_review_star,(CONVERT_TZ (B.student_review_date, $timezero ,$timezone2)) as student_review_date FROM HANGLE.Class_Student_Review B left join Class_Teacher_Review A ON B.class_register_id = A.class_register_id where B.class_register_id = '$class_register_id'";


  $response0 = mysqli_query($conn, $teacherStudentReviewSql);

  $row = mysqli_fetch_array($response0);

  $send['teacher_review'] = $row['teacher_review']; //
  $send['teacher_review_date'] = $row['teacher_review_date']; //
  $send['student_review'] = $row['student_review']; //
  $send['student_review_star'] = $row['student_review_star']; //
  $send['student_review_date'] = $row['student_review_date']; //



















  array_push($result['result'], $send);



  if ($SRCList_Result1) { //정상적으로 저장되었을때 

    $result["success"] = "yes";
    $result["user_name"] = $U_Name;
    echo json_encode($result);
    mysqli_close($conn);
  } else {

    $result["success"]   =  "no";
    echo json_encode($result1);
    mysqli_close($conn);
  }
}
