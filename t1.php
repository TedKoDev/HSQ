<?php

 echo $tt = time().'</br>';
$date = date('Y-m-d H:i:s',  time());
echo $tt.'</br>'; 
echo "The date is $date.".'</br>'.'</br>'.'</br>';  






$timestamp = strtotime("2022-12-01 11:30").'</br>';
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