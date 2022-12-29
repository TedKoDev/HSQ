import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";
import { classId, class_register_id, student_id, teacher_id, payment_array} from "./historydetail.js";
import {socket} from "./historydetail.js";

const acceptModal = $('.acceptModal');
const acceptModalCloseBtn = $_all('.acceptModalCloseBtn');
const acceptBtn = $('.acceptBtn');
export async function classAccept() {    
    
    // 수업 확정 모달창 띄우기
    acceptModal.classList.remove('hidden');
   
    // 취소 버튼 클릭할 때 모달창 내리기
    const closeModel = () => {

        acceptModal.classList.add('hidden');
    }
    for (const cancel of acceptModalCloseBtn) {

        cancel.addEventListener('click', closeModel)
    }
    
    // 확정하기 버튼 클릭
    acceptBtn.addEventListener('click', () => accept_or_cancel(1))
    
}

async function accept_or_cancel(status) {        
        
    const body = {
        
        token: getCookie(cookieName),
        kind: "teacher",
        class_register_id: class_register_id,
        class_register_status: status
    };
    const res = await fetch('/restapi/classaccept.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  

    console.log(response);

    if (response.success = 'yes') {

        if (status == 1) {
            alert("예약 확정되었습니다");
            socket.emit('acceptance_class', student_id, teacher_id, classId, class_register_id);
        }
        else if (status == 2) {
            alert("수업 취소되었습니다");
            socket.emit('cancel_class', student_id, teacher_id, classId, class_register_id);
        }
    
        window.location.reload();
    }
    else {
        console.log("통신 오류");
    }
    
}

const cancelModal = $('.cancelModal');
const cancelModalCloseBtn = $_all('.cancelModalCloseBtn');
const cancelBtn = $('.cancelBtn');
export async function classCancel() {

    // 수업 취소 모달창 띄우기
    cancelModal.classList.remove('hidden');
   
    // 취소 버튼 클릭할 때 모달창 내리기
    const closeModel = () => {

        acceptModal.classList.add('hidden');
    }
    for (const close of cancelModalCloseBtn) {

        close.addEventListener('click', closeModel)
    }
    
    // 확정하기 버튼 클릭하면 DB에 값 전달하고 
    cancelBtn.addEventListener('click', () => accept_or_cancel(2))
}


const linkModal = $('.paymentModal');
const linkModalCloseBtn = $_all('.paymentModalCloseBtn');
const sendLinkBtn = $('.sendLinkBtn');
const paymentList = $('.paymentList');
export async function sendPaymentLink() {

    // 결제링크 모달창 띄우기
    linkModal.classList.remove('hidden');

    // 결제 링크 목록 표시하기
    for (let i = 0; i < payment_array.length; i++) {

        const div = document.createElement("div");

        div.innerHTML = payment_array[i];

        paymentList.append(div);
    }

    // 취소 버튼 클릭할 때 모달창 내리기
    const closeModel = () => {

        linkModal.classList.add('hidden');
    }
    for (const close of linkModalCloseBtn) {

        close.addEventListener('click', closeModel)
    }

    // 링크 전송하기 버튼 클릭하면 소켓서버에서 요청하고 모달창 내리기
    sendLinkBtn.addEventListener('click', () => {

        socket.emit('send_paypal_msg', student_id, teacher_id, classId, class_register_id);
        alert("결제 링크가 전송되었습니다.");

        linkModal.classList.add('hidden');
    })
}

