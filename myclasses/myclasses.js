import classList from "./src/classList.js";
import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

// 담을 json 목록
export let responseAll;
export let responseApproved;
export let responseNotapproved;
export let responseDone;
export let responseCanceled;

// 처음 로드되면 유형에 맞는 내 수업 렌더링 
window.addEventListener("DOMContentLoaded", (e) => {
  
  showClassList();
});

async function showClassList() {

  new classList($("#classList"));
}

getClassList("all", responseAll);
getClassList("approved", responseApproved);
getClassList("wait", responseNotapproved);
getClassList("done", responseDone);
getClassList("cancel", responseCanceled);

async function getClassList(type, response) {

  const body = {

    kind: 'clist',
    token: getCookie(cookieName),
    clReserveCheck: type,      
    };
    const res = await fetch('/restapi/classinfo.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });
  
    response = await res.json();         
    
    if (type == "all") {
      responseAll = response;      
    }
    else if (type == "approved") {
      responseApproved = response;
    }
    else if (type == "wait") {
      responseNotapproved = response;
      
    }
    else if (type == "done") {
      responseDone = response;
      
    }
    else if (type == "cancel") {
      responseCanceled = response;      
    }        
}






