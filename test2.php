<?php

$to = 'ghdxodml@naver.com';             //받는 사람
$title = 'PHP 메일 테스트';            //메일 제목
$contents = '테스트 내용입니다.';      //메일 내용
$headers = 'From: ghdxodml@naver.com';  //헤더

mail($to, $title, $contents, $headers);

?>