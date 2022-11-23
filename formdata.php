<?php



if(isset($_POST['username']))
{
  $test = $_POST['username'];
  error_log("test, $test\n", "3", "./php.log");


  
}
if(isset($_POST['username']))
{
  $test1 = $_POST['username'];
  error_log("test,  $test1\n", "3", "./php.log");


  
}


if(isset($_POST['avatar']))
{

  date_default_timezone_set('Asia/Seoul');
  $time_now = date("Y-m-d h-m-s");

	$extension = pathinfo($_POST['avatar']['name'], PATHINFO_EXTENSION);

  $new_name = $time_now .'.'.'userid'.'.'. $extension;

	move_uploaded_file($_POST['avatar']['tmp_name'], 'image/' . $new_name);

	$data = array(
		'avatar'		=>	'image/' . $new_name
	);

	echo json_encode($data);

}


?>