<?php

/***
강사정보  RestAPI
teacherinfo.php
분기 조건 
1. teacher userid가 있다/없다.
2. 항목 별 값이 있다/없다. 
출력정보  
1. 강사상세  (강사명, 강사이미지, 강사 자기소개, 자기소개, 강사국가, 강사 거주지, 강사 전문성, 강사언어)
{"timg"};     // 강사이미지
{"tname"};    // 강사이름
{"tintro"};    // 강사자기소개
{"intro"};    // 자기소개
{"tcountry"};    // 강사국가
{"tresidence"};    // 강사거주지
{"tspecial"};    // 강사전문성
{"tlanguage"};    // 강사언어 
2. 강사목록  (강사명, 및 기타 정보  + plus 가 있는경우 페이징 동작함)
수업이 있는 강사만 출력함.
 
 */



include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$tusid      =   json_decode(file_get_contents("php://input"))->{"user_id_teacher"}; // 선택된 강사의 userid 
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"}; // utc 


$timg           =   json_decode(file_get_contents("php://input"))->{"teacher_img"};     // 강사이미지
$tname          =   json_decode(file_get_contents("php://input"))->{"teacher_name"};    // 강사이름
$tintro         =   json_decode(file_get_contents("php://input"))->{"teacher_intro"};    // 강사자기소개
$intro          =   json_decode(file_get_contents("php://input"))->{"user_intro"};    // 자기소개
$tcountry       =   json_decode(file_get_contents("php://input"))->{"teacher_country"};    // 강사국가
$tresidence     =   json_decode(file_get_contents("php://input"))->{"teacher_residence"};    // 강사거주지
$tspecial       =   json_decode(file_get_contents("php://input"))->{"teacher_special"};    // 강사전문성
$tlanguage      =   json_decode(file_get_contents("php://input"))->{"teacher_language"};    // 강사언어 



$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"class_reserve_check"}; //  현재는 미사용 
//수업찾기 필터 
$filter_check                = json_decode(file_get_contents("php://input"))->{"filter_check"};    // 필터사용유무
$filter_search               = json_decode(file_get_contents("php://input"))->{"filter_search"};    // 검색어 필터 (수업명, 수업설명부분 필터 )
$filter_class_type           = json_decode(file_get_contents("php://input"))->{"filter_class_type"};    //  수업타입 필터 
$filter_class_price_min      = json_decode(file_get_contents("php://input"))->{"filter_class_price_min"};    // 최저가격
$filter_class_price_max      = json_decode(file_get_contents("php://input"))->{"filter_class_price_max"};    // 최대가격
$filter_teacher_special      = json_decode(file_get_contents("php://input"))->{"filter_teacher_special"};    // 강사 전문가 여부
$filter_teacher_country      = json_decode(file_get_contents("php://input"))->{"filter_teacher_country"};    // 강사 출신국가 
$filter_teacher_sex          = json_decode(file_get_contents("php://input"))->{"filter_teacher_sex"};        // 강사성별
$filter_teacher_language     = json_decode(file_get_contents("php://input"))->{"filter_teacher_language"};   // 강사 사용언어  


$filter_date           = json_decode(file_get_contents("php://input"))->{"filter_date"};   // 수업 일자   
$filter_time           = json_decode(file_get_contents("php://input"))->{"filter_time"};   // 수업 일자   





if ($filter_class_price_min == null) {
  $filter_class_price_min = 0;
}

if ($filter_class_price_min == null) {
  $filter_class_price_max = 100000;
}



//강사 찾기 필터 테스트용 
// $filter_check      = 'ok(아무값)';
// $clReserveCheck = null;
// $filter_search      = '홍';    // 검색어 필터 (강사명, 강사소개 필터 )
// $filter_class_price_min = 0 ;
// $filter_class_price_max = 100;
// $filter_teacher_special = 'default'; // 커뮤니티 강사 
// $filter_teacher_special = 'notdefault'; // 전문 강사 
// $filter_class_type = array("회화 연습", "듣기");

