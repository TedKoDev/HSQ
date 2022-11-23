<?php


include("./conn.php");

?><script src = "./commenJS/cookie.js"></script><?php
    
    // 쿠키에서 토큰값 가져오기
    $tokenvalue = '<script> var test2 = getCookie("user_info"); document.write(test2);</script>';
    

if (isset( $_FILES['img'])) {
    
    if (!empty($_FILES['img']['name'][0])) {
        
        $zip = new ZipArchive();
        $zip_time = time();
        $zip_name1 = getcwd() . "/uploads/USER_" . $zip_time . ".zip";
        $zip_name2 = "USER_" . $zip_time . ".zip";

        ?>
        <script>



        </script>       
        <?php
        
        // Create a zip target
        if ($zip->open($zip_name1, ZipArchive::CREATE) !== TRUE) {
            $error .= "Sorry ZIP creation is not working currently.<br/>";
        }
        
        $imageCount = count($_FILES['img']['name']);
        for($i=0;$i<$imageCount;$i++) {
        
            if ($_FILES['img']['tmp_name'][$i] == '') {
                continue;
            }
            // $newname = date('YmdHis', time()) . mt_rand() . '.jpg';
            
            // Moving files to zip.
            $zip->addFromString($_FILES['img']['name'][$i], file_get_contents($_FILES['img']['tmp_name'][$i]));
            
            // // moving files to the target folder.
            // move_uploaded_file($_FILES['img']['tmp_name'][$i], './uploads/' . $newname);
        }
        $zip->close();
        
        // Create HTML Link option to download zip
        // $success = basename($zip_name1);
    } else {
        $error = '<strong>Error!! </strong> Please select a file.';
    }

    
    $select = "UPDATE User_Teacher SET U_T_FILE = '$zip_name2' where User_Id = '76'";  
    $result8 = mysqli_query($conn, $select);
      
    
   
    if ($result8) { //정상적으로 파일 저장되었을때 
        $send["position"]   =  "file";
        $send["success"]   =  "yes";
        echo json_encode($send);
    
    } else {
        $send["position"]   =  "file";
        $send["success"]   =  "no";
        echo json_encode($send);
       
    }


 }
    



//강사 전환 부분 

if($check1 = 1 && $check2 =1 ){
    $select = "UPDATE User_Detail SET U_D_T_add = 'yes' where User_Id = '76'";  
    $result9 = mysqli_query($conn, $select);

    
    $send["tadd"]   =  "yes";
    echo json_encode( $send);
 
}else {

    $send["tadd"]   =  "no";
    echo json_encode( $send);
}