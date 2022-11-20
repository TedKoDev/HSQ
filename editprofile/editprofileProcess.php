<?php
// == Myinfo 이미지 업로드 프로세스==
//   #요구되는 파라미터 (fetch형태도 요청 ) 
//1. 토큰값  - token 
//2. 이미지값  - image 


# 보낼 줄 때 형태 
// {
//  "token" : "토큰값 "
// }


// #반환되는 데미터 
// ==성공시  (예시)






include("../conn.php");
include("../jwt.php");


$jwt = new JWT();

// 토큰값, 이미지  전달 받음 
file_get_contents("php://input") . "<br/>";
$token = json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$position = json_decode(file_get_contents("php://input"))->{"position"}; //항목
$desc = json_decode(file_get_contents("php://input"))->{"desc"};  //내용


//토큰 해체 
$data = $jwt->dehashing($token);

$parted = explode('.', base64_decode($token));

$payload = json_decode($parted[1], true);

//ar_dump($payload);


$User_ID =  base64_decode($payload['User_ID']);

$U_Name  = base64_decode($payload['U_Name']);

$U_Email = base64_decode($payload['U_Email']);



// U_D에 해당 user _ID로 등록된것이 있는지 확인

$check = "SELECT * FROM User_Detail where User_Id = '$User_ID'";
$checkresult = mysqli_query($conn, $check);


// U_D에 해당 user _ID로 등록된것이 있는지  확인
if ($checkresult->num_rows = 0) {
    // 중복값이 없을때 때 실행할 내용
    // 없으면 insert로  data 만들고  
    // 아래의 update로 data 삽입 
    $result = "INSERT * INTO User_Detail (User_Id) VALUES ('$User_ID') ";

    //   $send["message"] = "no";
    //   $send["message1"] = "no";

    // echo json_encode($send);
    mysqli_close($conn);
}


// 있으면 update 시작 




// data update 부분 
//프로필이미지
//$desc 가 image인경우 
if ($position === "p_img") {
  

    //인스턴스내 www/html/image 폴더 내에 이미지 저장됨 (임시 추후 S3로 변경할 예정)
    // image 저장되는 루트 
    $saveroot = "image"; // 저장되는 루트 

    $imagestore = rand() . "_" . time() . ".jpeg";
    $saveroot = $saveroot . "/" . $imagestore;
    file_put_contents($saveroot, base64_decode($desc));



    $select = "UPDATE User_Detail SET U_D_Img = '$imagestore' where User_Id = '$User_ID' ";

    $response = mysqli_query($conn, $select);




    if ($response) { //정상적으로 이미지가 저장되었을때 
        $send["position"]   =  "p_img";
        $send["success"]   =  "yes";
        echo json_encode($send);
        mysqli_close($conn);
    } else {
        $send["position"]   =  "p_img";
        $send["success"]   =  "no";
        echo json_encode($send);
        mysqli_close($conn);
    }
}
//이름변경
//$desc 가 '이름'인경우 
else if ($position === "name") {


    $select = "UPDATE User SET U_Name = '$desc' where User_Id = '$User_ID' ";


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
} else if ($position === "bday") {
    $select = "UPDATE User_Detail SET U_D_Bday = '$desc' where User_Id = '$User_ID' ";


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


} else if ($position === "sex") {
} else if ($position === "contact") {
} else if ($position === "country") {
} else if ($position === "residence") {
} else if ($position === "language") {
} else if ($position === "korean") {
} else if ($position === "intro") {
}

























// DB 정보 가져오기 
$sql = "SELECT User.User_ID, User.U_Name, User.U_Email,  U_D_Img, U_D_Bday, U_D_Sex, U_D_Contact, U_D_Country, U_D_Residence ,U_D_Point, U_D_Language ,U_D_Korean, U_D_T_add , U_D_Intro FROM HANGLE.User left join User_Detail on User.User_ID = User_Detail.User_Id where User.User_ID = '{$User_ID}'";
// {$User_ID}

$result = mysqli_query($conn, $sql);



$row = mysqli_fetch_array($result);


// 값 변수 설정 
$userid      = $row['User_ID'];
$name        = $row['U_Name'];
$email       = $row['U_Email'];
$p_img       = $row['U_D_Img'];
$bday        = $row['U_D_Bday'];
$sex         = $row['U_D_Sex'];
$contact     = $row['U_D_Contact'];
$country     = $row['U_D_Country'];
$residence   = $row['U_D_Residence'];
$point       = $row['U_D_Point'];
$language    = $row['U_D_Language'];
$korean      = $row['U_D_Korean'];
$teacher     = $row['U_D_T_add'];
$intro       = $row['U_D_Intro'];




$send["userid"]   =  $userid;
$send["name"]   =  $name;
$send["email"]   =  $email;
$send["p_img"]   =  $p_img;
$send["bday"]   =  $bday;
$send["sex"]   =  $sex;
$send["contact"]   =  $contact;
$send["country"]   =  $country;
$send["residence"]   =  $residence;
$send["point"]   =  $point;
$send["language"]   =  $language;
$send["korean"]   =  $korean;
$send["teacher"]   =  $teacher;
$send["intro"]   =  $intro;



echo json_encode($send);
mysqli_close($conn);
