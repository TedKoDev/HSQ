import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";
import { calendarInit } from "./settingDate.js";

// 타임존이랑 유저id 가져오기
get_utc(getCookie(cookieName));

// 타임존이랑 유저id 변수
export let timezone;
export let user_id;

async function get_utc(tokenValue) {

    const body = {
    
        token: tokenValue
      };
    
      const res = await fetch('/utils/utc.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
      });  

      const response = await res.json();  
      const success = response.success;      

      if (success == "yes") {

        timezone = response.user_timezone;
        user_id = response.user_id;
      }
      else {
        console.log("타임존 못불러옴")
      }
}

// 해당 유저의 수업 목록 불러오기
const body = {

    token: getCookie(cookieName),
    kind: "tclist",
    class_reserve_check: "all", 
};

const res = await fetch('/restapi/classinfo.php', {
    method: 'POST',   
    headers: {
        'Content-Type': 'application/json;'
      },
    body: JSON.stringify(body)    
});  

// 받아온 json 파싱하고 array 추출
const response = await res.json();  

console.log(response);

// 캘린더에 날짜 세팅하고 받아온 json값 calendarInit에 전달
calendarInit(response);
