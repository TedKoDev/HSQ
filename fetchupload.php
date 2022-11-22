<?php

//upload.php


if(isset($_FILES['sample_image']))
{

  date_default_timezone_set('Asia/Seoul');
  $time_now = date("Y-m-d");

	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

  $new_name = $time_now .'.'.'userid'.'.'. $extension;

	move_uploaded_file($_FILES['sample_image']['tmp_name'], 'image/' . $new_name);

	$data = array(
		'image_source'		=>	'image/' . $new_name
	);

	echo json_encode($data);

}


?>