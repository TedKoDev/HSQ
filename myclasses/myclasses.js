import classList from "./src/classList.js";
import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

// 담을 json 목록 (나중에 page.js로 전달용)
export let responseAll;
export let responseApproved;
export let responseNotapproved;
export let responseDone;
export let responseCanceled;


// 모든 종류의 수업 유형 불러오기 
// (예제 코드랑 연동하다보니 중간에 비동기 통신 함수를 쓰는게 불가능하여 우선은 이런식으로 진행)
// (다른 부분(수업 히스토리, 강사/수업 필터등등)에서는 미리 비동기로 불러오는거 고려해서 설계하기)
getClassList("all", responseAll);
getClassList("approved", responseApproved);
getClassList("wait", responseNotapproved);
getClassList("done", responseDone);
getClassList("cancel", responseCanceled);

// 1. 수업리스트 가져오기
// 2. 수업 유형별로 json에 대입
// 3. all일 때만 classList 객체 생성
async function getClassList(type, response) {

  
  const body = {

    kind: 'clist',
    token: getCookie(cookieName),
    class_reserve_check: type,      
    };
    const res = await fetch('/restapi/classinfo.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });
  
    response = await res.json();         

    console.log(response);
       
    // 디폴트가 all 이므로 all일 경우 classList 인스턴스 선언
    if (type == "all") {
      responseAll = response;      
      new classList($("#classList"));       
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







