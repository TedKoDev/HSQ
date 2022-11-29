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
include("./jwt.php");

$i = 131;
while ($i <=200){
    echo $i;

$name = 'hong'. $i ;
$email = 'hong'. $i.'@naver.com';
$password ='hong'. $i ;


date_default_timezone_set('Asia/Seoul');
$time_now = date("Y-m-d H:i:s");

error_log("$time_now, $name, $email,$password \n", "3", "/php.log");
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);





$sql = " INSERT INTO User (U_Email, U_PW, U_Name, U_Google_key, U_Facebook_key, U_Character,U_Register_Date )
VALUES('{$email}', '{$hashedPassword}','{$name}', 'null', 'null','null', NOW() )";
   // echo $sql;
   $result = mysqli_query($conn, $sql);

// DB 정보 가져오기 
$sql = "SELECT User_ID FROM User ORDER BY User_ID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$User_ID = $row['User_ID'];
   


   $result = "INSERT INTO User_Detail (User_Id) VALUES ('$User_ID') ";
   $insert = mysqli_query($conn, $result);

   

	$select = "UPDATE User_Detail SET U_D_Img = '1669181503PNG' where User_Id = '$User_ID' ";

	$response = mysqli_query($conn, $select);

    



    $select = "UPDATE User SET U_Name = '$name' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);


    $select = "UPDATE User_Detail SET U_D_Bday = '2021.1.1' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);



    $select = "UPDATE User_Detail SET U_D_Sex = '남성' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);



    $select = "UPDATE User_Detail SET U_D_Contact = 'default' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);


    $select = "UPDATE User_Detail SET U_D_Country = '대한민국' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);



    $select = "UPDATE User_Detail SET U_D_Residence = '대한민국' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);




    $select = "UPDATE User_Detail SET U_D_Language = 'default' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);



    $select = "UPDATE User_Detail SET U_D_Korean = 'A1' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);




    $select = "UPDATE User_Detail SET U_D_Intro = ''소개'+ $i' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);


    $select = "UPDATE User_Detail SET U_D_Timezone = '9' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);
    
    $select = "UPDATE User_Detail SET U_D_T_add = 'yes' where User_Id = '$User_ID' ";


    $response = mysqli_query($conn, $select);


    $check = "SELECT * FROM User_Teacher where User_Id = '$User_ID'";
    $checkresult = mysqli_query($conn, $check);
    

       // 없으면 insert로  data 만들고  
       $result = "INSERT INTO User_Teacher (User_Id) VALUES ('$User_ID') ";
       $insert = mysqli_query($conn, $result);
 
    
    

    //강사-자기소개
    $select = "UPDATE User_Teacher SET U_T_Intro = 't소개+$i' where User_Id = '$User_ID' ";
    $result6 = mysqli_query($conn, $select);

    
    

 
        $certi = $_POST['certi'];
        $select = "UPDATE User_Teacher SET U_T_Certificate = '서티+$i' where User_Id = '$User_ID' ";
        $result7 = mysqli_query($conn, $select);
    
     
    
    
      
    
   
        
   


// Class_List에 수업 등록 
$result = "INSERT INTO Class_List (User_Id, CL_Name, CL_Disc, CL_People, CL_Type,  CL_Date) VALUES ('$User_ID','수업+$i','수업소개+$i ',1,'회화 연습,문법',now()) ";

$insert = mysqli_query($conn, $result);



// DB 정보 가져오기 
$sql = "SELECT * FROM Class_List WHERE User_Id = '{$User_ID}'ORDER BY CLass_Id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$Class_Id = $row['CLass_Id'];



  $result = "INSERT INTO Class_List_Time_Price (CLass_Id, Time, price, Date) VALUES ('$Class_Id','30','30',now())";
  $insert = mysqli_query($conn, $result);

  $result = "INSERT INTO Class_List_Time_Price (CLass_Id, Time, price, Date) VALUES ('$Class_Id','60','60',now())";
  $insert = mysqli_query($conn, $result);

    
    $i= $i +1;
}