// $filter_class_type = array("발음");
// $filter_teacher_sex  = '남성';
// $filter_teacher_country = '중국';
// $filter_teacher_language = array("러시아어", "스페인어");


// $filter_date = array("1671517800000","1671521400000","1671517800000","1671521400000");

// $filter_time = array("0", "1", "2", "3", "4", "5", "6", "7", "10");
// $filter_date = "1671517800000";








$plus   =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 



$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"};  //유저의 로컬 타임존 
// $utc      =   9;  //유저의 로컬 타임존 










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



// 강사상세 출력인지 목록 출력인지 
if ($tusid != null) {
  //해당 tusid에 해당하는 상세정보를 가져옴 
  //tusid 가 있으면 작동


  //배열생성 
  $result3['result'] = array();
  $result1['data'] = array();
  $result2['timeprice'] = array();



  //Class_List에 수업 목록확인  
  $sql = "SELECT 
               User.user_name, 
               User_Teacher.teacher_special,  
               User_Detail.user_img,
               User_Detail.user_language,
               User_Detail.user_intro,
               User_Teacher.teacher_intro ,
               User_Detail.user_country,
               User_Detail.user_residence
               FROM User
               JOIN User_Detail
                 ON User.user_id = User_Detail.user_id
               JOIN User_Teacher
       ON User_Teacher.user_id = User_Detail.user_id 
      where User.user_id = '$tusid' ";
  $response1 = mysqli_query($conn, $sql);



  $row1 = mysqli_fetch_array($response1);

  $send['user_name'] = $row1['user_name'];

  $send['teacher_special'] = $row1['teacher_special'];

  $send['user_img'] = $row1['user_img'];
  $send['user_language'] = $row1['user_language'];
  $send['user_intro'] = $row1['user_intro'];
  $send['teacher_intro'] = $row1['teacher_intro'];
  $send['user_country'] = $row1['user_country'];
  $send['user_residence'] = $row1['user_residence'];



  array_push($result3['result'], $send);
  // $result1["success"] = "1";
  $result3["success"] = "1";
  echo json_encode($result3);




  mysqli_close($conn);
} else {
  //tusid 가 없으면 작동 전체 목록 




  $i = 0;




  $start =  $i + (20 * $plus);
  $till = 20;







  if ($clReserveCheck == null) {

    if ($filter_check == null) {
      //Class_List에 수업 목록확인  



      $sql = "SELECT * FROM User_Teacher order by  user_teacher_id DESC LIMIT $start, $till ";
      $response1 = mysqli_query($conn, $sql);




      $result1['data'] = array();
      while ($row1 = mysqli_fetch_array($response1)) {
        $tusid = $row1['user_id'];

        $send['user_id'] = $row1['user_id'];
        $send['teacher_intro'] = $row1['teacher_intro'];
        $send['teacher_special'] = $row1['teacher_special'];


        //User_Detail 에서 이미지, 언어 수업 시간, 가격 확인   
        $sql = "SELECT * FROM User_Detail WHERE user_id = '$tusid'";
        $response2 = mysqli_query($conn, $sql);

        $row2 = mysqli_fetch_array($response2);

        $send['user_img'] = $row2['user_img'];
        $send['user_language'] = $row2['user_language'];
        $send['user_intro'] = $row2['user_intro'];

        //User 에서 유저 이름    
        $sql = "SELECT * FROM User WHERE user_id = '$tusid'";
        $response3 = mysqli_query($conn, $sql);

        $row3 = mysqli_fetch_array($response3);

        $send['user_name'] = $row3['3'];





        // Class_List에 수업 목록확인   강사의 수업이 있는지 확인하는 절차 없으면 넣지않으려함 .
        $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$tusid}'";
        $response4 = mysqli_query($conn, $sql);

        $row4 = mysqli_fetch_array($response4);
        $clid = $row4['class_id'];
        $send['class_id'] = $row4['class_id'];


        //Class_List_Time_Price 수업 시간, 가격 확인   
        $sql = "SELECT Class_List_Time_Price.class_id, Class_List_Time_Price.class_time, Class_List_Time_Price.class_price FROM HANGLE.Class_List Join Class_List_Time_Price 
      On Class_List.class_id = Class_List_Time_Price.class_id where Class_List.user_id_teacher = '{$tusid}' order by Class_List_Time_Price.class_price asc limit 1";

        $response5 = mysqli_query($conn, $sql);

        $row5 = mysqli_fetch_array($response5);
        $send['class_time'] = $row5['class_time'];
        $send['class_price'] = $row5['class_price'];

        if ($send['class_id'] != null) { // 수업이 없는 것은 넣지 않는다. 
          array_push($result1['data'], $send);
        }
      }


      $result1["success"] = "1";
      echo json_encode($result1);

      mysqli_close($conn);
    } else if ($filter_check != null) {
      //Class_List에 수업 목록확인  
      // echo '필터체크 진입 ';

      if ($filter_date != null || $filter_time != null) {


        // $filter_date =  1671667200000;
        $hour = 3600000;
        $halfhour = 3600000 / 2;
        // $day =  3600000*24;

        $day = 86400000;

        $filter_hour_array1 = array(); // 배열 설정.

        //날짜만 있을때 
        if ($filter_date != null && $filter_time == null) {
          // echo '날짜만있음';
          //전달받은 $filter_date 에 timezone을 채크해서 hour을 적용해 utc 0 기준으로 바꾼다.

          $filter_date_utc_zero1 = $filter_date - ($hour * $timezone); // user의 timezone을 적용해서 utc 0 기준으로 변경 
          $filter_date_utc_zero2 = $filter_date_utc_zero1 + $day - 1; // user의 timezone을 적용해서 utc 0 기준으로 변경한 값의 24시간을 더한 값


          $filter_hour_add3  = 'schedule_list between ' . $filter_date_utc_zero1 . ' and ' . $filter_date_utc_zero2;

          //시간대만 있을때 
        } else if ($filter_date == null && $filter_time != null) {


          // echo '시간만있음';
          // utc 0 기준 당일날짜값 timestamp 가져온뒤 프론트에 맞춰 1000 곱해주기 
          $today = strtotime(date("Y-m-d")) * 1000;


          $explode_filter_time = $filter_time;


          $filter_hour_array1 = array(); //검사 해야할 시간 기준 



          foreach ($explode_filter_time as $val) {



            $오늘날짜더하기시간값 = $today + $val * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로   
            $오늘날짜더하기시간값더하기한시간 = $오늘날짜더하기시간값 + $hour - 1; // 3을 선택한경우 3시부터 4시 사이의 값이 필요하기때문에 한시간을 더해줌 

            $filter_date_i = '(schedule_list between ' . '"' . $오늘날짜더하기시간값  . '"' . ' and ' . '"' . $오늘날짜더하기시간값더하기한시간  . '")'; // user의 timezone을 적용한 값을  $save 저장 
            array_push($filter_hour_array1, $filter_date_i);
          }



          $filter_hour_add2 = implode(" or ", $filter_hour_array1); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_hour_add3  =  $filter_hour_add2;



          //날짜와 시간이 모두 있을 때 
        } else if ($filter_date != null && $filter_time != null) {

          // echo '둘다있음';

          $explode_filter_time = $filter_time;

          $filter_hour_array1 = array(); //검사 해야할 시간 기준 



          foreach ($explode_filter_time as $val) {


            $날짜에시간을더함 = $filter_date + $val * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로
            $날짜에시간을더함더하기한시간 = $날짜에시간을더함 + $hour - 1; // 3을 선택한경우 3시부터 4시 사이의 값이 필요하기때문에 한시간을 더해줌

            $filter_date_i = '(schedule_list between ' . '"' . $날짜에시간을더함  . '"' . ' and ' . '"' . $날짜에시간을더함더하기한시간  . '")'; // user의 timezone을 적용한 값을  $save 저장 
            array_push($filter_hour_array1, $filter_date_i);
          }



          $filter_hour_add2 = implode(" or ", $filter_hour_array1); // 담긴 배열을 _기준으로 스트링으로 저장 
          $filter_hour_add3  =  $filter_hour_add2;
        }


        $filter_hour_add3;

        //  $sql = "SELECT DISTINCT * FROM (select DISTINCT User.user_id, User.user_name, User_Teacher.teacher_intro, User_Teacher.teacher_special from User
        // JOIN User_Detail
        // ON User.user_id = User_Detail.user_id
        // JOIN User_Teacher
        // ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
        //    ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id JOIN Class_List ON Class_List.user_id_teacher = User_Teacher.user_id   WHERE $filter_hour_add3) AS new_userlist  order by  user_id  DESC           LIMIT $start, $till";





        if ($filter_teacher_special != null) {
          $filter_teacher_special_val = '"' . $filter_teacher_special . '"';
        } else if ($filter_teacher_special == null) {
          $filter_teacher_special_val = "'%default%'";
        }


        $tsql_where = " teacher_special like  $filter_teacher_special_val ";



        // 강사 전문여부 
        //   $sql = "SELECT * FROM User
        //  JOIN User_Detail
        //    ON User.user_id = User_Detail.user_id
        //  JOIN User_Teacher
        //    ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
        //       ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id where $tsql_where order by  user_teacher_id DESC LIMIT $start, $till ";
        //   $response1 = mysqli_query($conn, $sql);


        $sql = "SELECT DISTINCT * FROM (select DISTINCT User.user_id, User.user_name, User_Teacher.teacher_intro, User_Teacher.teacher_special from User
              JOIN User_Detail
              ON User.user_id = User_Detail.user_id
              JOIN User_Teacher
              ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
                 ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id JOIN Class_List ON Class_List.user_id_teacher = User_Teacher.user_id   WHERE $filter_hour_add3) AS new_userlist where $tsql_where order by            user_id  DESC LIMIT $start, $till";
        $response1 = mysqli_query($conn, $sql);






        if ($filter_search != null) {



          $tsql_where = "$tsql_where  and user_name LIKE '%$filter_search%' 
                      or teacher_intro LIKE '%$filter_search%' ";


          $sql = "SELECT DISTINCT * FROM (select DISTINCT User.user_id, User.user_name, User_Teacher.teacher_intro, User_Teacher.teacher_special from User
                      JOIN User_Detail
                      ON User.user_id = User_Detail.user_id
                      JOIN User_Teacher
                      ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
                         ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id JOIN Class_List ON Class_List.user_id_teacher = User_Teacher.user_id   WHERE $filter_hour_add3) AS new_userlist where $tsql_where           order by  user_id  DESC LIMIT $start, $till";

          //   $sql = "SELECT * FROM User
          // JOIN User_Detail
          //   ON User.user_id = User_Detail.user_id
          // JOIN User_Teacher
          //   ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
          //      ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id where $tsql_where" ;



          $response1 = mysqli_query($conn, $sql);
        }
      } else if ($filter_date == null &&  $filter_time == null) {

        if ($filter_teacher_special != null) {
          $filter_teacher_special_val = '"' . $filter_teacher_special . '"';
        } else if ($filter_teacher_special == null) {
          $filter_teacher_special_val = "'%default%'";
        }


        $tsql_where = " teacher_special like  $filter_teacher_special_val ";


        // 강사 전문여부 
        $sql = "SELECT * FROM User
       JOIN User_Detail
         ON User.user_id = User_Detail.user_id
       JOIN User_Teacher
         ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
            ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id where $tsql_where order by  user_teacher_id DESC LIMIT $start, $till ";
        $response1 = mysqli_query($conn, $sql);


        if ($filter_search != null) {

          //Class_List에 수업 목록확인  
          $sql =  "SELECT * FROM User
          JOIN User_Detail
            ON User.user_id = User_Detail.user_id
          JOIN User_Teacher
            ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
               ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id where $tsql_where  and user_name LIKE '%$filter_search%' 
          or teacher_intro LIKE '%$filter_search%' order by  user_teacher_id DESC LIMIT $start, $till ";
          $response1 = mysqli_query($conn, $sql);
        }
      }

      //       echo "결말";

      //  echo $sql;


      $result1['data'] = array();
      while ($row1 = mysqli_fetch_array($response1)) {


        $tusid = $row1['user_id'];




        $tsql_where = " ";
        if ($filter_teacher_language != null) {
          $explode_filter_teacher_language = $filter_teacher_language; // 배열 형태 분해 
          $splanArray = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_teacher_language as $val) {

            $filter_teacher_language_i = ' user_language  like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($splanArray, $filter_teacher_language_i);
          }

          $filter_teacher_language_i_add = implode(" or ", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_teacher_language_i_val = $filter_teacher_language_i_add;

          $tsql_where = "  $tsql_where and $filter_teacher_language_i_val ";
        }


        // 성별
        if ($filter_teacher_sex != null) {
          $filter_teacher_sex_val = '"' . $filter_teacher_sex . '"';
        } else if ($filter_teacher_sex == null) {
          $filter_teacher_sex_val = "'%성%'";
        }

        $tsql_where = "  $tsql_where and user_sex like  $filter_teacher_sex_val ";






        if ($filter_teacher_country != null) {
          $tsql_where = "  $tsql_where and  user_country = '$filter_teacher_country'";
        }




        // 수업타입 
        if ($filter_class_type != null) {
          // $explode_filter_class_type = (explode(",", $filter_class_type)); // _기준으로 string 분해 
          $explode_filter_class_type = $filter_class_type; // _기준으로 string 분해 
          $class_type_array = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_class_type as $val) {

            $filter_class_type_i = '  class_type like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($class_type_array, $filter_class_type_i);
          }

          $filter_class_type_add = implode(" or ", $class_type_array); // 담긴 배열을 _기준으로 스트링으로 저장 

          $tsql_where = $tsql_where . '  and ' .  $filter_class_type_add;
        }



        $teacher_Sql = "SELECT 
         *
      FROM User
      JOIN User_Detail
        ON User.user_Id = User_Detail.user_Id
      JOIN User_Teacher
        ON User_Teacher.user_id = User_Detail.user_Id 
        JOIN Class_List
        ON Class_List.user_id_teacher = User_Teacher.user_id 

      where User.user_Id = '$tusid' $tsql_where ";



        $response2 = mysqli_query($conn, $teacher_Sql);

        $row2 = mysqli_fetch_array($response2);


        $clid = $row2['class_id'];








        //Class_List_Time_Price 수업 시간, 가격 확인   
        $sql = "SELECT Class_List_Time_Price.class_id, Class_List_Time_Price.class_time, Class_List_Time_Price.class_price FROM HANGLE.Class_List Join Class_List_Time_Price 
      On Class_List.class_id = Class_List_Time_Price.class_id where Class_List.user_id_teacher = '{$tusid}'  and class_price Between 
        $filter_class_price_min and $filter_class_price_max order by Class_List_Time_Price.class_price asc limit 1";

        $response5 = mysqli_query($conn, $sql);

        $row5 = mysqli_fetch_array($response5);


        $send['user_id'] = $row1['user_id'];
        $send['teacher_intro'] = $row1['teacher_intro'];
        $send['teacher_special'] = $row1['teacher_special'];

        $send['user_img'] = $row2['user_img'];
        $send['user_language'] = $row2['user_language'];
        $send['user_intro'] = $row2['user_intro'];
        $send['user_sex'] = $row2['user_sex'];

        $send['class_type'] = $row2['class_type'];
        $send['class_level'] = $row2['class_level'];
        $send['user_name'] = $row2['user_name'];

        $send['class_id'] = $row2['class_id'];
        $send['class_time'] = $row5['class_time'];
        $send['class_price'] = $row5['class_price'];

        if ($send['class_id'] != null && $send['user_id'] != null && $send['teacher_intro'] != null && $send['teacher_special'] != null && $send['user_img'] != null && $send['user_language'] != null && $send['user_intro'] != null && $send['user_name'] != null && $send['class_id'] != null && $send['class_time'] != null && $send['class_price'] != null && $send['class_type'] != null && $send['class_level'] != null && $send['user_sex'] != null) { // 수업이 없는 것은 넣지 않는다. 
          array_push($result1['data'], $send);
        }
      }


      if ($response5) { //정상적으로 저장되었을때 

        $result1["success"] = "yes";
        echo json_encode($result1);
        mysqli_close($conn);
      } else {

        $result1["success"] = "no";
        echo json_encode($result1);
        mysqli_close($conn);
      }
    }
  } else if ($clReserveCheck != null) {

    if ($filter_check == null) {
      //Class_List에 수업 목록확인  
      $sql = "SELECT * FROM User_Teacher order by  user_teacher_id DESC LIMIT $start, $till ";
      $response1 = mysqli_query($conn, $sql);


      $result1['data'] = array();
      while ($row1 = mysqli_fetch_array($response1)) {
        $tusid = $row1['user_id'];

        $send['user_id'] = $row1['user_id'];
        $send['teacher_intro'] = $row1['teacher_intro'];
        $send['teacher_special'] = $row1['teacher_special'];


        //User_Detail 에서 이미지, 언어 수업 시간, 가격 확인   
        $sql = "SELECT * FROM User_Detail WHERE user_id = '$tusid'";
        $response2 = mysqli_query($conn, $sql);

        $row2 = mysqli_fetch_array($response2);

        $send['user_img'] = $row2['user_img'];
        $send['user_language'] = $row2['user_language'];
        $send['user_intro'] = $row2['user_intro'];

        //User 에서 유저 이름    
        $sql = "SELECT * FROM User WHERE user_id = '$tusid'";
        $response3 = mysqli_query($conn, $sql);

        $row3 = mysqli_fetch_array($response3);

        $send['user_name'] = $row3['3'];





        // Class_List에 수업 목록확인   강사의 수업이 있는지 확인하는 절차 없으면 넣지않으려함 .
        $sql = "SELECT * FROM Class_List WHERE user_id_teacher = '{$tusid}'";
        $response4 = mysqli_query($conn, $sql);

        $row4 = mysqli_fetch_array($response4);
        $clid = $row4['class_id'];
        $send['class_id'] = $row4['class_id'];


        //Class_List_Time_Price 수업 시간, 가격 확인   
        $sql = "SELECT Class_List_Time_Price.class_id, Class_List_Time_Price.class_time, Class_List_Time_Price.class_price FROM HANGLE.Class_List Join Class_List_Time_Price 
      On Class_List.class_id = Class_List_Time_Price.class_id where Class_List.user_id_teacher = '{$tusid}' order by Class_List_Time_Price.class_price asc limit 1";

        $response5 = mysqli_query($conn, $sql);

        $row5 = mysqli_fetch_array($response5);
        $send['class_time'] = $row5['class_time'];
        $send['class_price'] = $row5['class_price'];

        if ($send['class_id'] != null) { // 수업이 없는 것은 넣지 않는다. 
          array_push($result1['data'], $send);
        }
      }


      $result1["success"] = "1";
      echo json_encode($result1);

      mysqli_close($conn);
    } else if ($filter_check != null) {
      //Class_List에 수업 목록확인  



      if ($filter_teacher_special != null) {
        $filter_teacher_special_val = '"' . $filter_teacher_special . '"';
      } else if ($filter_teacher_special == null) {
        $filter_teacher_special_val = "'%default%'";
      }


      $tsql_where = " teacher_special like  $filter_teacher_special_val ";


      // 강사 전문여부 
      $sql = "SELECT * FROM User_Teacher where $tsql_where order by  user_teacher_id DESC LIMIT $start, $till ";
      $response1 = mysqli_query($conn, $sql);


      $result1['data'] = array();
      while ($row1 = mysqli_fetch_array($response1)) {


        $tusid = $row1['user_id'];




        $tsql_where = " ";
        if ($filter_teacher_language != null) {

          $explode_filter_teacher_language = $filter_teacher_language; // _기준으로 string 분해 
          $splanArray = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_teacher_language as $val) {

            $filter_teacher_language_i = ' user_language  like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($splanArray, $filter_teacher_language_i);
          }

          $filter_teacher_language_i_add = implode(" or ", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 

          $filter_teacher_language_i_val = $filter_teacher_language_i_add;

          $tsql_where = "  $tsql_where and $filter_teacher_language_i_val ";
        }


        // 성별
        if ($filter_teacher_sex != null) {
          $filter_teacher_sex_val = '"' . $filter_teacher_sex . '"';
        } else if ($filter_teacher_sex == null) {
          $filter_teacher_sex_val = "'%성%'";
        }

        $tsql_where = "  $tsql_where and user_sex like  $filter_teacher_sex_val ";






        if ($filter_teacher_country != null) {
          $tsql_where = "  $tsql_where and  user_country = '$filter_teacher_country'";
        }


        // 수업타입 
        if ($filter_class_type != null) {
          //  $explode_filter_class_type = (explode("_", $filter_class_type)); // _기준으로 string 분해 
          $explode_filter_class_type = $filter_class_type; // _기준으로 string 분해 
          $class_type_array = array(); // utc 적용한 값 담을 배열 
          foreach ($explode_filter_class_type as $val) {


            $filter_class_type_i = '  class_type like ' . '"%' . $val . '%"'; // user의 timezone을 적용한 값을  $save 저장 


            array_push($class_type_array, $filter_class_type_i);
          }

          $filter_class_type_add = implode(" or ", $class_type_array); // 담긴 배열을 _기준으로 스트링으로 저장 

          $tsql_where = $tsql_where . '  and ' .  $filter_class_type_add;
        }




        $teacher_Sql = "SELECT 
    *
      FROM User
      JOIN User_Detail
        ON User.user_Id = User_Detail.user_Id
      JOIN User_Teacher
        ON User_Teacher.user_id = User_Detail.user_Id 
        JOIN Class_List
        ON Class_List.user_id_teacher = User_Teacher.user_id 

      where User.user_Id = '$tusid' $tsql_where ";



        $response2 = mysqli_query($conn, $teacher_Sql);

        $row2 = mysqli_fetch_array($response2);


        $clid = $row2['class_id'];








        //Class_List_Time_Price 수업 시간, 가격 확인   
        $sql = "SELECT Class_List_Time_Price.class_id, Class_List_Time_Price.class_time, Class_List_Time_Price.class_price FROM HANGLE.Class_List Join Class_List_Time_Price 
      On Class_List.class_id = Class_List_Time_Price.class_id where Class_List.user_id_teacher = '{$tusid}'  and class_price Between 
        $filter_class_price_min and $filter_class_price_max order by Class_List_Time_Price.class_price asc limit 1";

        $response5 = mysqli_query($conn, $sql);

        $row5 = mysqli_fetch_array($response5);


        $send['user_id'] = $row1['user_id'];
        $send['teacher_intro'] = $row1['teacher_intro'];
        $send['teacher_special'] = $row1['teacher_special'];

        $send['user_img'] = $row2['user_img'];
        $send['user_language'] = $row2['user_language'];
        $send['user_intro'] = $row2['user_intro'];
        $send['user_sex'] = $row2['user_sex'];

        $send['class_type'] = $row2['class_type'];
        $send['class_level'] = $row2['class_level'];
        $send['user_name'] = $row2['user_name'];

        $send['class_id'] = $row2['class_id'];
        $send['class_time'] = $row5['class_time'];
        $send['class_price'] = $row5['class_price'];

        if ($send['class_id'] != null && $send['user_id'] != null && $send['teacher_intro'] != null && $send['teacher_special'] != null && $send['user_img'] != null && $send['user_language'] != null && $send['user_intro'] != null && $send['user_name'] != null && $send['class_id'] != null && $send['class_time'] != null && $send['class_price'] != null && $send['class_type'] != null && $send['class_level'] != null && $send['user_sex'] != null) { // 수업이 없는 것은 넣지 않는다. 
          array_push($result1['data'], $send);
        }
      }


      if ($response5) { //정상적으로 저장되었을때 

        $result1["success"] = "yes";
        echo json_encode($result1);
        mysqli_close($conn);
      } else {

        $result1["success"] = "no";
        echo json_encode($result1);
        mysqli_close($conn);
      }
    }
  }
}
