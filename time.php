<?php


1671667200000;
$hour = 3600000;
// $day =  3600000*24;

$day = 86400000;


$설정일  = 1671667200;
echo $설정일하루종일 = 1671667200+86400;


//  echo $tt = microtime().'</br>';
//  echo $tt = time().'</br>';
$date = date('Y-m-d H:i:s',  $설정일);
$date2 = date('Y-m-d H:i:s',  $설정일하루종일);
// echo $tt.'</br>'; 
echo "The date is $date."."</br>"."</br>"."</br>";  
echo "The date24시간 is $date2.".'</br>'.'</br>'.'</br>';  

$timestamp = strtotime("2022-12-22 00:00").'</br>';
echo $timestamp.'</br>';
$date = date('Y-m-d H:i:s',  $timestamp);
echo $timestamp.'</br>'; 
echo "The date is $date".'</br>'.'</br>'; 



echo $nomal = strtotime("2022-12-01 11:30")."<br/>";
echo "2022-12-01 11:30 : ".strtotime("2022-12-01 11:30")."<br/>";
echo  $plusone = strtotime("2022-12-01 11:30 +1 hours")."<br/>";
echo "2022-12-01 11:30  기준으로 1시간 뒤 : ".strtotime("2022-12-01 11:30 +1 hours")."<br/>";


 $qq=$plusone-$nomal;
echo "값 차이 1시간 : ". $qq;

?>