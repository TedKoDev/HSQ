export let test = [

    {
        chat_id : 24,
        user1_id : 320,
        user1_name : '안해인',
        user1_img : 'P_IMG_320.PNG',
        user2_id : 324,
        user2_name : '홍태의',
        user2_img : 'P_IMG_324.PNG',        
        recent_msg_id : 22,
        recent_msg_desc : 'hihi',
        recent_msg_time : 1671964507870,
        non_read_count : 3,
        msg_list : [

            {
                msg_id : 20,
                msg_type : 'text',
                sender_id : 320,
                msg_desc : '안녕하세요',
                msg_time : 1671964000000   
            },
            {
                msg_id : 21,
                msg_type : 'text',
                sender_id : 324,
                msg_desc : '안녕하세요',
                msg_time : 1671964500000   
            },
            {
                msg_id : 22,
                msg_type : 'class_request',
                sender_id : 28,
                msg_desc : 
                    {
                        class_name : '기초 한국어',
                        teacher_name : '홍태의',
                        teacher_img : 'P_IMG_320.PNG'
                    },
                msg_time : 1671964507870   
            }
        ]
    }
    // ,
    // {
    //     chat_id : 25,
    //     sender_name : '홍태의',
    //     sender_img : 'P_IMG_324.PNG',
    //     recent_msg_id : 24,
    //     recent_msg_desc : '안녕안녕',
    //     recent_msg_time : 1234567891011,
    //     msg_list : [

    //         {
    //             msg_id : 21,
    //             msg_type : 'paypal',
    //             sender_id : 29,
    //             msg_desc : '안녕하세요',
    //             msg_time : 1234567891011   
    //         }
    //     ]
    // }
];
