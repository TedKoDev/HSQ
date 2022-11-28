<?php

// == 강사수업가능 시간 설정 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "plan" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
//  "plan"    : "일정  (예시 13,14,55,56,57 ...)".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 , plan 값을 수령한다. 
// 2.User_Id 기준으로 User_Detail 에서 사용자의 TIMEZONE 값을 가져온다. 
// 3.plan 내의 스트링값을 분리한뒤 TIMEZONE값 *2를 적용한 결과 값을 얻는다. 이때 결과같은 336을 넘지 않도록 하며 넘는 경우 -336을 진행한 값을 이용한다. 
// 4. 결과값을 배열에 담은후 다시 '_' 을 적용한 STRING 값으로 변환시켜 db에 저장한다. 
// 5. DB Table Teacher_Schedule 에 저장할때 우선 해당 user_id 가 작성한 값이 있는지를 확인하고 있는경우 insert 없는경우 update로 진행되게 한다. 

// #특이사항
// TIMEZONE *2를 하는 이유는  30분단위로 구분하여 스케쥴표를 작성했기 떄문에 timezone +1인 경우  *2를 해주어야한다. 



include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
// 토큰 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; 
$plan      =   json_decode(file_get_contents("php://input"))->{"plan"}; 




// date_default_timezone_set('Asia/Seoul');
// $time_now = date("Y-m-d H:i:s");
// error_log("$token, $cname, $cintro,$timeprice,$people,$type  \n", "3", "../php.log");


//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);




//U_D_Timeze 값을 가져옴   
$sql = "SELECT U_D_Timeze FROM User_Detail WHERE User_Id = '{$User_ID}'";
$response1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($response1); 
$timezone = $row1['0'];



// 프론트단에서 전달받은 시간별 칸 값을 _ 기호를 기준으로 분리한다. 
$result = (explode("_", $plan));

// echo $result;
  
$resultarray = array();
//

foreach($result as $val){

  $val."</br>";

  $save = $val + $timezone * 2;

  // echo $save;
  if($save > 336) {

    $save = $save - 336; 
  }


  array_push($resultarray,$save);

}

// echo json_encode($resultarray);
// echo '</br>';
// echo $plan;
// echo '</br>';

 $string = implode("_",$resultarray);
  
 $check = "SELECT * FROM Teacher_Schedule where User_Id = '{$User_ID}'";
 $checkresult = mysqli_query($conn, $check);
 
 
 // U_D에 해당 user _ID로 등록된것이 있는지  확인
 if ($checkresult->num_rows <1) {

     // 중복값이 없을때 때 실행할 내용
     // 없으면 insert로  data 만들고  
     // 아래의 update로 data 삽입 
     $result = "INSERT INTO Teacher_Schedule (User_Id, Schedule) VALUES ('{$User_ID}', ' $string') ";
     $response = mysqli_query($conn, $result);
     
 if ($response) { //정상일떄  
  $data = array(
    'plan'            =>  $plan,
    'success'        	=>	'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else {//비정상일떄 
  $data = array(
 
    'success'        	=>	'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}
  
 }else {
   

 
 $select = "UPDATE Teacher_Schedule SET Schedule = '$string' where User_Id = '{$User_ID}' ";
 
 $response = mysqli_query($conn, $select);
 

 if ($response) {//정상일떄 
  $data = array(
    'plan'            =>  $plan,
    'success'        	=>	'yes'
  );
  echo json_encode($data);
  mysqli_close($conn);
} else {//비정상일떄 
  $data = array(

    'success'        	=>	'no'
  );
  echo json_encode($data);
  mysqli_close($conn);
}

 }
