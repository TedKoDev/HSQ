import { test, test_json } from "./example_json.js";
import {$, $_all} from "/utils/querySelector.js";
import { getCookie, cookieName, s3_url} from "/commenJS/cookie_modules.js";
import { getMyUtc } from "../utils/getMyUtc.js";

// 소켓 연결
const socket = io.connect("ws://3.39.249.46:8080/webChatting");
socket.on("connect", () => {
    socket.emit('enter_web_chat', getCookie(cookieName));
 });

let my_id;
let msgResult;
let utc = await getMyUtc(getCookie(cookieName));

// 채팅방 리스트 뿌리는 div
const chat_room_div = $('.chatroom_list');

// 채팅 메세지 전송할 때 현재 접속한(클릭한) 채팅방 확인을 위해 전역으로 채팅방id, 상대방id 선언, 최근 채팅방 시간 선언;
let chatId_global = 0;
let otherId_global;
let recent_msg_time_global;


// 채팅방 리스트 초기 세팅해주는 함수
init();

async function init() {

    // 서버에서 불러오기
    const body = {

        token: getCookie(cookieName)

    };
    
    const res = await fetch('/restapi/getchatmsg.php', {
        method: 'POST',   
        headers: {
            'Content-Type': 'application/json;'
        },
        body: JSON.stringify(body)          
    });   

    // 받아온 json 파싱하고 array 추출
    const response = await res.json();  
    
    if (response.success == 'yes') {

        my_id = response.my_id;
        msgResult = response.result;
        
        console.log(msgResult);
    }    


    // // 기존 채팅방 리스트 초기화
    while(chat_room_div.firstChild)  {
        chat_room_div.firstChild.remove();     
     }


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
            other_id = msgResult[i].receiver_id;
        }
        // 내가 sender_id일 경우
        else{
    
            user_name = msgResult[i].receiver_name;
            user_img = msgResult[i].receiver_img;  
            user_non_read_count = msgResult[i].sender_non_read_count; 
            
            // 상대방의 id 대입
            other_id = msgResult[i].sender_id;
        }
    
        recent_chat_date = dayjs(parseInt(msgResult[i].recent_msg_time)).format("MM월 DD일");
        recent_msg_desc = msgResult[i].recent_msg_desc;
       
        // 채팅방 추가           
        const src = s3_url+"Profile_Image/"+user_img;
        // 채팅방id, 채팅방 src, 상대방 이름, 최근 날짜, 최근 메세지, 안 읽은 메세지 수, 위에 추가인지/아래 추가인지
        addChatRoom(msgResult[i].chat_id, src, user_name, recent_chat_date, recent_msg_desc, user_non_read_count, "last");            
             
    }    

    // nowChatRoom 값이 null이 아닐 경우에는 nowChatRoom에 있는 채팅방 id를 클릭했을 때의 이벤트 리스너에서 작동하는 함수를 실행시켜주기
    const nowChatRoom_id = localStorage.getItem('nowChatRoom'); 
    if (nowChatRoom_id != null) {
        
        // clickChatRoom에 들어갈 매개변수 가져오는 과정

        // 원 가져오기
        const circle = document.getElementById(nowChatRoom_id+"_count");   
        
        // recent_msg_time 가져오기
        // 해당 채팅방 id의 인덱스 가져오기
        const index = msgResult.findIndex(i => i.chat_id == parseInt(nowChatRoom_id));
        const recent_msg_time = msgResult[index].recent_msg_time;

        // other_id, other_name 가져오기
        const receiver_id = msgResult[index].receiver_id;
        const sender_id = msgResult[index].sender_id;
        let other_id;
        let other_name;
        if (receiver_id == my_id) {
            other_id = sender_id;
            other_name = msgResult[index].sender_name;
        }
        else if (receiver_id != my_id) {
            other_id = receiver_id;
            other_name = msgResult[index].receiver_name;
        }

        clickChatRoom(circle, nowChatRoom_id, other_id, recent_msg_time, other_name);
    }   
}

