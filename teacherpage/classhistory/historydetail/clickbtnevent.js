import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";
import { classId } from "./historydetail.js";

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
        class_register_id: classId,
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

    if (status == 1) {
        alert("예약 확정되었습니다");
        socket.emit('acceptance_class', classId);
    }
    else if (status == 2) {
        alert("수업 취소되었습니다");
        socket.emit('cancel_class', classId);
    }

    window.location.reload();
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

export async function sendPaypalLink() {

}

