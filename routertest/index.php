<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>GET방식 POST 방식 한페이지에서 처리하기</title>
</head>
<?php 
    header('Content-Type: text/html; charset=UTF-8');
    
    /*
    isset($_POST['submit']) 작동 안되는 경우가 있더군요.
    대신에 $_SERVER['REQUEST_METHOD'] === 'POST'로 체크해 보셔도 됩니다.
    */
    if(isset($_POST['submit'])){//작동이 안되면 $_SERVER['REQUEST_METHOD'] === 'POST' 변경해 보시길..
        $name = $_POST['name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $birth = $_POST['birth'];
        
        echo '<h2>POST 방식을 이용해 데이타가 웹서버로 넘어왔네요 </h2>';
        echo '<p>이름 : '. $name . '<br>나이 : '. $age . '<br>성별 :  ' . $gender. '<br>생일 : ' . $birth . '</p>';
    }else{//get
            $name = $_GET['name'];
            $age = $_GET['age'];
            $gender = $_GET['gender'];
            $birth = $_GET['birth'];
            
            echo '<h2>GET 방식을 이용해 데이타가 웹서버로 넘어왔네요 </h2>';
            echo '<p>이름 : '. $name . '<br>나이 : '. $age . '<br>성별 :  ' . $gender. '<br>생일 : ' . $birth . '</p>';
    }
?>
<body>
    <a href="/?name=아이유&age=30&gender=여자&birth=1993/05/16">GET 방식 전송</a>
    <form action="server.php" method="post">
    	<input type="submit" value="POST 방식 전송" id="submit" name="submit" >
    	<input type="hidden" id="name" name="name" value="아이유">
    	<input type="hidden" id="age" name="age" value="30">
    	<input type="hidden" id="gender" name="gender" value="여자">
    	<input type="hidden" id="birth" name="birth" value="1993/05/16">
    </form>
</body>
</html>