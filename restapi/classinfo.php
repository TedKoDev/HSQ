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
      'User utc 기준 : 변환  ' . $save = $val + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
      array_push($splanArray, $save);
    }

    $utc_plan = implode("_", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 


    $send['class_start_time'] = $utc_plan;  //user의 timezone이 적용된 예약한 수업 일정 값 


    $send['class_register_memo'] = $row1['class_register_memo']; // 수업메모
    $send['class_register_status'] = $row1['class_register_status'];   //  신청한 수업 상태   
    $send['class_register_review'] = $row1['class_register_review'];   //  신청한 수업 review   
    $send['class_register_method'] = $row1['class_register_method']; // 신청한 수업 진행 방식

    $answerdate = $row1['class_register_answer_date']; //응답한 시간 
    $send['class_register_answer_date'] = $answerdate * 1000;  //응답한 시간 js 에서 밀리초 단위이기 때문에 *1000 적용    

    $send['class_register_date'] = $row1['class_register_date']; // 수업예약 신청한 시간 
    $send['class_id'] = $row1['class_id'];  // 수업 id 
    $send['user_id_teacher'] = $row1['user_id_teacher'];  //강사의 userid
    $send['class_name'] = $row1['class_name']; //
    $send['class_description'] = $row1['class_description']; //
    $send['class_people'] = $row1['class_people']; //
    $send['class_type'] = $row1['class_type']; //
    $send['class_level'] = $row1['class_level']; //


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
      $send['class_id'] = $row1['0']; //수업id
      $send['user_id_teacher'] = $row1['1']; //강사의 userid
      $user_id_teacher = $row1['1']; //강사의 userid
      $send['class_name'] = $row1['2']; //수업 이름
      $send['class_description'] = $row1['3']; // 수업 설명
      $send['class_people'] = $row1['4']; // 수업인원
      $send['class_type'] = $row1['5']; // 수업 종류
      $send['class_level'] = $row1['6']; // 수업 레벨 
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
      $send['class_register_status'] = $row1['9'];   //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done)
      $answerdate = $row1['10']; //응답한 시간 
      $send['class_register_answer_date'] = $answerdate * 1000;  //응답한 시간 js 에서 밀리초 단위이기 때문에 *1000 적용      
      $send['class_register_date'] = $row1['11']; // 수업예약 신청한 시간 
      $send['class_time'] = $row1['12']; // 수업 시간 (30분, 60분)
      $send['class_register_id'] = $row1['13']; // 신청한 수업 리스트의 idx 값
      $send['class_register_method'] = $row1['14']; // 신청한 수업 진행 방식
      $send['class_register_review'] = $row1['15']; // 신청한 수업 진행 방식


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
  if ($clReserveCheck == null) {

    $result3['result'] = array();
    $result1['data'] = array();
    $result2['timeprice'] = array();




    //Class_List에 수업 목록확인  
    $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$user_id_teacher}'";
    $response1 = mysqli_query($conn, $sql);



    while ($row1 = mysqli_fetch_array($response1)) {
      $clid = $row1['0'];


      $send1['class_id'] = $row1['0'];
      if ($class_name != null) {
        $send1['class_name'] = $row1['2'];
      } //수업이름
      if ($class_description != null) {
        $send1['class_description'] = $row1['3'];
      } // 수업 소개 
      if ($class_people != null) {
        $send1['class_people'] = $row1['4'];
      }
      if ($class_type != null) {
        $send1['class_type'] = $row1['5'];
      }
      if ($class_level != null) {
        $send1['class_level'] = $row1['6'];
      }

      if ($class_price != null) {
        //Class_List_Time_Price 수업 시간, 가격 확인   
        $sql = "SELECT * FROM Class_List_Time_Price WHERE class_id = '$clid'";
        $response2 = mysqli_query($conn, $sql);

        while ($row2 = mysqli_fetch_array($response2)) {

          $tp = $row2['3'];

          array_push($result2['timeprice'], $tp);
        }


        $send1['tp'] = $result2['timeprice'];
      }



      array_push($result1['data'], $send1);
      $result2['timeprice'] = array();
    }
    $send['class'] = $result1['data'];
    array_push($result3['result'], $send);
    $result3["success"] = "1";
    echo json_encode($result3);
    mysqli_close($conn);


  } else if ($clReserveCheck != null) {
    //강사가 수업신청이 들어온 목록을 확인할때 

    if ($clReserveCheck == 'all') {

      if ($filter_class_resister_time_from != null && $filter_class_resister_time_to != null) {

        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and class_register_date >=   ' . $filter_class_resister_time_from . ' and class_register_date <= ' . $filter_class_resister_time_to;
      } else if ($filter_class_resister_time_from != null && $filter_class_resister_time_to == null) {

        $sqlWhere =  'where Class_Add.user_id_teacher = ' . $User_ID . ' and class_register_date >=   ' . $filter_class_resister_time_from;
      } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to != null) {


        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . '  and class_register_date <=  ' . $filter_class_resister_time_to;
      } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to == null) {
        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID;
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


        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_date = ' . $clRCValue . ' and class_register_date >=   ' . $filter_class_resister_time_from . ' and class_register_date <= ' . $filter_class_resister_time_to;
      } else if ($filter_class_resister_time_from != null && $filter_class_resister_time_to == null) {

        $sqlWhere =  'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_date = ' . $clRCValue . ' and class_register_date >=   ' . $filter_class_resister_time_from;
      } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to != null) {


        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_date = ' . $clRCValue . '  and class_register_date <=  ' . $filter_class_resister_time_to;
      } else if ($filter_class_resister_time_from == null && $filter_class_resister_time_to == null) {
        $sqlWhere = 'where Class_Add.user_id_teacher = ' . $User_ID . ' and Class_Add.class_register_date = ' . $clRCValue;
      }
    }


    // $timezone = '-9'; //사용자(학생)의 TimeZone
    // $timezone2 = +1; //사용자(학생)의 TimeZone




    if ($timezone >= 0) {
      $plus_minus = '+';
    } else {
      $plus_minus = '';
    }


    $timezone2 =  $plus_minus . $timezone . ':00'; //수업이 신청된 시간에 timezone을 적용하여 출력함. 



    $Student_ReserveClassList_Sql = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list , CONVERT_TZ (Class_Add.class_register_date, '+00:00','$timezone2'), Class_Add.class_register_review FROM Class_Add  $sqlWhere   order by class_register_id desc ";


    $SRCList_Result = mysqli_query($conn, $Student_ReserveClassList_Sql);

    $result['result'] = array();


    while ($row1 = mysqli_fetch_array($SRCList_Result)) {


      $class_time = $row1['class_time']; //수업 30분  60분  시간 
      $schedule_list = $row1['schedule_list']; //수업상태 

      $hour = 3600000; // 시간의 밀리초     
      $save = $schedule_list + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 




      $class_id = $row1['class_id']; //수업id


      if ($filter_class_name != null) {
        $class_name_sqlwhere =  'Class_List.class_id = '  . $class_id .  ' and Class_List.class_name = ' . $filter_class_name;
      } else {
        $class_name_sqlwhere =  'Class_List.class_id = '  . $class_id;
      }


      $Sql3 = "SELECT Class_List.class_name FROM Class_List where  $class_name_sqlwhere ";
      $SRCList_Result3 = mysqli_query($conn, $Sql3);

      $row3 = mysqli_fetch_array($SRCList_Result3);



      if ($filter_user_name != null) {
        $user_name_sqlwhere = 'User_Detail.user_id = ' . $user_id_student . ' and User.user_name = ' . $filter_user_name;
      } else {
        $user_name_sqlwhere =  'User_Detail.user_id = ' . $user_id_student;
      }


      $user_id_student = $row1['user_id_student']; //예약한 학생의 id 
      $Sql4 = "SELECT User_Detail.user_img, User.user_name FROM User_Detail LEFT  OUTER JOIN User ON User_Detail.user_id = User.user_id  where   $user_name_sqlwhere ";
      $SRCList_Result4 = mysqli_query($conn, $Sql4);

      $row4 = mysqli_fetch_array($SRCList_Result4);



      $Sql5 = "SELECT Class_List_Time_Price.class_price FROM Class_List_Time_Price where Class_List_Time_Price.class_time =  '$class_time'  and Class_List_Time_Price.class_id = '$class_id'";
      $SRCList_Result5 = mysqli_query($conn, $Sql5);

      $row5 = mysqli_fetch_array($SRCList_Result5);



      $send['class_register_id']   = $row1['class_register_id']; //예약한 수업 id 
      $send['class_id'] = $row1['class_id']; //강의 자체 id
      $send['user_img'] = $row4['user_img']; //사용자 이미지 
      $send['user_name'] = $row4['user_name']; //사용자 이름
      $send['class_name'] = $row3['class_name']; //수업이름
      $send['schedule_list']  = $save; //수업 일정  
      $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간 
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
      echo json_encode($result);
      mysqli_close($conn);
    } else {

      $result["success"]   =  "no";
      echo json_encode($result);
      mysqli_close($conn);
    }
  }
} else if ($kind == 'tcdetail') {




  $Sql1 = "SELECT Class_Add.class_register_id, Class_Add.user_id_student, Class_Add.class_register_method, Class_Add.class_register_status, Class_Add.class_register_review, Class_Add.class_id, Class_Add.class_time, Class_Add.schedule_list  FROM Class_Add where Class_Add.user_id_teacher = '$User_ID' and Class_Add.class_register_id ='$class_register_id'";


  $SRCList_Result1 = mysqli_query($conn, $Sql1);
  $row1 = mysqli_fetch_array($SRCList_Result1);

  $result['result'] = array();

  $send['class_register_id'] = $row1['class_register_id']; //예약한 수업 id 
  $user_id_student = $row1['user_id_student']; //예약한 학생의 id 


  $send['class_register_method'] = $row1['class_register_method']; //수업도구
  $send['class_register_status'] = $row1['class_register_status']; //수업상태
  $send['class_register_review'] = $row1['class_register_review']; //수업리뷰 상태 
  $send['class_id'] = $row1['class_id']; //강의 자체 id
  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간  

  $send['schedule_list']  = $save; //수업 일정  
  $send['class_time'] = $row1['class_time']; //수업 30분  60분  시간 
  $send['class_price'] = $row1['class_price']; //수업가격
  $class_time = $row1['class_time']; //수업 30분  60분  시간  
  $class_id = $row1['class_id']; //수업id




  $schedule_list = $row1['schedule_list']; //수업상태
  $hour = 3600000; // 시간의 밀리초 
  $save = $schedule_list + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
  $send['teacher_schedule_list']  = $save; //수업 일정  
  $send['teacher_timezone']  = $timezone; //수업 일정  


  $Sql2 = "SELECT User_Detail.user_timezone  FROM User_Detail where  User_Detail.user_id = '$user_id_student'";
  $SRCList_Result2 = mysqli_query($conn, $Sql2);
  $row2 = mysqli_fetch_array($SRCList_Result2);
  $send['student_timezone'] = $row2['user_timezone']; //학생 타임존
  $student_timezone = $row2['user_timezone']; //학생 타임존


  $save = $schedule_list + $student_timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
  $send['student_schedule_list']  = $save; //수업 일정  




  $Sql3 = "SELECT Class_List_Time_Price.class_price FROM Class_List_Time_Price where Class_List_Time_Price.class_time =  '$class_time'  and Class_List_Time_Price.class_id = '$class_id'";
  $SRCList_Result3 = mysqli_query($conn, $Sql3);

  $row3 = mysqli_fetch_array($SRCList_Result3);

  $send['class_price'] = $row3['class_price']; //수업가격



  $Sql4 = "SELECT Class_List.class_name FROM Class_List where  Class_List.class_id = ' $class_id'";
  $SRCList_Result4 = mysqli_query($conn, $Sql4);

  $row4 = mysqli_fetch_array($SRCList_Result4);

  $send['class_name'] = $row4['class_name']; //수업이름




  array_push($result['result'], $send);



  if ($SRCList_Result1) { //정상적으로 저장되었을때 

    $result["success"] = "yes";
    echo json_encode($result);
    mysqli_close($conn);
  } else {

    $result["success"]   =  "no";
    echo json_encode($result1);
    mysqli_close($conn);
  }
}
