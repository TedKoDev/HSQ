<?php






1672930800000;
1673017199999;

1673512200000;

$hour = 3600000;
// $day =  3600000*24;

$day = 86400000;





// 1672898400000
// 1672956000000
// 000


echo $date1 = date('Y-m-d H:i:s',  1672836783);
$설정일  = 1672995600;
// $설정일  = 1672930800;
$설정일  = 1673512200;
$설정일2  = 1672930800;
$설정일  = 1672898400;
$설정일2  = 1672923600;
$설정일3  = 1672927199;
$설정일더하기한시간  = $설정일 + 3600;
$설정일하루종일 = $설정일 + 86400;


//  echo $tt = microtime().'</br>';
//  echo $tt = time().'</br>';
$date1 = date('Y-m-d H:i:s',  $설정일);
$date1_1 = date('Y-m-d H:i:s',  $설정일2);
$date1_2 = date('Y-m-d H:i:s',  $설정일3);
$date2 = date('Y-m-d H:i:s',  $설정일더하기한시간);
$date3 = date('Y-m-d H:i:s',  $설정일하루종일 - 1);
// echo $tt.'</br>'; 
echo "설정일The date is $date1." . "</br>" . "</br>" . "</br>";
echo "설정일에 타임존 The date is $date1_1." . "</br>" . "</br>" . "</br>";
echo "설정일에 타임존 끝 The date is $date1_2." . "</br>" . "</br>" . "</br>";




echo "The date 한시간 is $date2." . "</br>" . "</br>" . "</br>";
echo "The date24시간 is $date3." . '</br>' . '</br>' . '</br>';

$timestamp = strtotime("2023-01-06 00:00") . '</br>';
echo $timestamp . '</br>';
$date = date('Y-m-d H:i:s',  $timestamp);
echo $timestamp . '</br>';
echo "12월 19일  $date" . '</br>' . '</br>';



echo 'ddd' . $nomal = strtotime("2022-12-01 11:30") . "<br/>";
echo 'ddd' . $nomal = strtotime("2022-12-28 07:10:17") . "<br/>";
echo 'dddf' . $nomal = strtotime($date2) . "<br/>";
echo "2022-12-01 11:30 : " . strtotime("2022-12-01 11:30") . "<br/>";
echo '한국기준 는' . $plusone = strtotime("2023-01-05 15:00 ") . "<br/>";
echo '+18 는' . $plusone = strtotime("2023-01-06 00:00 ") . "<br/>";
echo "2022-12-01 11:30  기준으로 1시간 뒤 : " . strtotime("2022-12-01 11:30 +1 hours") . "<br/>";


$qq = $plusone - $nomal;
echo "값 차이 1시간 : " . $qq . "<br/>";;

echo '지금시간 ' . $now = time() . "<br/>";
echo $now = time() * 1000 . "<br/>";
echo $now * 1000  . "<br/>";
echo  $today = strtotime(date("Y-m-d")) * 1000 . "<br/>";
echo  $today = strtotime(date("Y-m-d")) . "<br/>";