// 채팅방 추가 (+클릭 시 이벤트 리스너)
function addChatRoom(chat_id, src, user_name, recent_chat_date, recent_msg_desc, non_read_count, location) {    
    
    const button = document.createElement("button");    
    button.setAttribute("class", "chat_room_btn w-full hover:bg-gray-200 px-2 border-b-2");

    // 만약 현재 본인이 들어가 있는 채팅방이면 회색처리
    if (chat_id == chatId_global) {
        button.classList.add('bg-gray-200');
    }
    else {
        button.classList.remove('bg-gray-200');
    }
    button.setAttribute("id", chat_id);
    button.innerHTML = `
            <div class = "flex w-full my-2">                
                <div class = "w-1/5 flex">
                <img
                    id = ${chat_id}_img
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src=${src}>
                </img>  
                </div>
                <div class = "w-4/5 flex flex-col">
                    <div class = "flex justify-between">
                        <span id = ${chat_id}_name class = "text-sm">${user_name}</span>
                        <span id = ${chat_id}_date class = "small_text text-xs text-center mb-1">${recent_chat_date}</span>
                    </div>
                    <div class = "flex justify-between">
                        <div id = ${chat_id}_desc class = "line_clamp_1 text-xs w-20 text-left">${recent_msg_desc}</div>
                        <div id = ${chat_id}_count class = "w-5 h-5 rounded-full bg-red-500 shadow text-sm text-white">${non_read_count}</div>
                    </div>
                </div>                            
            </div>`
            ;
        
    // 채팅방 마지막에 추가인지, 맨 위에 추가인지 여부
    if (location == "last") {
        chat_room_div.append(button);
    }
    else if (location == "first") {
        chat_room_div.prepend(button);
    }    

    // 안 읽은 메세지 갯수 0이면 빨간 원 안보이게 처리
    const circle = document.getElementById(chat_id+"_count");
    if (non_read_count == 0) {
        circle.classList.add('hidden');
    }
    else {
        circle.classList.remove('hidden');
    }   

    // other_id 구하기
    let other_id;
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_id));
    if (msgResult[index].sender_id == my_id) {
        other_id = msgResult[index].receiver_id;
    }
    else if (msgResult[index].sender_id != my_id) {
        other_id = msgResult[index].sender_id;
    }

    // 채팅방 클릭 시 이벤트 리스너
    button.addEventListener('click', () => {
            
        // 원, 채팅방id, 상대방id, 최근 날짜, 상대방 이름
        clickChatRoom(circle, chat_id, other_id, recent_chat_date, user_name);

    })     
}

// 채팅방 클릭했을 때 이벤트
function clickChatRoom(circle, chat_id, other_id, recent_msg_time, user_name) {

    // 클릭한 채팅방에서 본인의 non_read_count 0으로 만들기    
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_id));
    if (msgResult[index].sender_id == my_id) {
        msgResult[index].sender_non_read_count = 0;
    }
    else if (msgResult[index].sender_id != my_id) {
        msgResult[index].receiver_non_read_count = 0;
    }

    // circle에 0 적용
    circle.innerHTML = 0;

    // 클릭한 채팅방은 안 읽은 메세지 갯수 표시된 원 없애기
    circle.classList.add('hidden');
    
    // 소켓1 : 채팅방 입장 이벤트 (DB에서 해당 사용자의 lastcheck 업데이트)
    socket.emit('enter_chat_room', chat_id, my_id);            

    // 현재 클릭한 채팅방id와 상대방 id, 최근 채팅방시간을 전역변수에 각각 대입
    chatId_global = chat_id;
    otherId_global = other_id;
    recent_msg_time_global = recent_msg_time;

    // 채팅방에 입장할 경우에는 채팅 상대방의 이름과 전송 버튼이 표시
    checkNameOrInput(chatId_global);

    // 채팅방 위에 해당 유저 이름 표시하기    
    $('.user_name').classList.remove('hidden');
    $('.chatting_user_name').innerText = user_name;

    // 클릭한 채팅방 버튼 색깔 칠하기
    setBtnGray(chat_id);

    // 해당 채팅방의 채팅 내역 뿌려주기
    getChattingList(msgResult, chat_id);

    // 로컬 스토리지에 채팅방 id 저장
    localStorage.setItem('nowChatRoom', chat_id); 
    
}

