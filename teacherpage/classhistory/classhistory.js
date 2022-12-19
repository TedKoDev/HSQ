import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";
import selectHistoryType from "./src/selectHistoryType.js";

export let classList_json;

// 수업 목록 가져오기
getClasslist();

async function getClasslist() {

    const body = {

        token: getCookie(cookieName),
        kind: "tclist",
        class_reserve_check: "all",      
        // filter_class_status_check: "wait",  
        // filter_user_name: "ahsenq",
        // filter_class_name: "기초 한국어 회화"
        
        
    };
    const res = await fetch('/restapi/classinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });    
    
    classList_json = await res.json();    

    console.log(classList_json);
    
    new selectHistoryType($('#List'));
}




 