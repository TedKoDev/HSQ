import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

// 타임존이랑 유저id 가져오기
get_utc(getCookie(cookieName));

// 타임존이랑 유저id 변수
let timezone;
let user_id;

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
      timezone = response.user_timezone;
      user_id = response.user_id;

      if (success == "yes") {

        // // 날짜 설정하고 checkbox값에 timestamp 부여
        // getDate("header_s", timezone, "");

        // // checkbox값 부여된 이후에 저장된 일정 세팅
        // setschedule("_l", "");
      }
      else {
        console.log("타임존 못불러옴")
      }
}

const body = {

    token: getCookie(cookieName),
    kind: "clist",
    class_reserve_check: "all", 
};

const res = await fetch('../restapi/classinfo.php', {
    method: 'POST',   
    headers: {
        'Content-Type': 'application/json;'
      },
    body: JSON.stringify(body)    
});  

// 받아온 json 파싱하고 array 추출
const response = await res.json();  

console.log(response);