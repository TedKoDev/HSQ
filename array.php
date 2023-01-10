<?php



// Array ( [0] => Array ( [paymen] => 1235 ) [1] => Array ( [payment] => 12345 ) ) 값 꺼내기 

$result = array(
  array(
    'payment' => '1235'
  ),
  array(
    'payment' => '12345'
  )
);
// $payment = $result[1]['payment'];
// echo $payment;
foreach ($result as $element) {
  foreach ($element as $key => $value) {
    echo  $value . "\n";
  }
}
