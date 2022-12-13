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

-리스트의 경우 value = all, approved, cancel  ,done ,reply
-상세의 경우  value = cdetail  와   
    $classaddid       =   json_decode(file_get_contents("php://input"))->{"classaddid"}; // 예약한 수업 번호 
    "classaddid"(key) = 137(value) 값 이 필요함 ; // 예약한 수업 번호  






출력정보  


1. 수업상세  (수업명, 수업내용, 수업유형, 수업 레벨, 수업 가격)

2. 수업목록  (수업명, 및 기타 정보 + 수업오픈한 강사의 정보(이름,이미지 )   + plus 가 있는경우 페이징 동작함)
{"clname"};   // 수업이름 
{"cldisc"};   // 수업설명 
{"clpeople"}; // 수업인원 
{"cltype"};   // 수업유형 
{"cllevel"};  // 수업레벨 
{"cltime"};   // 수업시간
{"clprice"};  // 수업가격
{"timg"};     // 강사이미지
{"tname"};    // 강사이름
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
$tusid       =   json_decode(file_get_contents("php://input"))->{"tusid"}; // 강사의 User_id 
// $tusid       =  32; // 강사의 User_id 


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




// 더보기 (페이징)처리 용 
$plus       =   json_decode(file_get_contents("php://input"))->{"plus"};     // 더보기 


