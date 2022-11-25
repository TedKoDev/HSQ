<?php

// == 내수업 목록 출력 프로세스==
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 구조
// 1.토큰 수령후 User_Id 값 추출 
// 2.User_Id 기준으로 DB User_Detail table내 해당 User_Id의 모든 칼럼이 채워져 있는지 를 체크한다. 
// 3. U_D_Img, U_D_Bday, U_D_Sex, U_D_Contact, U_D_County, U_D_Residence, U_D_Language,U_D_Korean  칼럼중 default 값이 없을경우  yes  default값이 있는경우 no를 출력해서 프론트로 전달한다. 



include("./conn.php");



//Class_List에 수업 목록확인  
$sql = "SELECT * FROM User_Detail WHERE User_Id = '89'";
$result = mysqli_query($conn, $sql);


$row            = mysqli_fetch_array($result);
$img           = $row['U_D_Img'];
$bday             = $row['U_D_Bday'];
$sex              = $row['U_D_Sex'];
$country              = $row['U_D_County'];
$residence        = $row['U_D_Residence'];
$language          = $row['U_D_Language'];
$korean                = $row['U_D_Korean'];



if($img !='default'&&$bday !='default'&&$sex !='default'&&$country !='default'&&$residence !='default'&&$language !='default'&& $korean !='default'){

  echo 'yes'; 
}else{
  echo 'no';
}



mysqli_close($conn);