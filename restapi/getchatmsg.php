<?php




include("../conn.php");
include("../jwt.php");

$jwt = new JWT();

// 토큰값, 항목,내용   전달 받음 
file_get_contents("php://input") . "<br/>";


//강사 상세출력시 필요 
$token      =   json_decode(file_get_contents("php://input"))->{"token"}; // 토큰 


//사용자(학생)토큰 해체 
$data = $jwt->dehashing($token);
$parted = explode('.', base64_decode($token));
$payload = json_decode($parted[1], true);
$User_ID = base64_decode($payload['User_ID']); //학생의 userid



$User_ID = 324;



$result1['result'] = array();



//  
$sql = "SELECT 
Chat_Room.chat_room_id,
Chat_Room.sender_id,
Chat_Room.sender_last_check,
Chat_Room.receiver_id, 
Chat_Room.receiver_last_check, 
Chat_Room.recent_msg_id,
Chat_Room.recent_msg,
Chat_Room.recent_msg_date 
From Chat_Room where Chat_Room.sender_id = $User_ID or Chat_Room.receiver_id =  $User_ID ";

$response = mysqli_query($conn, $sql);




while ($row = mysqli_fetch_array($response)) {




    $senderid = $row['sender_id'];
    $sender_last_check = $row['sender_last_check'];


    $receiverid = $row['receiver_id'];
    $receiver_last_check = $row['receiver_last_check'];



    $chat_room_id = $row['chat_room_id'];


    $sql1 = "SELECT 
    User.user_name,
    User_Detail.user_img
    From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $senderid  ";

    $response1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_array($response1);


    $sql2 = "SELECT 
    User.user_name,
    User_Detail.user_img
    From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $receiverid  ";

    $response2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_array($response2);


    $result2['msg_list'] = array();

    $sql3 = "SELECT 
    Chat_Message.*
    From Chat_Message LEFT OUTER JOIN User ON Chat_Message.sender_id = User.user_id LEFT OUTER JOIN User_Detail ON User_Detail.user_id = Chat_Message.sender_id  where Chat_Message.chat_room_id = $chat_room_id  ";

    $response3 = mysqli_query($conn, $sql3);

    while ($row3 = mysqli_fetch_array($response3)) {


     

        $send1['msg_id'] = $row3['chat_room_id'];
        $send1['msg_type'] = $row3['message_type'];


        $sender_id = $row3['sender_id'];


        $sql4 = "SELECT 
   
        User.user_name,
        User_Detail.user_img
        From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $senderid  ";

        $response4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_array($response4);
        $send1['sender_id'] = $senderid;
        $send1['sender_name'] = $row4['user_name'];
        $send1['sender_img'] = $row4['user_img'];


        $msg_type = $row3['message_type'];

        if ($msg_type  == 'text') {

            $send1['msg_desc'] = $row3['chat_message'];
            $time = $row3['chat_message_date'];
    
            $time2 = strtotime($time);
            $send1['msg_time'] = $time2 *1000;

        } else if ($msg_type  == 'payment_link') {

            $result3['msg_desc'] = array();



            $class_register_id = $row3['class_register_id'];

            $sql5 = "SELECT 
            Class_Add.*
            From Class_Add where Class_Add.class_register_id = $class_register_id";

            $response5 = mysqli_query($conn, $sql5);

            while ($row5 = mysqli_fetch_array($response5)) {

                $send2['class_register_id'] = $row5['class_register_id'];
                $send2['class_id'] = $row5['class_id'];

                $class_id = $row5['class_id'];


                $sql6 = "SELECT Class_List.*
                From Class_List where Class_List.class_id =  $class_id  ";

                $response6 = mysqli_query($conn, $sql6);
                $row6 = mysqli_fetch_array($response6);

                $send2['class_name'] = $row6['class_name'];

                $send2['student_id'] = $row5['user_id_student'];
                $send2['teacher_id'] = $row5['user_id_teacher'];
                $teacher_id = $row5['user_id_teacher'];



                $sql7 = "SELECT          
                User.user_name,
                User_Detail.user_img
                From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $teacher_id";

                $response7 = mysqli_query($conn, $sql7);
                $row7 = mysqli_fetch_array($response7);


                $send2['teacher_name'] = $row7['user_name'];
                $send2['teacher_img'] = $row7['user_img'];



                $result4['payment_link'] = array();
                $sql8 = "SELECT 
                Payment_Link.*
                From Payment_Link where Payment_Link.user_id_payment = $teacher_id";

                $response8 = mysqli_query($conn, $sql8);

                while ($row8 = mysqli_fetch_array($response8)) {


                    $send3['payment_link'] = $row8['payment_link'];



                    array_push($result4['payment_link'], $send3['payment_link']);
                }

                $send2['payment_link'] = $result4['payment_link'];

                array_push($result3['msg_desc'], $send2);
            }

            $send1['msg_desc'] = $result3['msg_desc'];

            $time = $row3['chat_message_date'];
    
            $time2 = strtotime($time);
            $send1['msg_time'] = $time2 *1000;


        } else if ($msg_type  == 'request_class') {
            $result3['msg_desc'] = array();



            $class_register_id = $row3['class_register_id'];

            $sql5 = "SELECT 
            Class_Add.*
            From Class_Add where Class_Add.class_register_id = $class_register_id";

            $response5 = mysqli_query($conn, $sql5);

            while ($row5 = mysqli_fetch_array($response5)) {

                $send2['class_register_id'] = $row5['class_register_id'];
                $send2['class_id'] = $row5['class_id'];

                $class_id = $row5['class_id'];


                $sql6 = "SELECT Class_List.*
                From Class_List where Class_List.class_id =  $class_id  ";

                $response6 = mysqli_query($conn, $sql6);
                $row6 = mysqli_fetch_array($response6);

                $send2['class_name'] = $row6['class_name'];

                $send2['student_id'] = $row5['user_id_student'];
                $send2['teacher_id'] = $row5['user_id_teacher'];
                $teacher_id = $row5['user_id_teacher'];



                $sql7 = "SELECT  
        
                User.user_name,
                User_Detail.user_img
                From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $teacher_id";

                $response7 = mysqli_query($conn, $sql7);
                $row7 = mysqli_fetch_array($response7);


                $send2['teacher_name'] = $row7['user_name'];
                $send2['teacher_img'] = $row7['user_img'];


                array_push($result3['msg_desc'], $send2);
            }

            $send1['msg_desc'] = $result3['msg_desc'];
    
            $time = $row3['chat_message_date'];
    
            $time2 = strtotime($time);
            $send1['msg_time'] = $time2 *1000;

        } else if ($msg_type  == 'acceptance_class') {
            $result3['msg_desc'] = array();



            $class_register_id = $row3['class_register_id'];

            $sql5 = "SELECT 
             Class_Add.*
             From Class_Add where Class_Add.class_register_id = $class_register_id";

            $response5 = mysqli_query($conn, $sql5);

            while ($row5 = mysqli_fetch_array($response5)) {

                $send2['class_register_id'] = $row5['class_register_id'];
                $send2['class_id'] = $row5['class_id'];

                $class_id = $row5['class_id'];


                $sql6 = "SELECT Class_List.*
                 From Class_List where Class_List.class_id =  $class_id  ";

                $response6 = mysqli_query($conn, $sql6);
                $row6 = mysqli_fetch_array($response6);

                $send2['class_name'] = $row6['class_name'];

                $send2['student_id'] = $row5['user_id_student'];
                $send2['teacher_id'] = $row5['user_id_teacher'];
                $teacher_id = $row5['user_id_teacher'];



                $sql7 = "SELECT  
        
                 User.user_name,
                 User_Detail.user_img
                 From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $teacher_id";

                $response7 = mysqli_query($conn, $sql7);
                $row7 = mysqli_fetch_array($response7);


                $send2['teacher_name'] = $row7['user_name'];
                $send2['teacher_img'] = $row7['user_img'];


                array_push($result3['msg_desc'], $send2);
            }

            $send1['msg_desc'] = $result3['msg_desc'];
            // $send1['msg_time'] = $row3['chat_message_date'];
            $time = $row3['chat_message_date'];
    
            $time2 = strtotime($time);
            $send1['msg_time'] = $time2 *1000;



        } else if ($msg_type  == 'cancel_class') {


            $result3['msg_desc'] = array();



            $class_register_id = $row3['class_register_id'];

            $sql5 = "SELECT 
            Class_Add.*
            From Class_Add where Class_Add.class_register_id = $class_register_id";

            $response5 = mysqli_query($conn, $sql5);

            while ($row5 = mysqli_fetch_array($response5)) {

                $send2['class_register_id'] = $row5['class_register_id'];
                $send2['class_id'] = $row5['class_id'];

                $class_id = $row5['class_id'];


                $sql6 = "SELECT Class_List.*
                From Class_List where Class_List.class_id =  $class_id  ";

                $response6 = mysqli_query($conn, $sql6);
                $row6 = mysqli_fetch_array($response6);

                $send2['class_name'] = $row6['class_name'];

                $send2['student_id'] = $row5['user_id_student'];
                $send2['teacher_id'] = $row5['user_id_teacher'];
                $teacher_id = $row5['user_id_teacher'];



                $sql7 = "SELECT  
        
                     User.user_name,
                     User_Detail.user_img
                     From User LEFT OUTER JOIN User_Detail ON User.user_id = User_Detail.user_id where User.user_id = $teacher_id";

                $response7 = mysqli_query($conn, $sql7);
                $row7 = mysqli_fetch_array($response7);


                $send2['teacher_name'] = $row7['user_name'];
                $send2['teacher_img'] = $row7['user_img'];


                array_push($result3['msg_desc'], $send2);
            }

            $send1['msg_desc'] = $result3['msg_desc'];
            // $send1['msg_time'] = $row3['chat_message_date'];
            $time = $row3['chat_message_date'];
    
            $time2 = strtotime($time);
            $send1['msg_time'] = $time2 *1000;

        }





        array_push($result2['msg_list'], $send1);
    }





    $send['chat_id'] = $row['chat_room_id'];

    $send['sender_id'] = $row['sender_id'];
    $send['sender_name'] = $row1['user_name'];
    $send['sender_img'] = $row1['user_img'];

    $send['receiver_id'] = $row['receiver_id'];
    $send['receiver_name'] = $row2['user_name'];
    $send['receiver_img'] = $row2['user_img'];

    $send['recent_msg_id'] = $row['recent_msg_id'];


    $recent_msg_id = $row['recent_msg_id'];
    $sender_last_check = $row['sender_last_check'];
    $receiver_last_check = $row['receiver_last_check'];


    $send['sender_non_read_count'] = $recent_msg_id - $sender_last_check;
    $send['receiver_non_read_count'] = $recent_msg_id - $receiver_last_check;
    $send['resent_msg_desc'] = $row['recent_msg'];
    // $send['recent_msg_date'] = $row['recent_msg_date'];
    $time = $row3['recent_msg_date'];
    
    $time2 = strtotime($time);
    $send1['recent_msg_date'] = $time2 *1000;

    
    $send['msg_list'] = $result2['msg_list'];








    array_push($result1['result'], $send);
}


if ($response) { //정상적으로 저장되었을때 

    $result1["my_id"] = $User_ID;
    $result1["success"] = "yes";
    echo json_encode($result1);
    mysqli_close($conn);
} else {

    $result1["success"] = "no";
    echo json_encode($result1);
    mysqli_close($conn);
}