// 수업상세 출력인지 목록 출력인지 
if ($kind == 'cdetail') {
  //해당 classid에 해당하는 상세정보를 가져옴 
  //classid 가 있으면 작동
  $list = array();
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
  if ($clprice != null) {
    array_push($list, 'Price');
  }

  $string = implode(",", $list);

  if ($clReserveCheck  == null) {


    $result1['result'] = array();
    $result2['timeprice'] = array();
  
  
    //수업 상세 정보 
    $Clist_Sql = "SELECT * FROM Class_List WHERE Class_Id = '{$classid}'";
    $response1 = mysqli_query($conn, $Clist_Sql);
  
    $row1 = mysqli_fetch_array($response1);
  
  
    $clid = $row1['0'];
    $tusid = $row1['1'];
  
    $send['CLass_Id'] = $row1['0'];
  
    $send['User_Id'] = $row1['1'];
    if ($clname != null) {
      $send['CL_Name'] = $row1['2'];
    }
    if ($cldisc != null) {
      $send['CL_Disc'] = $row1['3'];
    }
    if ($clpeople != null) {
      $send['CL_People'] = $row1['4'];
    }
    if ($cltype != null) {
      $send['CL_Type'] = $row1['5'];
    }
    if ($cllevel != null) {
      $send['CL_Level'] = $row1['6'];
    }
  
  
  
  
    //Class_List_Time_Price 수업 시간, 가격 확인   
    $Cltp_Sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
  
  
    if ($clprice != null) {
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


  } else if ($clReserveCheck  == 'detail' ) {

      $result1['result'] = array();
      //수업 상세 정보 
      $Clist_Sql = "SELECT Class_Add.*,Class_List.* FROM Class_Add LEFT OUTER JOIN Class_List ON Class_Add.CLass_Id = Class_List.Class_Id 
      where Class_Add.User_Id_s = '$User_ID' and Class_Add_Id = '$classaddid'";
      $response1 = mysqli_query($conn, $Clist_Sql);
    
      $row1 = mysqli_fetch_array($response1);
    
      $send['class_add_id'] = $row1['0']; //수업id
    
      $send['classid'] = $row1['2']; //수업 이름
      $send['ctime'] = $row1['3']; // 수업 설명
      $plan = $row1['4']; // utc 0 기준 예약한 시간 
      $explodePlan = (explode("_", $plan)); // _기준으로 string 분해 
      $hour = 3600000; // 시간의 밀리초 
      $splanArray = array(); // utc 적용한 값 담을 배열 
    
      foreach ($explodePlan as $val) {
        'User utc 기준 : 변환  ' . $save = $val + $timezone * $hour; // user의 timezone을 적용한 값을  $save 저장 
        array_push($splanArray, $save);
      }
    
      $utc_plan = implode("_", $splanArray); // 담긴 배열을 _기준으로 스트링으로 저장 
    
    
      $send['utcplan'] = $utc_plan;  //user의 timezone이 적용된 예약한 수업 일정 값 
    
    
      $send['camemo'] = $row1['5']; // 수업인원
      $send['status'] = $row1['6'];   //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done),4(후기완료 reply),
      $send['cmethod'] = $row1['7']; // 신청한 수업 진행 방식
    
      $answerdate = $row1['8']; //응답한 시간 
      $send['answerdate'] = $answerdate * 1000;  //응답한 시간 js 에서 밀리초 단위이기 때문에 *1000 적용    
        
      $send['cadate'] = $row1['9']; // 수업예약 신청한 시간 
      $send['classid'] = $row1['10'];  // 수업 id 
      $send['tusid'] = $row1['11'];  //강사의 userid
      $send['cname'] = $row1['12']; //
      $send['cdisc'] = $row1['13']; //
      $send['cpeople'] = $row1['14']; //
      $send['ctype'] = $row1['15']; //
      $send['clevel'] = $row1['16']; //
    
    
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
    $Clist_Sql = "SELECT * FROM Class_List order by  Class_Id DESC LIMIT $start, $till";
    $response1 = mysqli_query($conn, $Clist_Sql);

    while ($row1 = mysqli_fetch_array($response1)) {
      $clid = $row1['0'];
      $usid = $row1['1'];
      $send1['tusid'] = $row1['1'];


      $send1['class_id'] = $row1['0'];

      $send1['clname'] = $row1['2'];
      $send1['cldisc'] = $row1['3'];
      $send1['clpeople'] = $row1['4'];
      $send1['cltype'] = $row1['5'];
      $send1['cllevel'] = $row1['6'];



      //해당 Class를 개설한 강사의 이미지와 이름(User_Detail TB)    
      $teacher_Sql = "SELECT 
      User.U_Name, 
      User_Teacher.U_T_Special,  
      User_Detail.U_D_Img

      FROM User
      JOIN User_Detail
        ON User.User_ID = User_Detail.User_Id
      JOIN User_Teacher
        ON User_Teacher.User_Id = User_Detail.User_Id 
      where User.User_Id = '$usid' ";
      $response2 = mysqli_query($conn, $teacher_Sql);
      $row2 = mysqli_fetch_array($response2);
      $send1['U_Name'] = $row2['0'];
      $send1['U_T_Special'] = $row2['1'];
      $send1['U_D_Img'] = $row2['2'];

      //Class_List_Time_Price 수업 시간, 가격 확인   
      $CLTP_Sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
      $response3 = mysqli_query($conn, $CLTP_Sql);

      while ($row2 = mysqli_fetch_array($response3)) {

        $tp['Time'] = $row2['2'];
        $tp['Price'] = $row2['3'];

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
      // echo json_encode($result1);
      mysqli_close($conn);
    }
  } else if ($clReserveCheck  != null) {
    // 학생(사용자)가 자신이 예약 신청한 수업 목록을 얻어옴 all , wait, approved, cancel, done, reply

    if ($clReserveCheck == 'all') {
      $sqlWhere = 'where Class_Add.User_Id_s ='. $User_ID;    
    } else if ($clReserveCheck != 'all') {
      if ($clReserveCheck == 'wait' ) {
        $clRCValue = '0';
      } else if ($clReserveCheck == 'approved') {
        $clRCValue = '1';
      } else if ($clReserveCheck == 'cancel') {
        $clRCValue = '2';
      } else if ($clReserveCheck == 'done') {
        $clRCValue = '3';
      } else if ($clReserveCheck == 'reply') {
        $clRCValue = '4';
      }        
      $sqlWhere = 'where Class_Add.User_Id_s = '. $User_ID.' and Class_Add.C_A_Status = '. $clRCValue;
    } 
    
    //해당 Class_List 와 Class_Add 에서 값을 가져옴     
    $Student_ReserveClassList_Sql = "SELECT Class_List.*,Class_Add.C_A_Schedule,Class_Add.C_A_Status,Class_Add.C_A_AnswerDate,Class_Add.C_A_Date,Class_Add.CTime,Class_Add.Class_Add_Id,Class_Add.C_A_Method  FROM Class_Add LEFT  OUTER JOIN Class_List ON Class_Add.CLass_Id = Class_List.Class_Id
     $sqlWhere  order by  Class_Id DESC LIMIT $start, $till";
    
    
    $SRCList_Result = mysqli_query($conn, $Student_ReserveClassList_Sql);
    $result['result'] = array();
    while ($row1 = mysqli_fetch_array($SRCList_Result)) {
      $send['class_id'] = $row1['0']; //수업id
      $send['tusid'] = $row1['1']; //강사의 userid
      $tusid = $row1['1']; //강사의 userid
      $send['cname'] = $row1['2']; //수업 이름
      $send['cldisc'] = $row1['3']; // 수업 설명
      $send['clpeople'] = $row1['4']; // 수업인원
      $send['cltype'] = $row1['5']; // 수업 종류
      $send['cllevel'] = $row1['6']; // 수업 레벨 
      // $send1['cllevel'] = $row1['7'];


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


      $send['utcplan'] = $utc_plan;  //user의 timezone이 적용된 예약한 수업 일정 값 
      $send['status'] = $row1['9'];   //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done),4(후기완료 reply),
      $answerdate = $row1['10']; //응답한 시간 
      $send['answerdate'] = $answerdate * 1000;  //응답한 시간 js 에서 밀리초 단위이기 때문에 *1000 적용      
      $send['cadate'] = $row1['11']; // 수업예약 신청한 시간 
      $send['ctime'] = $row1['12']; // 수업 시간 (30분, 60분)
      $send['class_add_id'] = $row1['13']; // 신청한 수업 리스트의 idx 값
      $send['cmethod'] = $row1['14']; // 신청한 수업 진행 방식


      //해당 Class를 개설한 강사의 이미지와 이름(User_Detail TB)    
      $teacher_Sql = "SELECT 
      User.U_Name, 
      User_Teacher.U_T_Special,  
      User_Detail.U_D_Img

      FROM User
      JOIN User_Detail
        ON User.User_ID = User_Detail.User_Id
      JOIN User_Teacher
        ON User_Teacher.User_Id = User_Detail.User_Id 
      where User.User_Id = '$tusid' ";
      $response2 = mysqli_query($conn, $teacher_Sql);
      $row2 = mysqli_fetch_array($response2);
      $send['U_Name'] = $row2['0']; // 강사 이름 
      $send['U_T_Special'] = $row2['1']; // 강사 전문성
      $send['U_D_Img'] = $row2['2']; // 강사 이미지 


      array_push($result['result'], $send);
    }


    if ($response2) { //정상적으로 저장되었을때 

      $result["success"] = "yes";
      echo json_encode($result);
      mysqli_close($conn);
    } else {

      $result["success"]   =  "no";
      // echo json_encode($result1);
      mysqli_close($conn);
    }
  } 


}else if ($kind == 'tclist') {
  // 필요한 값이 특정 강사의 수업 목록 이면 



$result3['result'] = array();
$result1['data'] = array();
$result2['timeprice'] = array();
  //Class_List에 수업 목록확인  
  $sql = "SELECT * FROM Class_List WHERE User_Id_t = '{$tusid}'";
  $response1 = mysqli_query($conn, $sql);



  while ($row1 = mysqli_fetch_array($response1)) {
    $clid = $row1['0'];

   
    $send1['class_id'] = $row1['0'];
    if ($clname != null) {
    $send1['clname'] = $row1['2'];}//수업이름
    if ($cldisc != null) {
    $send1['cldisc'] = $row1['3'];} // 수업 소개 
    if ($clpeople != null) {
    $send1['clpeople'] = $row1['4'];}
    if ($cltype != null) {
    $send1['cltype'] = $row1['5'];}
    if ($cllevel != null) {
    $send1['cllevel'] = $row1['6'];}

    if ($clprice != null) {
    //Class_List_Time_Price 수업 시간, 가격 확인   
    $sql = "SELECT * FROM Class_List_Time_Price WHERE CLass_Id = '$clid'";
    $response2 = mysqli_query($conn, $sql);

    while ($row2 = mysqli_fetch_array($response2)) {
   
      $tp= $row2['3'];

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


} else if ($kind == 'tcdetail'){

}
