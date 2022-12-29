import {$, $_all} from '/utils/querySelector.js';
import { getMyId } from '../../utils/getMyid.js';
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";

// 소켓 연결
// const socket = io.connect("ws://3.39.249.46:8080/webChatting");


// 연락하기 버튼
const showModal_btn = $('.showSendmsgModal_btn');
// 모달창
const sendmsgModal = $('.sendmsgModal');
// 취소 버튼
const sendmsgModalCloseBtn = $_all(".sendmsgModalCloseBtn");
// 메세지 전송 버튼
const sendBtn = $('.sendBtn');
// 입력창
const inputMsg = $('.inputMsg');

// 보내는 사람, 받는 사람 id 선언
const sender_id = await getMyId(getCookie(cookieName));
const receiver_id = U_id; // 이 모달창이 필요한 부분에서 상대방id는 U_id로 통일시켰음


// 강사에게 연락하기 클릭 시 모달창 생성
function showModal() {    

    sendmsgModal.classList.remove('hidden');
}
showModal_btn.addEventListener('click', showModal);

// 취소 버튼 클릭 시 모달창 없애기
function closeModal() {

    sendmsgModal.classList.add('hidden');
}
for (const cancel of sendmsgModalCloseBtn) {

    cancel.addEventListener('click', closeModal);
}

// 전송 버튼 클릭 시 소켓으로 메세지 전송
function sendMsg() {
    
    socket.emit('send_text_msg', chat_id, inputMsg.value, sender_id, receiver_id);

    // 완료되었습니다 alert 띄운 뒤 모달창 닫기
    alert("전송되었습니다");
    sendmsgModal.classList.add('hidden');
}
sendBtn.addEventListener('click', sendMsg)



