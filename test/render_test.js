import {test_json} from "../message/example_json.js";
import {$, $_all} from "/utils/querySelector.js";
import {getCookie, cookieName, s3_url} from "/commenJS/cookie_modules.js";

// 채팅방 리스트 뿌리는 div
const chat_room_div = $('.chatroom_list');

const my_id = 324;
const msgResult = test_json.result;

$('.delete').addEventListener('click', function () {

    const button = document.getElementById(84);

    button.remove();
})

$('.insert').addEventListener('click', function () {

    init2();
})

init();
function init() {
    // 채팅방 리스트 세팅
    for (let i = 0; i < msgResult.length; i++) {

        let user_name;
        let user_img;
        let user_non_read_count;

        let recent_chat_date;
        let recent_msg_desc;
        // 브라우저에 접속한 유저 기준에서 상대방의 id
        let other_id;

        // 내가 receiver_id일 경우
        if (my_id != msgResult[i].sender_id) {

            user_name = msgResult[i].sender_name;
            user_img = msgResult[i].sender_img;
            user_non_read_count = msgResult[i].receiver_non_read_count;

            // 상대방의 id 대입
            other_id = msgResult[i].// 내가 sender_id일 경우
            receiver_id;
        } else {

            user_name = msgResult[i].receiver_name;
            user_img = msgResult[i].receiver_img;
            user_non_read_count = msgResult[i].sender_non_read_count;

            // 상대방의 id 대입
            other_id = msgResult[i].sender_id;
        }

        recent_chat_date = dayjs(parseInt(msgResult[i].recent_msg_time)).format(
            "MM월 DD일"
        );
        recent_msg_desc = msgResult[i].resent_msg_desc;

        const button = document.createElement("button");
        button.setAttribute(
            "class",
            "chat_room_btn w-full hover:bg-gray-200 px-2 border-b-2"
        );

        // 만약 현재 본인이 들어가 있는 채팅방이면 회색처리 if (msgResult[i].chat_id == chatId_global) {
        // button.classList.add('bg-gray-200'); } else {
        // button.classList.remove('bg-gray-200'); }
        button.setAttribute("id", msgResult[i].chat_id);
        button.innerHTML = `
            <div class = "flex w-full my-2">                
                <div class = "w-1/5 flex">
                <img
                    id="user_image_room"
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src="${s3_url}Profile_Image/${user_img}">
                </img>  
                </div>
                <div class = "flex flex-col w-3/5 text-left ml-1">
                    <span class = "text-sm">${user_name}</span>
                    <span class = "line_clamp_1 text-xs">${recent_msg_desc}</span>
                </div>
                <div class = "flex flex-col w-2/5">
                    <span class = "text-xs text-center mb-1">${recent_chat_date}</span>    
                    <div id = ${msgResult[i].chat_id}_count class = "mx-auto w-5 h-5 rounded-full bg-red-500 shadow text-sm text-white">${user_non_read_count}</div>                    
                </div>                
            </div>`;

        chat_room_div.append(button);

        // 안 읽은 메세지 갯수 0이면 빨간 원 안보이게 처리
        const circle = document.getElementById(msgResult[i].chat_id + "_count");
        if (user_non_read_count == 0) {
            circle
                .classList
                .add('hidden');
        } else {
            circle
                .classList
                .remove('hidden');
        }
    }
}

function init2() {
    // 채팅방 리스트 세팅
    for (let i = 0; i < msgResult.length; i++) {

        let user_name;
        let user_img;
        let user_non_read_count;

        let recent_chat_date;
        let recent_msg_desc;
        // 브라우저에 접속한 유저 기준에서 상대방의 id
        let other_id;

        // 내가 receiver_id일 경우
        if (my_id != msgResult[i].sender_id) {

            user_name = msgResult[i].sender_name;
            user_img = msgResult[i].sender_img;
            user_non_read_count = msgResult[i].receiver_non_read_count;

            // 상대방의 id 대입
            other_id = msgResult[i].// 내가 sender_id일 경우
            receiver_id;
        } else {

            user_name = msgResult[i].receiver_name;
            user_img = msgResult[i].receiver_img;
            user_non_read_count = msgResult[i].sender_non_read_count;

            // 상대방의 id 대입
            other_id = msgResult[i].sender_id;
        }

        recent_chat_date = dayjs(parseInt(msgResult[i].recent_msg_time)).format(
            "MM월 DD일"
        );
        recent_msg_desc = msgResult[i].resent_msg_desc;

        const button = document.createElement("button");
        button.setAttribute(
            "class",
            "chat_room_btn w-full hover:bg-gray-200 px-2 border-b-2"
        );

        // 만약 현재 본인이 들어가 있는 채팅방이면 회색처리 if (msgResult[i].chat_id == chatId_global) {
        // button.classList.add('bg-gray-200'); } else {
        // button.classList.remove('bg-gray-200'); }
        button.setAttribute("id", msgResult[i].chat_id);
        button.innerHTML = `
            <div class = "flex w-full my-2">                
                <div class = "w-1/5 flex">
                <img
                    id="user_image_room"
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src="${s3_url}Profile_Image/${user_img}">
                </img>  
                </div>
                <div class = "flex flex-col w-3/5 text-left ml-1">
                    <span class = "text-sm">${user_name}</span>
                    <span class = "line_clamp_1 text-xs">${recent_msg_desc}</span>
                </div>
                <div class = "flex flex-col w-2/5">
                    <span class = "text-xs text-center mb-1">${recent_chat_date}</span>    
                    <div id = ${msgResult[i].chat_id}_count class = "mx-auto w-5 h-5 rounded-full bg-red-500 shadow text-sm text-white">${user_non_read_count}</div>                    
                </div>                
            </div>`;

        chat_room_div.prepend(button);

        // 안 읽은 메세지 갯수 0이면 빨간 원 안보이게 처리
        const circle = document.getElementById(msgResult[i].chat_id + "_count");
        if (user_non_read_count == 0) {
            circle
                .classList
                .add('hidden');
        } else {
            circle
                .classList
                .remove('hidden');
        }
    }
}