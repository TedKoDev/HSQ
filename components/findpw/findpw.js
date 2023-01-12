import {$, $_all} from '/utils/querySelector.js';
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";

// 비밀번호 찾기 버튼
const showModal_btn = $('.showfindpwModal');
// 모달창
const findpwModal = $('.findpwModal');
// 취소 버튼
const closeBtn = document.getElementById('close-modal');

// 메세지 전송 버튼
const sendBtn = $('.sendBtn');
// 입력창
const inputEmail = $('.inputEmail');
// 이메일 경고메세지
const warnText = $('.warnText_modal');

// 강사에게 연락하기 클릭 시 모달창 생성
function showModal() {    
    
    findpwModal.classList.remove('hidden');
}
showModal_btn.addEventListener('click', showModal);

// 취소 버튼 클릭 시 모달창 없애기
function closeModal() {

    findpwModal.classList.add('hidden');
}

closeBtn.addEventListener('click', closeModal);


// 전송 버튼 클릭 시 소켓으로 메세지 전송
async function sendMsg() {
    
    const body = {      

    email: inputEmail.value,        
    };
    const res = await fetch('./loginProcess.php', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });

    // 받아온 json 형태의 객체를 string으로 변환하여 파싱
    const response = await res.json();   
    
    if (response.success = 'yes') {
        // 완료되었습니다 alert 띄운 뒤 모달창 닫기
        alert("인증 메일이 전송되었습니다.");
        findpwModal.classList.add('hidden');
    }    
    else {
        warnText.classList.remove('hidden');
    }
}
sendBtn.addEventListener('click', sendMsg)