function checkNameOrInput(chatId_global) {

    if (chatId_global == 0) {

        $('.user_name').classList.add('hidden');
        $('.user_name').classList.remove('flex');
        $('.send_group').classList.add('hidden');
        $('.send_group').classList.remove('flex');
    }
    else {
        $('.user_name').classList.remove('hidden');
        $('.user_name').classList.add('flex');
        $('.send_group').classList.remove('hidden');
        $('.send_group').classList.add('flex');
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


        // 채팅일 경우 이전 채팅과 비교해서 월:일 표시 여부 체크
        let showDateCheck;
        if ((j != 0) && (dayjs(parseInt(chattingList[j].msg_time)).format('YYYY/MM/dd') == dayjs(parseInt(chattingList[j-1].msg_time)).format('YYYY/MM/dd'))) {
            
            showDateCheck = 'no';
        }
        else {
            showDateCheck = 'yes';
        }


        // 일반 채팅일 경우
        if (chattingList[j].msg_type == 'text') {                                        
           
            const date = chattingList[j].msg_time;
            const user_img = chattingList[j].sender_img;        
            const msg_desc = chattingList[j].msg_desc;             

            if (chattingList[j].sender_id == my_id) {                   

                setText(div, date, user_img, msg_desc, 'yes', showDateCheck);       
                
            }
            else {               
               
                setText(div, date, user_img, msg_desc, 'no', showDateCheck);     
            }     
            
            chattingList_div.append(div);
        }
        // 페이팔 링크일 경우
        else if (chattingList[j].msg_type == 'payment_link') {

            const msg_id = chattingList[j].msg_id;
            const msg_desc = chattingList[j].msg_desc[0];
            const student_id = msg_desc.student_id;
            const teacher_id = msg_desc.teacher_id;
            const teacher_name = msg_desc.teacher_name;
            const teacher_img = msg_desc.teacher_img;
            const class_name = msg_desc.class_name;
            const payment_link = msg_desc.payment_link;  
            const class_id = msg_desc.class_register_id; 
            const date = chattingList[j].msg_time;

            setPayment(div, msg_id, dayjs(date), student_id, teacher_id, teacher_name, class_id, teacher_img, class_name, payment_link);  
                        
        }
        // 수업 예약/승인/취소일 경우
        else {
                        
            const msg_id = chattingList[j].msg_id;
            const msg_desc = chattingList[j].msg_desc[0];
            const sender_name = chattingList[j].sender_name;               
            const student_id = msg_desc.student_id;
            const teacher_id = msg_desc.teacher_id;        
            const teacher_img = msg_desc.teacher_img;
            const class_name = msg_desc.class_name;  
            const date = chattingList[j].msg_time;
            const class_id = msg_desc.class_register_id;

            if (chattingList[j].msg_type == 'request_class') {                
    
                setClassState(div, msg_id, dayjs(date), sender_name, class_id, student_id, teacher_id, teacher_img, class_name, '님이 수강 신청했습니다.')           
            }
            else if (chattingList[j].msg_type == 'acceptance_class') {
                   
                setClassState(div, msg_id, dayjs(date), sender_name, class_id, student_id, teacher_id, teacher_img, class_name, '님이 수강 요청을 수락했습니다.')
            }
            else if (chattingList[j].msg_type == 'cancel_class') {
                
                setClassState(div, msg_id, dayjs(date), sender_name, class_id, student_id, teacher_id, teacher_img, class_name, '님이 수업을 취소했습니다.')               
            }            
        }              
   }      
}

