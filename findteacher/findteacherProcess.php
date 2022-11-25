
<?php 
// == 강사 찾기 페이지  프로세스==  추후 출력항목 추가될 예정 
//   #요구되는 파라미터 (fetch형태 json 구조로 전달) 

//1. "token"    : "토큰값".


// 보낼 줄 때 형태 
// {
//  "token"    : "토큰값".
// }

// 코드 전개 구조
// 1. 토큰 수령후 User_Id 값 추출 (사용자)  
// 2. 필요한 정보  (아래 참고사항 확인하기 )
//  (강사의 User_Id, U_D_Img, U_Name, U_T_Special, U_D_Language,U_T_Intro, Price(Class_List, Class_List_Time_Price 정리)

// 3. 정보 모아 프론트로 전달. 


//     ## 참고사항  - 현재까지 진행상황 상 지금 처리해야 할 부분 :
//     - 강사 id → 강사 클릭 했을 때 강사 상세 화면으로 이동하기 위해
//     - 강사 프로필 이미지
//     - 강사 이름
//     - 강사 자격 (전문강사 or 튜터)
//     - 강사의 구사 가능 언어 및 구사 수준
//     - 강사 소개 (강사가 강사 등록할 때 작성한 강사 소개)
//     - 수업료 (30분 기준 수업료. 만약 해당 강사가 등록한 수업이 여러개일 경우 그 중 가장 저렴한 수업료 보내기) -->




include("../conn.php");
include("../jwt.php");



$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 

//토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID =  base64_decode($payload['User_ID']);
$U_Name  = base64_decode($payload['U_Name']);
$U_Email = base64_decode($payload['U_Email']);


