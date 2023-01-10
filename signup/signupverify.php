<head>
    <script>
        if ($dialog == '1') {
            window.onload = function() {
                if (confirm("ertified your Email. Please Login.")) {
                    //화면이동 
                    Headers("Location: ../index.php");
                }
            }
        } else {
            window.onload = function() {
                if (confirm("something wrong please contact to admin.")) {
                    //화면이동 
                    Headers("Location: ../index.php");
                }
            }
        }
    </script>
</head>

<body>

    <!-- Your HTML content here -->

</body>

</html>
<?php


include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$token           =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 
$email           =   $_GET['email']; // 이메일
$password        =   $_GET['hash']; // 패스워드

// echo $email . '</br>';
// echo $password;

// DB 정보 가져오기 
$sql = "SELECT * FROM User WHERE user_email = '{$email}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$hashedPassword = $row['user_password'];
// echo $hashedPassword . '</br>';



// DB 정보를 가져왔으니 
// 비밀번호 검증 로직을 실행하면 된다.
$jwt = new JWT();

if ($password == $hashedPassword) {
    // 로그인 성공
    // 토큰 생성  id, name, email 값 저장

    $sql = "UPDATE User SET user_active = '1' WHERE user_email = '$email'";
    $result = mysqli_query($conn, $sql);


    $send["success"] = "yes";
    $send["message"] = "Vertified your Email. Please Login";
    $dialog = '1';
    echo json_encode($send);
?> <script>
        window.onload = function() {
            if (confirm("Vertified your Email. Please Login.")) {
                //화면이동 
                location.href = "http://localhost/index.php";

            }
        }
    </script>
<?php


    mysqli_close($conn);
} else {

    $send["success"] = "no";
    $send["message"] = "something wrong please contact to admin";
    $dialog = '0';
    echo json_encode($send);
?>
    <script>
        window.onload = function() {
            if (confirm("something wrong please contact to admin.")) {
                location.href = "http://localhost/index.php";
            }
        }
    </script>
<?php
    mysqli_close($conn);
}

?>