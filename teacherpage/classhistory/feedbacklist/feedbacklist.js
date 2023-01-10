import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import {selectHistoryType} from "../src/selectHistoryType.js";

// let selectType = selectHistoryType;

// 수업 목록 가져오기
getfeedbacklist();

async function getfeedbacklist() { 
        
    let body = {

        token: getCookie(cookieName),
        kind: 'feedback_teacher',        
    };   
    
    const res = await fetch('/restapi/review.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });    
    
    const response = await res.json();        
    
    console.log(response);

    new selectHistoryType($('#List'));    
}