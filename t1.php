<?php


include("./conn.php");
include("./jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 사용자(학생)토큰 

//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //학생의 userid
// $User_ID = 32; //학생의 userid
$U_Name  = base64_decode($payload['U_Name']);  //학생의 이름
$U_Email = base64_decode($payload['U_Email']); //학생의 Email
$timezone = base64_decode($payload['TimeZone']); //사용자(학생)의 TimeZone



# 필요값 
// 어떤 내용이 필요한지를 표시 ( clist-수업목록, cdetail-수업상세, tclist-강사의 수업목록)
$kind          =   json_decode(file_get_contents("php://input"))->{"kind"}; // 강사의 User_id 
$clReserveCheck     =   json_decode(file_get_contents("php://input"))->{"clReserveCheck"}; // 예약된 수업 리스트 / 상세 

// $kind            =   'clist';         //  
// $kind            =   'cdetail';       //  
// $clReserveCheck  =   'cdetail';       // 예약된 수업 상세 페이지 

// $kind          =   'tcdetail';      // 
$kind          =   'tclist';      // 
// $clReserveCheck  =  'all';          // 
// $clReserveCheck  =  'approved';     // 
// $clReserveCheck  =  'not_approved'; // 
// $clReserveCheck  =  'done';         // 
// $clReserveCheck  =  'reply';        // 


// $kind          =   'cdetail'; // 강사의 User_id 
// 수업목록        : kind = clist 
// 수업상세        : kind = cdetail    
// 예약체크        : kind = clReserveCheck    // 전체 목록 또는 상세 정보 
// 예약체크 필요값 : value = all, approved, not_approved  ,done ,reply
// value : 
// 1. all (해당 유저가 예약/완료한 모든 수업)
// 2. approved (예약 승인 되었지만 아직 수강은 안한 수업)
// 3. not_approved (예약 신청은 했는데 강사가 아직 예약 승인은 안한 수업)
// 4. done (완료한 수업) 





// 필요한 class의 id 값이 필요함 
$classid       =   json_decode(file_get_contents("php://input"))->{"classid"}; // 수업번호 
$classaddid       =   json_decode(file_get_contents("php://input"))->{"classaddid"}; // 예약한 수업 번호 


// $classaddid       =  26; // 예약한 수업 번호 
// $classid       =   34; // 수업번호 
// 강사의 수업목록 : kind = tclist
// 강사의 userid 값이 필요함 
// $tusid       =   json_decode(file_get_contents("php://input"))->{"tusid"}; // 강사의 User_id 
$tusid       =  320; // 강사의 User_id 


//====================================================================================================

//수업목록, 강사의 수업목록 이 필요할 경우 아래의 항목에 (아무런) 값을 넣어 보내줘야 출력됨.  


$clname     =   json_decode(file_get_contents("php://input"))->{"clname"};   // 수업이름 
$cldisc     =   json_decode(file_get_contents("php://input"))->{"cldisc"};   // 수업설명 
$clpeople   =   json_decode(file_get_contents("php://input"))->{"clpeople"}; // 수업인원 
$cltype     =   json_decode(file_get_contents("php://input"))->{"cltype"};   // 수업유형 
$cllevel    =   json_decode(file_get_contents("php://input"))->{"cllevel"};  // 수업레벨 
$cltime     =   json_decode(file_get_contents("php://input"))->{"cltime"};   // 수업시간
$clprice    =   json_decode(file_get_contents("php://input"))->{"clprice"};  // 수업가격
$timg       =   json_decode(file_get_contents("php://input"))->{"timg"};     // 강사이미지
$tname      =   json_decode(file_get_contents("php://input"))->{"tname"};    // 강사이름

$clname     =  1; // 수업이름 
$cldisc     =  1; // 수업설명 
$clpeople   =  1; // 수업인원 
$cltype     =  1; // 수업유형 
$cllevel    =  1; // 수업레벨 
$cltime     =  1; // 수업시간
$clprice    =  1; // 수업가격
$timg       =  1; // 강사이미지
$tname      =  1; // 강사이름



// 더보기 (페이징)처리 용 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 



 if ($kind == 'tclist') {
  // 필요한 값이 특정 강사의 수업 목록 이면 

  $result1['data'] = array();
  $result2['timeprice'] = array();
  $result3['result'] = array();


  $list = array();
  array_push($list, 'CLass_Id');
  if ($clname != null) {
    array_push($list, 'CL_Name');
  }
  if ($cldisc != null) {
    array_push($list, 'CL_Disc');
  }
  if ($clpeople != null) {
    array_push($list, 'CL_People');
  }
  if ($cltype != null) {
    array_push($list, 'CL_Type');
  }
  if ($cllevel != null) {
    array_push($list, 'CL_Level');
  }

  $string = implode(",", $list);


 
  //Class_List에 수업 목록확인  
  $sql = "SELECT  $string FROM Class_List WHERE User_Id_t = '{$tusid}'";
  $response1 = mysqli_query($conn, $sql);

  foreach ($response1 as $key) {


    // echo key($key); // 키
    // echo current($key); // 값
    $clid = current($key); // 값

    array_push($result1['data'], $key);


    if ($clprice != null) {
      //Class_List_Time_Price 수업 시간, 가격 확인   
      $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
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

    // $result1['data'] = array();
    // $result2['timeprice'] = array();
    // $result3['result'] = array();
  
} else if ($kind == 'tcdetail'){

}
