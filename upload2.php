<?php
  if ( $_POST[ "action" ] == "Upload" ) {
    $uploaded_file_name_tmp = $_FILES[ 'myfile' ][ 'tmp_name' ];
    $uploaded_file_name = "user id " .$_FILES[ 'myfile' ][ 'name' ]; 
    $upload_folder = "uploads/";
    move_uploaded_file( $uploaded_file_name_tmp, $upload_folder . $uploaded_file_name );
    echo "<p>" . $uploaded_file_name . "을(를) 업로드하였습니다.</p>";
  }
?>