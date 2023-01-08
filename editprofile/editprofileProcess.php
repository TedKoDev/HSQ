<?php
// == editprofileProcess 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값  - token 
//2. 항목    - position 
//3. 내용    - desc 


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "position" : "항목".
//  "desc"     : "내용" 
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
//자기소개   -  "intro"
//강사자기소개   -  "teacher_intro"
//강사자기소개   -  "payment_link"

//시간대 - "utc"


// 요청사항 
// language 값의 경우 "언어:수준" (영어:B1)으로 전달 요청 바랍니다. 
// korean 값의 경우 "수준"만 전달 바랍니다.  (A1,A2, B1,B2, C1,C2)




include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$position = json_decode(file_get_contents("php://input"))->{"position"}; //항목
// $position = 'payment_link'; //항목
$desc = json_decode(file_get_contents("php://input"))->{"class_description"};  //내용
// $desc = array("1671667200000", "1671753600000");  //내용
// $filter_date       =  ;

// date_default_timezone_set('Asia/Seoul');
// $time_now = date("Y-m-d H:i:s");

// error_log("$time_now, $position, $desc\n", "3", "/php.log");





//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

//ar_dump($payload);


$user_id    =   base64_decode($payload['User_ID']);


$user_name  = base64_decode($payload['U_Name']);

$U_Email    =  base64_decode($payload['U_Email']);

// error_log("$time_now, $user_id, $user_name, $U_Email \n", "3", "/php.log");



// U_D에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM User_Detail where user_id = $user_id";
$checkresult = mysqli_query($conn, $check);

// error_log("$time_now,'ddd', $user_id, $user_name, $U_Email \n", "3", "/php.log");



// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows < 1) {

    // 중복값이 없을때 때 실행할 내용
    // 없으면 insert로  data 만들고  
    // 아래의 update로 data 삽입 
    $result = "INSERT INTO User_Detail (user_id) VALUES ('$user_id') ";
    $insert = mysqli_query($conn, $result);
    //   $send["message"] = "no";
    //   $send["message"] = "no";

    // echo json_encode($send);
    // mysqli_close($conn);
}


// 있으면 update 시작 




// data update 부분 
//이름변경
//$desc 가 '이름'인경우 
if ($position === "name") {

    $user_name = mysqli_real_escape_string($conn, $desc);
    // $select = "UPDATE User SET user_name = '$desc' where user_id = '$user_id' ";
    $select = "UPDATE User SET user_name = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "name";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "name";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //생일변경
//$desc 가 '생일'인경우 
else if ($position === "bday") {
    $select = "UPDATE User_Detail SET user_birthday = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "bday";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "bday";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //성별변경
//$desc 가 '성별'인경우 
else if ($position === "sex") {
    $select = "UPDATE User_Detail SET user_sex = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "sex";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "sex";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //연락처 변경
//$desc 가 '연락처'인경우 
else if ($position === "contact") {
    $select = "UPDATE User_Detail SET user_contact = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "contact";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "contact";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //국가변경
//$desc 가 '국가'인경우 
else if ($position === "country") {
    $select = "UPDATE User_Detail SET user_country = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "country";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "country";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //거주지변경
//$desc 가 '거주지'인경우 
else if ($position === "residence") {
    $select = "UPDATE User_Detail SET user_residence = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "residence";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "residence";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //사용가능언어변경
//$desc 가 '사용가능언어'인경우 
else if ($position === "language") {
    $select = "UPDATE User_Detail SET user_language = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "language";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "language";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //한국어수준변경
//$desc 가 '한국어수준'인경우 
else if ($position === "korean") {
    $select = "UPDATE User_Detail SET user_korean = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "korean";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "korean";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} //자기소개변경
//$desc 가 '자기소개 '인경우 
else if ($position === "intro") {
    $select = "UPDATE User_Detail SET user_intro = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "intro";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "intro";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} // 타임존
//$desc 가 'utc '인경우 
else if ($position === "utc") {
    $select = "UPDATE User_Detail SET user_timezone = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "utc";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "utc";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} // 강사 소개 수정 
//$desc 가 'teacher_intro '인경우 
else if ($position == "teacher_intro") {



    $select = "UPDATE User_Teacher SET teacher_intro = '$desc' where user_id = '$user_id' ";


    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "teacher_intro";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "teacher_intro";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
} // 강사 결제 링크 수정 
//$desc 가 'teacher_intro '인경우 
else if ($position == "payment_link") {

    $payment_link_array = array(); //검사 해야할 시간 기준 


    echo json_encode($desc);
    //sql delete
    $select = "DELETE FROM Payment_Link where user_id_payment = '$user_id' ";

    $response = mysqli_query($conn, $select);

    foreach ($desc as $val) {
        // echo $val;



        // $select = "UPDATE Payment_Link SET payment_link = '$desc' where user_id = '$user_id' ";
        $result = "INSERT INTO Payment_Link (user_id_payment, payment_link) VALUES ('$user_id','$val') ";

        $response = mysqli_query($conn, $result);
    }




    if ($response) { //정상적으로 이름이 저장되었을때 
        $send["position"]   =  "payment_link";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "payment_link";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
}



//2022.12.14 대공사 수정완료 db 테이블 칼럼 및  입출 변수 수정완료 .