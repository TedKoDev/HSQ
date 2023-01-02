import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";

const tokenValue = getCookie(cookieName);

async function sendToken(token) {

    if (token == "") {        
        
        alert("로그인이 필요합니다.");
        location.assign("/login");
    }
    else {

        // const body = {

        //     key: 22,   
        //     key2: 11     
        // };
        
        // const res = await fetch('http://15.164.163.120:8080/', {
        //     method: 'POST',   
        //     headers: {
        //         'Content-Type': 'application/json;'
        //       },
        //     body: JSON.stringify(body)    
        // }); 
        
        
        // const response = await res.json();  
                
        // if (response.state = 'success') {
            
        //     location.assign('http://15.164.163.120:8080/');
        // }
        // else {
        //     console.log("전송 안됨");
        // }

        let obj = {
            key: token
        }
        
        fetch("http://15.164.163.120:8080/",{
            method: "POST",
            headers : {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(obj),
        })
        .then((response)=>response.json())
        .then((data)=>{console.log(data.key);})
        .catch((error)=>{
            console.log(`전송 실패 : ${error}`);
        });
    
    }
    
}

const metaBtn = $('.goMetavarse');
metaBtn.addEventListener('click', () => {

    sendToken(tokenValue);
})

