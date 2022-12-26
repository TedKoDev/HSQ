import { test } from "./example_json.js";
import {$, $_all} from "/utils/querySelector.js";
import { getCookie, cookieName, s3_url} from "/commenJS/cookie_modules.js";


// 본인 id 가져오기 (일단은 하드코딩)
const my_id = 324;

// 받아온 채팅 리스트
let msgList = test;

// 채팅방 리스트 뿌리는 함수
const chat_room_div = $('.chatroom_list');
let msgResult = msgList.result;

for (let i = 0; i < msgResult.length; i++) {

    let user_name;
    let user_img;
    let recent_chat_date;
    let recent_msg_desc;

    if (my_id != msgResult[i].sender_id) {

        user_name = msgResult[i].sender_name;
        user_img = msgResult[i].sender_img;
        
    }
    else{

        user_name = msgResult[i].receiver_name;
        user_img = msgResult[i].receiver_img;        
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

        // 채팅방 위에 해당 유저 이름 표시하기
        $('.chatting_user_name').innerText = user_name;

        // 클릭한 채팅방 버튼 색깔 칠하기
        setBtnGray(msgResult[i].chat_id);

        // 해당 채팅방의 채팅 내역 뿌려주기
        getChattingList(msgResult, msgResult[i].chat_id);
    })
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

                console.log(user_img);

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

                const date = chattingList[j].msg_time;
                const user_img = chattingList[j].sender_img;        
                const msg_desc = chattingList[j].msg_desc;    

                console.log(user_img);

                div.innerHTML = `
                <div class = "px-2">
                    <div class = "text-center text-xs text-gray-500 my-2 border-2 rounded-br-lg">${dayjs(parseInt(date)).format("MM월 DD일 hh:mm")}</div>              
                    <div class = "flex w-full my-2">
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
        // 페이팔 링크일 경우
        else if (chattingList[j].msg_type == 'paypal') {

            const msg_desc = chattingList[j].msg_desc;
            const teacher_name = msg_desc.teacher_name;
            const teacher_img = msg_desc.teacher_img;
            const class_name = msg_desc.class_name;
            const paypal_link = msg_desc.paypal_link;   
            const date = chattingList[j].msg_time;

            div.innerHTML = `
            <div class = "px-2">
                <div class = "text-center text-xs text-gray-500 my-2 border-2">
                    ${dayjs(parseInt(date)).format("MM월 DD일 hh:mm")}
                </div>
                <div class = "mx-auto bg-gray-50 rounded-lg px-2 pb-2 pt-1 w-1/2">
                    <div class = "text-sm text-gray-800"><span class = "text-gray-900">${teacher_name}</span class = "text-gray-700">님이 결제 링크를 보냈습니다.</div>
                    <button class = "w-full">
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
        else if (chattingList[j].msg_type == 'class_request') {

        }
        else if (chattingList[j].msg_type == 'class_approve') {

        }
        else if (chattingList[j].msg_type == 'class_cancel') {

        }

        chattingList_div.append(div);
   }
}