// 텍스트, paypal, 수업 요청/승인/취소 하는 컴포넌트

// 텍스트일 경우 대입하는 함수
function setText(div, date, user_img, msg_desc, me, showDateCheck) {

    let month_date = dayjs(date).format("MM월 DD일");

    if (showDateCheck == 'no') {
        month_date = '';
    }

    if (me == 'yes') {

        div.innerHTML = `
        <div class = "px-2">
            <div class = "text-center text-xs text-gray-500 my-2 border-2">${month_date}</div>
            <div class = "flex flex-row-reverse my-2">
                <img
                    id="user_image_chat"
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src="${s3_url}Profile_Image/${user_img}">
                </img> 
                <div class = "w-1/2 mr-2 p-2 text-sm bg-blue-200 border-blue-300 rounded-lg">
                    ${msg_desc}
                </div>
                <span class = "text-xs text-gray-400 mt-3 mr-1">${dayjs(date).format("hh:mm")}</span>
            </div>
        </div>
        `;
    }
    else {
        div.innerHTML = `
        <div class = "px-2">
            <div class = "text-center text-xs text-gray-500 my-2 border-2">${month_date}</div>
            <div class = "flex my-2">
                <img
                    id="user_image_chat"
                    class="my-auto w-6 h-6 border-gray-900 rounded-full"
                    src="${s3_url}Profile_Image/${user_img}">
                </img> 
                <span class = "w-1/2 ml-2 p-2 text-sm bg-gray-50 rounded-lg">
                    ${msg_desc}
                </span>       
                <span class = "text-xs text-gray-400 mt-3 ml-1">${dayjs(date).format("hh:mm")}</span>         
            </div>
        </div>
        `;
    }     
}

// 페이팔 링크일 경우 대입하는 함수
function setPayment(div, msg_id, date, student_id, teacher_id, teacher_name, class_id, teacher_img, class_name, payment_link) {

    div.innerHTML = `
        <div class = "px-2">
            <div class = "text-center text-xs text-gray-500 my-2 border-2">
                ${date.format("MM월 DD일 hh:mm")}
            </div>
            <div class = "mx-auto bg-gray-50 rounded-lg px-2 pb-2 pt-1 w-1/2">
                <div class = "text-sm text-gray-800"><span class = "text-gray-900">${teacher_name}</span class = "text-gray-700">님이 결제 링크를 보냈습니다.</div>
                <button id = ${msg_id}_class class = "w-full" value = ${class_id}>
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
                <div id = "linkList_${msg_id}" class = "linkList flex flex-col">
                </div>
                
            </div>
        </div> 
        `; 
    
    chattingList_div.append(div);

    // 결제 링크 리스트도 표시해주기
    const linkList = document.getElementById("linkList_"+msg_id);
    
    
    for (let i = 0; i < payment_link.length; i++) {

        const a = document.createElement('a');
        a.setAttribute("class", "text-xs text-blue-700");
        a.setAttribute("href" , payment_link[i]);
        a.innerText = payment_link[i];

        linkList.append(a);
    }

    
    
    // 버튼 클릭 이벤트 (클릭 시 해당 수업 상세로 이동)
    const btn = document.getElementById(msg_id+"_class");    
    // 클릭한 유저가 학생인지, 강사인지에 따라 분기처리해서 수업 상세로 이동  
    btn.addEventListener('click', () => {

        // 내가 강사인 경우 historydetail로 이동
        if (teacher_id == my_id) {

            goClassDetail(class_id, student_id, '/teacherpage/classhistory/historydetail/');
        }
        // 학생인 경우 myclass로 이동
        else {

            goClassDetail(class_id, my_id, '/myclass/');
        }
    }) 
}

