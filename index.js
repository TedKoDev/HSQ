import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";

const tokenValue = getCookie(cookieName);


async function sendToken(token) {

    if (token == "") {        
        
        alert("로그인이 필요합니다.");
        location.assign("/login");
    }
    else {

        const body = {

            key: 22,   
            key2: 11     
        };
        
        const res = await fetch('http://15.164.163.120:8080/', {
            method: 'POST',   
            headers: {
                'Content-Type': 'application/json;'
              },
            body: JSON.stringify(body)    
        }); 
        
        
        const response = await res.json();  
                
        console.log(token);
        if (response.state = 'success') {
            
            console.log("ss");
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

