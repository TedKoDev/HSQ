import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";
import { classId } from "./historydetail.js";

const acceptModal = $('.acceptModal');
const acceptCancelBtn = $_all('.acceptCancelBtn');
const acceptBtn = $('.acceptBtn');
export async function classAccept() {    
    
    // 수업 확정 모달창 띄우기
    acceptModal.classList.remove('hidden');
   
    // 취소 버튼 클릭할 때 모달창 내리기
    const closeModel = () => {

        acceptModal.classList.add('hidden');
    }
    for (const cancel of acceptCancelBtn) {

        cancel.addEventListener('click', closeModel)
    }
    
    // 확정하기 버튼 클릭하면 DB에 값 전달하고 
    acceptBtn.addEventListener('click', accept)
    
}

async function accept() {        
    
    const body = {
        
        token: getCookie(cookieName),
        kind: "teacher",
        class_register_id: classId,
        class_register_status: 1
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

    window.location.reload();
}

export async function classCancel() {

}

export async function sendPaypalLink() {

}

