<?php


1671667200000;
$hour = 3600000;
// $day =  3600000*24;

$day = 86400000;

// 000
echo $설정일  = 1672545600;
echo $설정일더하기한시간  = 1672545600 + 3600;
echo $설정일하루종일 = 1672545600 + 86400;


//  echo $tt = microtime().'</br>';
//  echo $tt = time().'</br>';
$date1 = date('Y-m-d H:i:s',  $설정일);
$date2 = date('Y-m-d H:i:s',  $설정일더하기한시간);
$date3 = date('Y-m-d H:i:s',  $설정일하루종일);
// echo $tt.'</br>'; 
echo "The date is $date1." . "</br>" . "</br>" . "</br>";
echo "The date 한시간 is $date2." . "</br>" . "</br>" . "</br>";
echo "The date24시간 is $date3." . '</br>' . '</br>' . '</br>';

$timestamp = strtotime("2022-12-22 00:00") . '</br>';
echo $timestamp . '</br>';
$date = date('Y-m-d H:i:s',  $timestamp);
echo $timestamp . '</br>';
echo "The date is $date" . '</br>' . '</br>';



echo 'ddd' . $nomal = strtotime("2022-12-01 11:30") . "<br/>";
echo 'ddd' . $nomal = strtotime("2022-12-28 07:10:17") . "<br/>";
echo 'dddf' . $nomal = strtotime($date2) . "<br/>";
echo "2022-12-01 11:30 : " . strtotime("2022-12-01 11:30") . "<br/>";
echo  $plusone = strtotime("2022-12-01 11:30 +1 hours") . "<br/>";
echo "2022-12-01 11:30  기준으로 1시간 뒤 : " . strtotime("2022-12-01 11:30 +1 hours") . "<br/>";


$qq = $plusone - $nomal;
echo "값 차이 1시간 : " . $qq . "<br/>";;

echo $now = time() . "<br/>";
echo $now = time() * 1000 . "<br/>";
echo $now * 1000  . "<br/>";
echo  $today = strtotime(date("Y-m-d")) * 1000 . "<br/>";
echo  $today = strtotime(date("Y-m-d")) . "<br/>";
