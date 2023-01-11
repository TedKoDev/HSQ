<?php









// (schedule_list between "1672797600000" and "1672801199999") or (schedule_list between "1672884000000" and"1672887599999") or (schedule_list between "1672970400000" and "1672973999999")



// (schedule_list between "1672797600000" and "1672801199999") or (schedule_list between "1672884000000" and"1672887599999") or (schedule_list between "1672970400000" and "1672973999999") or (schedule_list between"1672801200000" and "1672804799999") or (schedule_list between "1672887600000" and "1672891199999") or (schedule_listbetween "1672974000000" and "1672977599999")





date_default_timezone_set('UTC');

echo '최초 전달되는값 ' . $date1 = date('  Y-m-d H:i:s',  1673395200);
echo '- 9시간 한 값 서버에저장' . $date1 = date('  Y-m-d H:i:s',  1673362800);
echo 'utc 0 기준 1월 11일이 화면에 출력될 때 ' . $date1 = date('  Y-m-d H:i:s',  1673427600);


// echo $date1 = date('  Y-m-d H:i:s',  1672617600);
// echo $date1 = date('  Y-m-d H:i:s',  1673395200);
// echo $date1 = date('  Y-m-d H:i:s',  1673397000);
// echo $date1 = date('  Y-m-d H:i:s',  1673362800);

// echo $date1 = date('  Y-m-d H:i:s',  1672884000);
// echo $date1 = date('  Y-m-d H:i:s',  1672887599);
// echo $date1 = date('  Y-m-d H:i:s',  1672970400);
// echo $date1 = date('  Y-m-d H:i:s',  1672973999);
// echo $date1 = date('  Y-m-d H:i:s',  1672801200);
// echo $date1 = date('  Y-m-d H:i:s',  1672804799);
// echo $date1 = date('  Y-m-d H:i:s',  1672887600);
// echo $date1 = date('  Y-m-d H:i:s',  1672891199);
// echo $date1 = date('  Y-m-d H:i:s',  1672974000);
// echo $date1 = date('  Y-m-d H:i:s',  1672977599);










// $today = strtotime(date("Y-m-d")) * 1000;
// $today = strtotime(date("Y-m-d")) * 1000;
// $today = strtotime(date("Y-m-d")) * 1000;
// $today = strtotime(date("Y-m-d")) * 1000;

// $results = array();

// for ($i = 0; $i < 120; $i++) {
//   $results[] = strtotime(date("Y-m-d", strtotime("+$i days")));
// }


// echo json_encode($results);









// // 1672930800000;
// // 1673017199999;

// // 1673512200000;

// // $hour = 3600000;
// // // $day =  3600000*24;

// // $day = 86400000;





// // // 1672898400000
// // // 1672956000000
// // // 000


// // echo $date1 = date('Y-m-d H:i:s',  1672836783);
// // $설정일  = 1672995600;

// // // $설정일  = 1672930800;
// // $설정일  = 1673512200;
// // $설정일2  = 1672930800;

// // $설정일2  = 1672923600;
// // $설정일3  = 1672927199;
// // $설정일더하기한시간  = $설정일 + 3600;
// // $설정일하루종일 = $설정일 + 86400;

// // $설정일  = 1671517800000;
// // //  echo $tt = microtime().'</br>';
// // //  echo $tt = time().'</br>';
// // echo '시간만 ' . $date1 = date('H',  $설정일);
// // $date1 = date('Y-m-d H:i:s',  $설정일);
// // $date1_1 = date('Y-m-d H:i:s',  $설정일2);
// // $date1_2 = date('Y-m-d H:i:s',  $설정일3);
// // $date2 = date('Y-m-d H:i:s',  $설정일더하기한시간);
// // $date3 = date('Y-m-d H:i:s',  $설정일하루종일 - 1);
// // // echo $tt.'</br>'; 
// // echo "설정일The date is $date1." . "</br>" . "</br>" . "</br>";
// // echo "설정일에 타임존 The date is $date1_1." . "</br>" . "</br>" . "</br>";
// // echo "설정일에 타임존 끝 The date is $date1_2." . "</br>" . "</br>" . "</br>";




// // echo "The date 한시간 is $date2." . "</br>" . "</br>" . "</br>";
// // echo "The date24시간 is $date3." . '</br>' . '</br>' . '</br>';

// // $timestamp = strtotime("2023-01-06 00:00") . '</br>';
// // echo $timestamp . '</br>';
// // $date = date('Y-m-d H:i:s',  $timestamp);
// // echo $timestamp . '</br>';
// // echo "12월 19일  $date" . '</br>' . '</br>';



// // echo 'ddd' . $nomal = strtotime("2022-12-01 11:30") . "<br/>";
// // echo 'ddd' . $nomal = strtotime("2022-12-28 07:10:17") . "<br/>";
// // echo 'dddf' . $nomal = strtotime($date2) . "<br/>";
// // echo "2022-12-01 11:30 : " . strtotime("2022-12-01 11:30") . "<br/>";
// // echo '한국기준 는' . $plusone = strtotime("2023-01-05 15:00 ") . "<br/>";
// // echo '+18 는' . $plusone = strtotime("2023-01-06 00:00 ") . "<br/>";
// // echo "2022-12-01 11:30  기준으로 1시간 뒤 : " . strtotime("2022-12-01 11:30 +1 hours") . "<br/>";


// // $qq = $plusone - $nomal;
// // echo "값 차이 1시간 : " . $qq . "<br/>";;

// // echo '지금시간 ' . $now = time() . "<br/>";
// // echo $now = time() * 1000 . "<br/>";
// // echo $now * 1000  . "<br/>";
// // echo  $today = strtotime(date("Y-m-d")) * 1000 . "<br/>";
// // echo  $today = strtotime(date("Y-m-d")) . "<br/>";
