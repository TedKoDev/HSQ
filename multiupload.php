<?php
    for($i = 0; $i < count($_FILES['upload']['name']); $i++){
 
        $uploadfile = $_FILES['upload']['name'][$i];
 
        if(move_uploaded_file($_FILES['upload']['tmp_name'][$i],'uploads/' . $uploadfile)){
            echo "파일이 업로드 되었습니다.<br />";
            echo "<img src ={$_FILES['upload']['name'][$i]} style='width:100px'> <p>";
            echo "1. file name : {$_FILES['upload']['name'][$i]}<br />";
        } else {
            echo "파일 업로드 실패 !! 다시 시도해주세요.<br />";
        }
    }
?>