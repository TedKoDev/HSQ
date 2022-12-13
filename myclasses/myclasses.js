import App from "./src/classList.js";
import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

// 처음 로드되면 유형에 맞는 내 수업 렌더링 
window.addEventListener("DOMContentLoaded", (e) => {
  new App($("#classList"));
});

const body = {

  kind: 'clist',
  token: getCookie(cookieName),
  clReserveCheck: 'all',      
  };
  const res = await fetch('/restapi/classinfo.php', {
  method: 'POST',
  headers: {
      'Content-Type': 'application/json;charset=utf-8'
  },
  body: JSON.stringify(body)
  });

  const response = await res.json();

  console.log(response);

