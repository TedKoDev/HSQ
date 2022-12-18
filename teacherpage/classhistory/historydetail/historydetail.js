import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

// 유저 id 받아온 후 로컬 스토리지에서 삭제
const {id} = JSON.parse(localStorage.getItem("classId"));
let class_id = id;

getClassDetail();

async function getClassDetail() {

    const body = {

        token: getCookie(cookieName),
        kind: "tcdetail",
        class_register_id: class_id
    };
    const res = await fetch('/restapi/classinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();    
    
    console.log(response);
}