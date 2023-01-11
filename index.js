import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";

const tokenValue = getCookie(cookieName);

async function sendToken(token) {

    if (token == "") {        
        
        alert("로그인이 필요합니다.");
        location.assign("/login");
    }
    else {

        let obj = {
            key: token
        }
        
        const request = fetch("http://15.164.163.120:8080/",{
            method: "POST",
            headers : {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(obj),
        })        
        .then((response)=>response.json())        

        const check = await request;        
        if (check.state == 'success') {
            
            location.assign('http://15.164.163.120:8080/');
        }
        else {
            console.log("전송 안됨");
        }    
    }
    
}

const metaBtn = $('.goMetavarse');
metaBtn.addEventListener('click', () => {

    sendToken(tokenValue);
})
