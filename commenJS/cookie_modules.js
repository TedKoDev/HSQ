// 쿠키 생성, 가져오기, 삭제


// 쿠키 이름 (user_info)
export let cookieName = 'user_info';

// s3 url (다른 곳에서 참조용)
export let s3_url = "https://hangle-square.s3.ap-northeast-2.amazonaws.com/";




// 쿠키 생성 함수
export function setCookie(cName, cValue, cDay){
    
  const expire = new Date();
  expire.setDate(expire.getDate() + cDay);
  cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)
  if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
  document.cookie = cookies;
}

// 쿠키 가져오는 함수 (쿠키 이름 : "user_info")
export function getCookie(cName) {

  cName = cName + '=';
  let cookieData = document.cookie;
  let start = cookieData.indexOf(cName);
  let cValue = '';
  if(start != -1){
  start += cName.length;
  let end = cookieData.indexOf(';', start);
  if(end == -1)end = cookieData.length;
  cValue = cookieData.substring(start, end);
  }
  return unescape(cValue);
} 

// 쿠키 삭제하는 함수
export function deleteCookie(name) {

document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'; 
}