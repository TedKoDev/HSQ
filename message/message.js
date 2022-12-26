import { test } from "./example_json.js";
import {$, $_all} from "/utils/querySelector.js";
import { getCookie, cookieName, s3_url} from "/commenJS/cookie_modules.js";


// 본인 id 가져오기 (일단은 하드코딩)
const my_id = 324;

// 받아온 채팅 리스트
let msgList = test;
let msgResult = msgList.result;

// 채팅방 리스트 뿌리는 div
const chat_room_div = $('.chatroom_list');

// 채팅 메세지 전송할 때 현재 접속한(클릭한) 채팅방 확인을 위해 전역으로 채팅방id, 상대방id 선언;
let chatId_global = 0;
let otherId_global;

// 채팅방 리스트 초기 세팅해주는 함수
init();

function init() {

    for (let i = 0; i < msgResult.length; i++) {

        let user_name;
        let user_img;
        let recent_chat_date;
        let recent_msg_desc;
        // 브라우저에 접속한 유저 기준에서 상대방의 id
        let other_id;
    
        if (my_id != msgResult[i].sender_id) {
    
            user_name = msgResult[i].sender_name;
            user_img = msgResult[i].sender_img;
    
            // 상대방의 id 대입
            other_id = msgResult[i].receiver_id;
        }
        else{
    
            user_name = msgResult[i].receiver_name;
            user_img = msgResult[i].receiver_img;   
            
            // 상대방의 id 대입
            other_id = msgResult[i].sender_id;
        }
    
        recent_chat_date = dayjs(parseInt(msgResult[i].recent_msg_time)).format("MM월 DD일");
        recent_msg_desc = msgResult[i].recent_msg_desc;
       
    
        const button = document.createElement("button");
        button.setAttribute("class", "chat_room_btn w-full hover:bg-gray-200 px-2 border-b-2");
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
                        <span class = "text-xs">${recent_msg_desc}</span>
                    </div>
                    <span class = "text-xs w-2/5 text-center">${recent_chat_date}</span>
                </div>`;
            
        chat_room_div.append(button);
    
        // 채팅방 클릭 시 이벤트 리스너
        button.addEventListener('click', () => {
    
            // 소켓1 : 채팅방 입장 이벤트 (DB에서 해당 사용자의 lastcheck 업데이트)
            // socket.emit('enter_chat_room', my_id, msgResult[i].chat_id);
    
            // 현재 클릭한 채팅방id와 상대방 id를 전역변수에 각각 대입
            chatId_global = msgResult[i].chat_id;
            otherId_global = other_id;
    
            // 채팅방 위에 해당 유저 이름 표시하기
            $('.chatting_user_name').innerText = user_name;
    
            // 클릭한 채팅방 버튼 색깔 칠하기
            setBtnGray(msgResult[i].chat_id);
    
            // 해당 채팅방의 채팅 내역 뿌려주기
            getChattingList(msgResult, msgResult[i].chat_id);
        })
    }
}


// 클릭한 채팅방 버튼 색깔 칠하기
function setBtnGray(chat_id) {

    // 전체 버튼 디폴트로 처리
    const btnList = $_all('.chat_room_btn');
    for (const btn of btnList) {

        btn.classList.remove('bg-gray-200');
    }
    const clickBtn = document.getElementById(chat_id);
    clickBtn.classList.add('bg-gray-200');
}

// 해당 채팅방 id의 채팅 내역 뿌려주는 함수
const chattingList_div = $('.chatting_list');
function getChattingList(msgResult, chat_id) {
      
    // 기존 채팅 내역 초기화
    while(chattingList_div.firstChild)  {
        chattingList_div.firstChild.remove();     
     }

   let chattingList;

   // 클릭한 채팅방의 채팅 리스트 추출
   for (let i = 0; i < msgResult.length; i++) {
        
        if (msgResult[i].chat_id == chat_id) {
                        
            chattingList = msgResult[i].msg_list;            
            break;
        }
   }
   
   
   // 채팅 뿌려주기
   for (let j = 0; j < chattingList.length; j++) {
            
        // div 생성
        const div = document.createElement("div");

        // 일반 채팅일 경우
        if (chattingList[j].msg_type == 'text') {                                        
           
            if (chattingList[j].sender_id == my_id) {

                const date = chattingList[j].msg_time;
                const user_img = chattingList[j].sender_img;        
                const msg_desc = chattingList[j].msg_desc;    

                setText(div, date, user_img, msg_desc, 'yes');       
                
            }
            else {

                const date = chattingList[j].msg_time;
                const user_img = chattingList[j].sender_img;        
                const msg_desc = chattingList[j].msg_desc;    
               
                setText(div, date, user_img, msg_desc, 'no');     
            }         
        }
        // 페이팔 링크일 경우
        else if (chattingList[j].msg_type == 'paypal') {

            const msg_desc = chattingList[j].msg_desc;
            const teacher_name = msg_desc.teacher_name;
            const teacher_img = msg_desc.teacher_img;
            const class_name = msg_desc.class_name;
            const paypal_link = msg_desc.paypal_link;  
            const class_id = msg_desc.class_register_id; 
            const date = chattingList[j].msg_time;

            setPaypal(div, date, teacher_name, class_id, teacher_img, class_name, paypal_link);          
        }
        // 수업 예약/승인/취소일 경우
        else {

            const msg_desc = chattingList[j].msg_desc;
            const sender_name = chattingList[j].sender_name;            
            const teacher_img = msg_desc.teacher_img;
            const class_name = msg_desc.class_name;            
            const date = chattingList[j].msg_time;
            const class_id = msg_desc.class_register_id;

            if (chattingList[j].msg_type == 'class_request') {                
    
                setClassState(div, date, sender_name, class_id, teacher_img, class_name, '님이 수강 신청했습니다.')           
            }
            else if (chattingList[j].msg_type == 'class_approve') {
                   
                setClassState(div, date, sender_name, class_id, teacher_img, class_name, '님이 수강 요청을 수락했습니다.')
            }
            else if (chattingList[j].msg_type == 'class_cancel') {
                
                setClassState(div, date, sender_name, class_id, teacher_img, class_name, '님이 수업을 취소했습니다.')               
            }
        }        

        chattingList_div.append(div);
   }      
}

// 텍스트, paypal, 수업 요청/승인/취소 하는 컴포넌트

// 텍스트일 경우 대입하는 함수
function setText(div, date, user_img, msg_desc, me) {

    if (me == 'yes') {

        div.innerHTML = `
        <div class = "px-2">
            <div class = "text-center text-xs text-gray-500 my-2 border-2">${dayjs(parseInt(date)).format("MM월 DD일 hh:mm")}</div>
            <div class = "flex flex-row-reverse my-2">
                <img
                    id="user_image_chat"
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src="${s3_url}Profile_Image/${user_img}">
                </img> 
                <span class = "w-1/2 mr-2 p-2 text-sm bg-gray-50 rounded-lg">
                    ${msg_desc}
                </span>
            </div>
        </div>
        `;
    }
    else {
        div.innerHTML = `
        <div class = "px-2">
            <div class = "text-center text-xs text-gray-500 my-2 border-2">${dayjs(parseInt(date)).format("MM월 DD일 hh:mm")}</div>
            <div class = "flex my-2">
                <img
                    id="user_image_chat"
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src="${s3_url}Profile_Image/${user_img}">
                </img> 
                <span class = "w-1/2 ml-2 p-2 text-sm bg-gray-50 rounded-lg">
                    ${msg_desc}
                </span>
            </div>
        </div>
        `;
    }     
}

// 페이팔 링크일 경우 대입하는 함수
function setPaypal(div, date, teacher_name, class_id, teacher_img, class_name, paypal_link) {

    div.innerHTML = `
        <div class = "px-2">
            <div class = "text-center text-xs text-gray-500 my-2 border-2">
                ${dayjs(parseInt(date)).format("MM월 DD일 hh:mm")}
            </div>
            <div class = "mx-auto bg-gray-50 rounded-lg px-2 pb-2 pt-1 w-1/2">
                <div class = "text-sm text-gray-800"><span class = "text-gray-900">${teacher_name}</span class = "text-gray-700">님이 결제 링크를 보냈습니다.</div>
                <button class = "w-full" value = ${class_id}>
                    <div class = "mt-1 flex px-2 py-1 bg-gray-200 rounded-lg items-center hover:shadow">
                        <div>
                            <img
                                id="user_image_chat"
                                class="my-auto w-6 h-6 border-gray-900 rounded-full"
                                src="${s3_url}Profile_Image/${teacher_img}">
                            </img> 
                        </div>
                        <div class = "ml-2 text-xs text-gray-700">${class_name}</div>
                    </div>
                </button>
                <a class = "text-xs text-blue-700">${paypal_link}</a>
            </div>
        </div> 
        `; 
}

// 수업 예약/승인/취소일 때 대입하는 함수
function setClassState(div, date, sender_name, class_id, teacher_img, class_name, text) {

    div.innerHTML = `
    <div class = "px-2">
        <div class = "text-center text-xs text-gray-500 my-2 border-2">
            ${dayjs(parseInt(date)).format("MM월 DD일 hh:mm")}
        </div>
        <div class = "mx-auto bg-gray-50 rounded-lg px-2 pb-2 pt-1 w-1/2">
            <div class = "text-sm text-gray-800"><span class = "text-gray-900">${sender_name}</span class = "text-gray-700">${text}</div>
            <button class = "w-full" value = ${class_id}>
                <div class = "mt-1 flex px-2 py-1 bg-gray-200 rounded-lg items-center hover:shadow">
                    <div>
                        <img
                            id="user_image_chat"
                            class="my-auto w-6 h-6 border-gray-900 rounded-full"
                            src="${s3_url}Profile_Image/${teacher_img}">
                        </img> 
                    </div>
                    <div class = "ml-2 text-xs text-gray-700">${class_name}</div>
                </div>
            </button>                    
        </div>
    </div> 
    `; 
} 

// 전송버튼 클릭
$('.send_btn').addEventListener('click', () => {

    sendTextMessage();
})

function sendTextMessage() {
    
    // 소켓서버에 메세지 전송 (채팅방 id, 채팅 메세지, 보내는 사람id, 받는 사람id)
    // socket.emit('send_text_msg', chatId_global, $('.input_message').value, my_id, otherId_global);
}

// 소켓 서버에서 들어오는 요청 받는 곳
// socket.on('receive_text_msg', (chat_room_id, chat_msg, sender_id, sender_name, sender_img, msg_date) => {
    
//     console.log("chat_room_id : "+chat_room_id);
//     console.log("chat_msg : "+chat_msg);
//     console.log("sender_id : "+sender_id);
//     console.log("sender_name : "+sender_name);
//     console.log("sender_img : "+sender_img);

//     // 재 렌더링
//     init();


//     if (chat_room_id == chatId_global) {        

//         const div = document.createElement("div");

//         if (sender_id == my_id) {

//             setText(div, msg_date, user_img, msg_desc, 'yes');            
//         }
//         else {

//             setText(div, msg_date, user_img, msg_desc, 'no');            
//         }    

//         chattingList_div.appendchild(div);               
//     }    
// });

// socket.on('receive_paypal_msg', (chat_room_id, class_register_id, class_name, teacher_name, teacher_img, paypal_link, msg_date) => {

//     console.log("chat_room_id : "+chat_room_id);
//     console.log("class_register_id : "+class_register_id);
//     console.log("class_name : "+class_name);
//     console.log("teacher_name : "+teacher_name);
//     console.log("teacher_img : "+teacher_img);
//     console.log("paypal_link : "+paypal_link);

//     // 재 렌더링
//     init();


//     if (chat_room_id == chatId_global) {        

//         const div = document.createElement("div");

//         setPaypal(div, msg_date, teacher_name, class_id, teacher_img, class_name, paypal_link)

//         chattingList_div.appendchild(div);
//     } 
// });

// socket.on('request_class', (chat_room_id, class_register_id, class_name, teacher_name, teacher_img, msg_date) => {

//     console.log("chat_room_id : "+chat_room_id);
//     console.log("class_register_id : "+class_register_id);
//     console.log("class_name : "+class_name);
//     console.log("teacher_name : "+teacher_name);
//     console.log("teacher_img : "+teacher_img);

//     // 재 렌더링
//     init();


//     if (chat_room_id == chatId_global) {

//         const div = document.createElement("div");

//         setClassState(div, msg_date, teacher_name, class_register_id, teacher_img, class_name, '님이 수강 신청했습니다.')

//         chattingList_div.appendchild(div);
//     }
// });

// socket.on('acceptance_class', (chat_room_id, class_register_id, class_name, teacher_name, teacher_img, msg_date) => {

//     console.log("chat_room_id : "+chat_room_id);
//     console.log("class_register_id : "+class_register_id);
//     console.log("class_name : "+class_name);
//     console.log("teacher_name : "+teacher_name);
//     console.log("teacher_img : "+teacher_img);

//     // 재 렌더링
//     init();


//     if (chat_room_id == chatId_global) {

//         const div = document.createElement("div");

//         setClassState(div, msg_date, teacher_name, class_register_id, teacher_img, class_name, '님이 수강 요청을 수락했습니다.')

//         chattingList_div.appendchild(div);
//     }
// });

// socket.on('cancel_class', (chat_room_id, class_register_id, class_name, teacher_name, teacher_img, msg_date) => {

//     console.log("chat_room_id : "+chat_room_id);
//     console.log("class_register_id : "+class_register_id);
//     console.log("class_name : "+class_name);
//     console.log("teacher_name : "+teacher_name);
//     console.log("teacher_img : "+teacher_img);

//     // 재 렌더링
//     init();


//     if (chat_room_id == chatId_global) {

//         const div = document.createElement("div");

//         setClassState(div, msg_date, teacher_name, class_register_id, teacher_img, class_name, '님이 수업을 취소했습니다.')

//         chattingList_div.appendchild(div);
//     }
// });




