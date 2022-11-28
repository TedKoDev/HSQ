<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".
//2. "schedule" : "스케쥴"  


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 Class_List 상의 수업 목록 값을 가져온다 
// 3.동시에 Class_List_Time_Price  CLass_Id 기준으로 에서 시간, 가격 값도 가져온다.

//4.Json 형태로 담아 프론트로 전송한다. 




include("./conn.php");




//Class_List에 수업 목록확인  
$sql = "SELECT U_D_Timezone FROM User_Detail WHERE User_Id = '18'";
$response1 = mysqli_query($conn, $sql);




$row1 = mysqli_fetch_array($response1); 
echo $timezone = $row1['0'];
  
