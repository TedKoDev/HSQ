<?php
 $db_name = "HANGLE"; 		// DB 이름
 $username = "hong";		  		// 사용자 이름
 $password = "1234"; 		 // MySQL 비밀번호
 $servername = "3.35.167.92";	// AWS EC2 인스턴스에 할당된 퍼블릭 IPv4 주소. localhost는 안해봤지만 될 것 같다.

 $hs_url = "http://3.35.167.92/";
 
 $conn = mysqli_connect($servername, $username, $password, $db_name);
 
?>
