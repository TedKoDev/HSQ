import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";

const tokenValue = getCookie(cookieName);

async function sendToken(token) {

    const body = {

        key: token,        
    };
    
    const res = await fetch('http://15.164.163.120:8080/', {
        method: 'POST',   
        headers: {
            'Content-Type': 'application/json;'
          },
        body: JSON.stringify(body)    
    }); 
    
    
    const response = await res.json();  

    console.log(response);

    if (response.success = 'yes') {

    }
    else {
        console.log("전송 안됨");
    }

}

const metaBtn = $('.goMetavarse');
metaBtn.addEventListener('click', () => {

    sendToken(tokenValue);
})

