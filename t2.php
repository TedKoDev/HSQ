<?php


$timezone = '-1'; //사용자(학생)의 TimeZone

if($timezone>=0){
  $plus_minus = '+';
}else{
  $plus_minus = '';
}


$timezone2 =  $plus_minus.$timezone.':00'; //사용자(학생)의 TimeZ
// $timezone2 =  $plus_minus.$timezone.':00'; //사용자(학생)의 TimeZ

echo $timezone ; 
echo $timezone2 ; 