// 수업 예약/승인/취소일 때 대입하는 함수
function setClassState(div, msg_id, date, sender_name, class_id, student_id, teacher_id, teacher_img, class_name, text) {

    
    div.innerHTML = `
    <div class = "px-2">
        <div class = "text-center text-xs text-gray-500 my-2 border-2">
            ${date.format("MM월 DD일 hh:mm")}
        </div>
        <div class = "mx-auto bg-gray-50 rounded-lg px-2 pb-2 pt-1 w-1/2">
            <div class = "text-sm text-gray-800"><span class = "text-gray-900">${sender_name}</span class = "text-gray-700">${text}</div>
            <button id = ${msg_id}_class class = "w-full" value = ${class_id}>
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

    chattingList_div.append(div);
        
    // 버튼 클릭 이벤트 (클릭 시 해당 수업 상세로 이동)
    const btn = document.getElementById(msg_id+"_class");    
    // 클릭한 유저가 학생인지, 강사인지에 따라 분기처리해서 수업 상세로 이동  
    btn.addEventListener('click', () => {

        // 내가 강사인 경우 historydetail로 이동
        if (teacher_id == my_id) {

            // goClassDetail(class_id, teacher_id, '/teacherpage/classhistory/historydetail/');
            goClassDetail(class_id, student_id, '/teacherpage/classhistory/historydetail/');
        }
        // 학생인 경우 myclass로 이동
        else {

            goClassDetail(class_id, student_id, '/myclass/');
        }
    })    
    
} 

// 수업 클릭시 수업 상세 화면으로 이동
function goClassDetail(class_id, student_id, url) {
            
    const form = document.createElement('form');
    form.setAttribute('method', 'get');    
    form.setAttribute('action', url);

    const hiddenField_class = document.createElement('input');
    hiddenField_class.setAttribute('type', 'hidden');
    hiddenField_class.setAttribute('name', 'class_id');
    hiddenField_class.setAttribute('value', class_id);
    const hiddenField_user = document.createElement('input');
    hiddenField_user.setAttribute('type', 'hidden');
    hiddenField_user.setAttribute('name', 'user_id');
    hiddenField_user.setAttribute('value', student_id);

    form.appendChild(hiddenField_class);
    form.appendChild(hiddenField_user);

    let gsWin = window.open("about:black", "winName");
    form.target = "winName";

    document.body.appendChild(form);

    form.submit();      
    
}

// 전송버튼 클릭
$('.send_btn').addEventListener('click', () => {

    sendTextMessage();
})

// 채팅방 나가기 버튼 클릭
$('.exit_btn').addEventListener('click', () => {
    
    exitChatRoom();
})

function sendTextMessage() {
    
    // 소켓서버에 메세지 전송 (채팅방 id, 채팅 메세지, 보내는 사람id, 받는 사람id)
    console.log(my_id);
    console.log(otherId_global);
    socket.emit('send_text_msg', chatId_global, $('.input_message').value, my_id, otherId_global);
    
    $('.input_message').value = "";    
}

function exitChatRoom() {

    socket.emit("exit_chat_room", chatId_global, my_id);
    
    // 현재 들어가 있는 채팅방 id 관련 기록 초기화
    chatId_global = 0;
    localStorage.removeItem('nowChatRoom');

    // 채팅 내역 뷰 초기화
    // 기존 채팅 내역 초기화
    while(chattingList_div.firstChild)  {
        chattingList_div.firstChild.remove();     
    }
    // 유저 이름 안보이게 처리
    $('.user_name').classList.add('hidden');

}

// 소켓 서버로부터 메세지 받을 때 채팅방에 가장 최근 메세지랑 날짜 업데이트 시키기
function updateRecentMsg_and_Date(index, chat_room_id, msg_date, chat_msg) {

    // 해당 채팅방의 recent_msg_time 업데이트 하고 웹 브라우저에도 표시되게 처리    
    msgResult[index].recent_msg_time = msg_date;            
    document.getElementById(chat_room_id+"_date").innerHTML = dayjs(msg_date).format("MM월 DD일");

    // 해당 채팅방의 recent_msg_desc 업데이트 하고 웹 브라우저에도 표시되게 처리    
    msgResult[index].recent_msg_desc = chat_msg;     
    document.getElementById(chat_room_id+"_desc").innerHTML = '';   
    document.getElementById(chat_room_id+"_desc").innerHTML = chat_msg;

    // 해당 채팅방이 맨 위가 아닐 경우 (index != 0일 경우) 해당 채팅방 삭제하고 그 채팅방 맨 위에 추가 (array는 건들지 않음)
    if (index != 0) {
        
        
        // 해당 채팅방의 유저 이미지(src), 유저 이름, 최근 날짜, 최근 메세지 내용, 안 읽은 메세지 수 추출        
        const user_img = document.getElementById(chat_room_id+"_img").src;
        const user_name = document.getElementById(chat_room_id+"_name").innerHTML;
        const recent_date = document.getElementById(chat_room_id+"_date").innerHTML;
        const recent_desc = document.getElementById(chat_room_id+"_desc").innerHTML;
        const non_read_count = document.getElementById(chat_room_id+"_count").innerHTML;
        // 해당 메세지 삭제
        document.getElementById(chat_room_id).remove();

        // 맨 위에 해당 채팅방 추가        
        addChatRoom(chat_room_id, user_img, user_name, recent_date, recent_desc, non_read_count, "first")

        
    }
}

// 채팅방 안에 없을 때 메세지 받으면 안 읽은 갯수 증가시키기
function adaptNonReadCount(index) {

    const circle = document.getElementById(msgResult[index].chat_id+"_count");    

    // 본인 id에 해당하는 non_read_count 1증가
    if (msgResult[index].sender_id == my_id) {
        msgResult[index].sender_non_read_count = parseInt(msgResult[index].sender_non_read_count)+1;
        // circle에 non_read_count 적용
        circle.innerHTML = msgResult[index].sender_non_read_count;
    }
    else if (msgResult[index].sender_id != my_id) {
        msgResult[index].receiver_non_read_count = parseInt(msgResult[index].receiver_non_read_count)+1;
        // circle에 non_read_count 적용
        circle.innerHTML = msgResult[index].receiver_non_read_count;
    }
    
    // 해당 채팅방에 circle 보이게 처리
    circle.classList.remove('hidden');

    
}

// 소켓서버에서 받는 로직
// 소켓 서버에서 들어오는 요청 받는 곳
socket.on('receive_text_msg', (chat_room_id, chat_msg, sender_id, sender_name, sender_img, msg_date, msg_id, msg_type) => {  
    
    console.log(msg_type);
    
    // 해당 채팅방의 인덱스 가져오기
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_room_id));
  

    // 받은 메세지 해당 채팅방의 array에 추가    
    const msg_json = {
        msg_id : msg_id, 
        msg_type : 'text', 
        sender_id : sender_id, 
        sender_name : sender_name, 
        sender_img : sender_img, 
        msg_desc : chat_msg, 
        msg_time : msg_date
    };
    msgResult[index].msg_list.push(msg_json);
   

    updateRecentMsg_and_Date(index, chat_room_id, msg_date, chat_msg);

    if (chat_room_id == chatId_global) { 
               
        
        // 읽었다고 소켓서버에 다시 보내기
        read_msg_check(chat_room_id, sender_id);

        let showDateCheck;        
        if (dayjs(msg_date).add(utc, "hour").format('YYYY/MM/DD') == dayjs(parseInt(recent_msg_time_global)).format('YYYY/MM/DD')) {
            showDateCheck = 'no';
        }
        else {
            showDateCheck = 'yes';
        }
       
        const div = document.createElement("div");

        if (sender_id == my_id) {
            
            setText(div, dayjs(msg_date).add(utc, "hour"), sender_img, chat_msg, 'yes', showDateCheck); 
                    
        }
        else {
                                   
            setText(div, dayjs(msg_date).add(utc, "hour"), sender_img, chat_msg, 'no', showDateCheck);
           
        }
        chattingList_div.append(div);     
        
        chattingList_div.scrollTop = chattingList_div.scrollHeight;     
    }
    else {

        // 채팅방 안에 없을 때 메세지 받으면 안 읽은 갯수 증가시키기
        adaptNonReadCount(index);
    }  
   
});

socket.on('receive_paypal_msg', (chat_room_id, class_register_id, class_name, teacher_name, 
    teacher_img, paypal_link, msg_date, student_id, teacher_id, msg_id, chat_msg, msg_type) => {
       
    // 해당 채팅방의 인덱스 가져오기
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_room_id));

    const link_array = JSON.parse(paypal_link);
    // 받은 메세지 해당 채팅방의 array에 추가    
    const msg_json = {
        msg_id : msg_id, 
        msg_type : 'payment_link', 
        sender_id : teacher_id, 
        sender_name : teacher_name, 
        sender_img : teacher_img, 
        msg_desc : 
            {
                class_register_id : class_register_id,
                class_name : class_name,
                student_id : student_id,
                teacher_id : teacher_id,
                teacher_name : teacher_name,
                teacher_img : teacher_img,
                payment_link : link_array,
            }, 
        msg_time : msg_date
    };
    msgResult[index].msg_list.push(msg_json);

    updateRecentMsg_and_Date(index, chat_room_id, msg_date, chat_msg);

    if (chat_room_id == chatId_global) {        

        // 읽었다고 소켓서버에 다시 보내기
        read_msg_check(chat_room_id, teacher_id);

        const div = document.createElement("div");

        console.log("paypal_link : "+paypal_link);
        setPayment(div, msg_id, dayjs(msg_date).add(utc, "hour"), student_id, teacher_id, teacher_name, class_register_id, teacher_img, class_name, link_array)
    
        chattingList_div.scrollTop = chattingList_div.scrollHeight;
    } 
    else {

        // 채팅방 안에 없을 때 메세지 받으면 안 읽은 갯수 증가시키기
        adaptNonReadCount(index);
    }    

    
});

socket.on('request_class', (chat_room_id, class_register_id, class_name, student_name, 
    teacher_img, msg_date, student_id, teacher_id, msg_id, chat_msg, msg_type) => {

    // 해당 채팅방의 인덱스 가져오기
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_room_id));
    
    // 받은 메세지 해당 채팅방의 array에 추가    
    const msg_json = {
        msg_id : msg_id, 
        msg_type : 'request_class', 
        sender_id : student_id, 
        sender_name : student_name, 
        sender_img : teacher_img, 
        msg_desc : 
            [{
                class_register_id : class_register_id,
                class_name : class_name,
                student_id : student_id,
                teacher_id : teacher_id,
                teacher_name : null,
                teacher_img : teacher_img                
            }], 
        msg_time : msg_date
    };
    msgResult[index].msg_list.push(msg_json);

    console.log(dayjs(parseInt(msg_date)).format("MM월 DD일"));

    updateRecentMsg_and_Date(index, chat_room_id, msg_date, chat_msg);

    if (chat_room_id == chatId_global) {
        
        // 읽었다고 소켓서버에 다시 보내기
        read_msg_check(chat_room_id, student_id);

        const div = document.createElement("div");        
        setClassState(div, msg_id, dayjs(msg_date).add(utc, "hour"), student_name, class_register_id, student_id, teacher_id, teacher_img, class_name, '님이 수강 신청했습니다.')

        chattingList_div.scrollTop = chattingList_div.scrollHeight;        
    }
    else {

       // 채팅방 안에 없을 때 메세지 받으면 안 읽은 갯수 증가시키기
       adaptNonReadCount(index);
    }    

    
});

socket.on('acceptance_class', (chat_room_id, class_register_id, class_name, teacher_name, 
    teacher_img, msg_date, student_id, teacher_id, msg_id, chat_msg, msg_type) => {

    // 해당 채팅방의 인덱스 가져오기
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_room_id));
    
    // 받은 메세지 해당 채팅방의 array에 추가    
    const msg_json = {
        msg_id : msg_id, 
        msg_type : 'acceptance_class', 
        sender_id : teacher_id, 
        sender_name : teacher_name, 
        sender_img : teacher_img, 
        msg_desc : 
            [{
                class_register_id : class_register_id,
                class_name : class_name,
                student_id : student_id,
                teacher_id : teacher_id,
                teacher_name : teacher_name,
                teacher_img : teacher_img                
            }], 
        msg_time : msg_date
    };
    msgResult[index].msg_list.push(msg_json);

    updateRecentMsg_and_Date(index, chat_room_id, msg_date, chat_msg);

    if (chat_room_id == chatId_global) {

        // 읽었다고 소켓서버에 다시 보내기      
        read_msg_check(chat_room_id, teacher_id);

        const div = document.createElement("div");

        setClassState(div, msg_id, dayjs(msg_date).add(utc, "hour"), teacher_name, class_register_id, student_id, teacher_id, teacher_img, class_name, '님이 수강 요청을 수락했습니다.')
    
        chattingList_div.scrollTop = chattingList_div.scrollHeight;
    }
    else {

       // 채팅방 안에 없을 때 메세지 받으면 안 읽은 갯수 증가시키기
       adaptNonReadCount(index);
    }    

   
});

socket.on('cancel_class', (chat_room_id, class_register_id, class_name, teacher_name, 
    teacher_img, msg_date, student_id, teacher_id, msg_id, chat_msg, msg_type, sender_id) => {
    
    // 해당 채팅방의 인덱스 가져오기
    const index = msgResult.findIndex(i => i.chat_id == parseInt(chat_room_id));
        
    // 받은 메세지 해당 채팅방의 array에 추가    
    const msg_json = {
        msg_id : msg_id, 
        msg_type : 'cancel_class', 
        sender_id : teacher_id, 
        sender_name : teacher_name, 
        sender_img : teacher_img, 
        msg_desc : 
            [{
                class_register_id : class_register_id,
                class_name : class_name,
                student_id : student_id,
                teacher_id : teacher_id,
                teacher_name : teacher_name,
                teacher_img : teacher_img                
            }], 
        msg_time : msg_date
    };
    msgResult[index].msg_list.push(msg_json);

    updateRecentMsg_and_Date(index, chat_room_id, msg_date, chat_msg);

    if (chat_room_id == chatId_global) {

        // 읽었다고 소켓서버에 다시 보내기        
        read_msg_check(chat_room_id, teacher_id);

        const div = document.createElement("div");

        console.log("msg_id : "+msg_id);

        setClassState(div, msg_id, dayjs(msg_date).add(utc, "hour"), teacher_name, class_register_id, student_id, teacher_id, teacher_img, class_name, '님이 수업을 취소했습니다.')

        chattingList_div.scrollTop = chattingList_div.scrollHeight;
    }
    else {

       // 채팅방 안에 없을 때 메세지 받으면 안 읽은 갯수 증가시키기
       adaptNonReadCount(index);
    }    
    
});

// 채팅방 나가기일 경우
socket.on('exit_chat_room', (response, chat_room_id, sender_id) => {
    
    console.log("pass1");
    // 내가 보낸 요청일 경우 채팅방 목록에서 없애기
    if (response == 'success') {
        console.log("pass2");
        if (sender_id == my_id) {
            console.log("pass3");
            // 해당 메세지 삭제
            document.getElementById(chat_room_id).remove();
        }
    }   
    
});

// 메세지 수신 시 수신된 메세지가 있는 방에 들어가 있는 경우
function read_msg_check(chat_room_id, sender_id) {      

    // 채팅 메세지 수신 시 해당 채팅방 안에 있을 경우 읽었다고 재 요청하는 이벤트 (본인이 보낸게 아닐 경우에만)
    socket.emit('read_msg', chat_room_id, sender_id);   
    socket.on('read_msg_check', (chat_room_id, sender_id) => {        
                
        console.log("read_msg_check");          
        
    });      
}




