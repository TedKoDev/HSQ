<?php
// == 강사 찾기 페이지  프로세스==  추후 출력항목 추가될 예정 
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"                     : "토큰값".
//2. "plus"                      : "더보기".
//3. "user_timezone"             : "비로그인시 로컬 타임존".
//4. "filter_search"             : "검색어 필터 (수업명, 수업설명부분 필터 )".
//5. "filter_class_type"         : "수업타입 필터".      (배열형태로 전달)
//6. "filter_class_price_min"    : "최저가격".
//7. "filter_class_price_max"    : "최대가격".
//8. "filter_teacher_special"    : "강사 전문가 여부".
//9. "filter_teacher_country"    : "강사 출신국가 ". (배열형태로 전달)
//10. "filter_teacher_sex"       : "강사 성별".
//11. "filter_teacher_language"  : "강사 사용언어".(배열형태로 전달)
//12. "filter_date"              : "날짜".
//12. "filter_time"              : "시간대".





include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"}; // 더보기 
$utc      =   json_decode(file_get_contents("php://input"))->{"user_timezone"};  //유저의 로컬 타임존 





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



//강사 찾기 필터 테스트용 
// $filter_check      = 'ok(아무값)';


$timezone      =   9;  //유저의 로컬 타임존 
// $clReserveCheck = null; //안해도됨
// $filter_search     = 'ss';
$filter_time = array("20");
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
// $filter_teacher_country = array("대한민국");
// $filter_teacher_language = array("러시아어", "스페인어"); // 강사 사용언어 




$i = 0;




$start =  $i + (20 * $plus);
$till = 20;



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

        $filter_date_utc_zero1 = $filter_date - ($hour * $timezone); // user의 timezone을 적용해서 utc 0 기준으로 변경 
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


                $오늘날짜더하기시간값 = $today2 + ($val + $timezone + 1) * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로   
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

        $filter_date_utc_zero1 = $filter_date - ($hour * $timezone); // user의 timezone을 적용해서 utc 0 기준으로 변경 

        foreach ($explode_filter_time as $val) {


            $날짜에시간을더함 = $filter_date_utc_zero1 + $val * $hour; // 타임존 적용 필요없음 왜냐면 서버 로컬시간 utc 0기준임으로
            $날짜에시간을더함더하기한시간 = $날짜에시간을더함 + $hour - 1; // 3을 선택한경우 3시부터 4시 사이의 값이 필요하기때문에 한시간을 더해줌

            $filter_date_i = '(schedule_list between ' . '"' . $날짜에시간을더함  . '"' . ' and ' . '"' . $날짜에시간을더함더하기한시간  . '")'; // user의 timezone을 적용한 값을  $save 저장 
            array_push($filter_hour_array1, $filter_date_i);
        }



        $filter_hour_add2 = implode(" or ", $filter_hour_array1); // 담긴 배열을 _기준으로 스트링으로 저장 
        $filter_hour_add3  =  $filter_hour_add2;
    }




    if ($filter_teacher_special != null) {
        $filter_teacher_special_val = '"' . $filter_teacher_special . '"';
    } else if ($filter_teacher_special == null) {
        $filter_teacher_special_val = "'%default%'";
    }


    $tsql_where = " teacher_special like  $filter_teacher_special_val ";





    $sql = "SELECT DISTINCT * FROM (select DISTINCT User.user_id, User.user_name, User_Teacher.teacher_intro, User_Teacher.teacher_special from User
          JOIN User_Detail
          ON User.user_id = User_Detail.user_id
          JOIN User_Teacher
          ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
             ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id JOIN Class_List ON Class_List.user_id_teacher = User_Teacher.user_id   WHERE $filter_hour_add3) AS new_userlist where $tsql_where order by   user_id  DESC LIMIT $start, $till";
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



        $response1 = mysqli_query($conn, $sql);
    }
} else if ($filter_date == null &&  $filter_time == null) {

    if ($filter_teacher_special != null) {
        $filter_teacher_special_val = '"' . $filter_teacher_special . '"';
    } else if ($filter_teacher_special == null) {
        $filter_teacher_special_val = "'%default%'";
    }


    $tsql_where = " teacher_special like  $filter_teacher_special_val ";



    $sql = "SELECT DISTINCT * FROM (select DISTINCT User.user_id, User.user_name, User_Teacher.teacher_intro, User_Teacher.teacher_special from User
    JOIN User_Detail
    ON User.user_id = User_Detail.user_id
    JOIN User_Teacher
    ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
       ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id JOIN Class_List ON Class_List.user_id_teacher = User_Teacher.user_id ) AS new_userlist where $tsql_where           order by  user_id  DESC LIMIT $start, $till";
    $response1 = mysqli_query($conn, $sql);


    if ($filter_search != null) {

        //Class_List에 수업 목록확인  
        $sql =  "SELECT DISTINCT * FROM (select DISTINCT User.user_id, User.user_name, User_Teacher.teacher_intro, User_Teacher.teacher_special from User
      JOIN User_Detail
      ON User.user_id = User_Detail.user_id
      JOIN User_Teacher
      ON User_Teacher.user_id = User_Detail.user_id   JOIN Teacher_Schedule 
         ON Teacher_Schedule.user_id_teacher = User_Teacher.user_id JOIN Class_List ON Class_List.user_id_teacher = User_Teacher.user_id ) AS new_userlist where $tsql_where   and user_name LIKE '%$filter_search%' 
      or teacher_intro LIKE '%$filter_search%'  order by  user_id  DESC LIMIT $start, $till ";
        $response1 = mysqli_query($conn, $sql);
    }
}

//       echo "결말";

echo $sql;


$result1['data'] = array();
while ($row1 = mysqli_fetch_array($response1)) {


    $tusid = $row1['user_id'];




    $tsql_where = " ";
    if ($filter_teacher_language != null) {
        echo '언어';
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
        // echo '  13. 국가 필터 있음 진입';
        echo '국가 필터';

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





    // 수업타입 
    if ($filter_class_type != null) {
        echo '수업타입 필터';
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



    echo $teacher_Sql = "SELECT 
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




    //평점
    $sql = "SELECT AVG(student_review_star) as review_score FROM Class_Student_Review where user_id_teacher = '{$tusid}'";
    $response6 = mysqli_query($conn, $sql);
    $row6 = mysqli_fetch_array($response6);



    //수업횟수
    $sql = "SELECT COUNT(*) as class_count FROM Class_Add where user_id_teacher = '{$tusid}' and class_register_status = '3'";
    $response7 = mysqli_query($conn, $sql);
    $row7 = mysqli_fetch_array($response7);







    $send['user_id'] = $row1['user_id'];
    $send['teacher_intro'] = $row1['teacher_intro'];
    $send['teacher_special'] = $row1['teacher_special'];

    $send['user_img'] = $row2['user_img'];
    $send['user_language'] = $row2['user_language'];
    $send['user_intro'] = $row2['user_intro'];
    $send['user_sex'] = $row2['user_sex'];
    $send['user_country'] = $row2['user_country'];

    $send['class_type'] = $row2['class_type'];
    $send['class_level'] = $row2['class_level'];
    $send['user_name'] = $row2['user_name'];

    $send['class_id'] = $row2['class_id'];
    $send['class_time'] = $row5['class_time'];
    $send['class_price'] = $row5['class_price'];
    $send['review_score'] = $row6['review_score'];
    $send['class_count'] = $row7['class_count'];

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
