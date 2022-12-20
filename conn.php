<?php
 $db_name = "HANGLE"; 		// DB 이름
 $username = "hs_api_admin";		  		// 사용자 이름
 $password = "xodml12!"; 		 // MySQL 비밀번호
 $servername = "hs-api-db.csis3ho8an2b.ap-northeast-2.rds.amazonaws.com";	// AWS EC2 인스턴스에 할당된 퍼블릭 IPv4 주소. localhost는 안해봤지만 될 것 같다.

 $hs_url = "http://3.35.167.92/";
 
 $conn = mysqli_connect($servername, $username, $password, $db_name);
 
?>
