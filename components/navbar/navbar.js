import {getCookie, deleteCookie} from '/commenJS/cookie_modules.js';
import {$, $_all} from '/utils/querySelector.js';

// 1. 쿠키 여부에 따라 네비바 우측 상단 변경 (로그인/회원가입 or 유저 아이콘)
// 2. 유저 정보 클릭 시 아이콘 하단에 창 (수강신청, 프로필 설정, 로그아웃 등)

// 쿠키 값 가져오기   
let checkCookie = getCookie("user_info");

// 쿠키 가져오는 함수
// function getCookie(cName) {
//   cName = cName + '=';
//   let cookieData = document.cookie;
//   let start = cookieData.indexOf(cName);
//   let cValue = '';
//   if(start != -1){
//   start += cName.length;
//   let end = cookieData.indexOf(';', start);
//   if(end == -1)end = cookieData.length;
//   cValue = cookieData.substring(start, end);
//   }
//   return unescape(cValue);
// }      

// 화면 모두 로드되면 쿠키 여부에 따라 메뉴바 우측 상단의 뷰 결정
window.onload = function () {

  // 유저 아이콘, 로그인, 회원가입 뷰 초기화
  let userinfo = document.getElementById("id_user_info"); 
  let login = document.getElementById("id_login");
  let signup = document.getElementById("id_signup");
  let myStudy = document.getElementById("myStudy");

  if (checkCookie) { // 쿠키가 있을 경우 (로그인이 되어 있는 상태일 경우)       

    userinfo.style.display = 'block';
    login.style.display = 'none';
    signup.style.display = 'none';    
    myStudy.style.display = 'block';

    // 서버에 토큰값 전달
    postToken_nav(checkCookie);
  }
  else {
    
    userinfo.style.display = 'none';
    login.style.display = 'block';
    signup.style.display = 'block';
    myStudy.style.display = 'none';
  }
}

// 쿠키가 있을 경우 쿠키의 토큰값을 서버로 전달한 뒤 프로필 이미지, 유저 이름, 강사여부 받아오기
async function postToken_nav(tokenValue) {

  // console.log(tokenValue);

  const body = {
    
    token: tokenValue
  };

  const res = await fetch('/components/navbar/navbarProcess.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
  });  
  
  // console.log(res);
  // 받아온 json 파싱
  const response = await res.json();      
  const userinfo_json = JSON.stringify(response);     
  const userinfo_parse = JSON.parse(userinfo_json);

  // console.log(response);

  const user_p_img = userinfo_parse.user_img;
  const user_name = userinfo_parse.user_name;
  const user_teacher = userinfo_parse.teacher_register_check;
 
  // 강사일 경우 드롭다운 메뉴에 '강사페이지'라고 표시
  if (user_teacher == 'yes') {

    document.getElementById("teacher_page").innerHTML = '강사페이지';
  }
  

  // 프로필 이미지 가져오기
  let p_img = document.getElementById("user_image");
  setInfo(p_img, user_p_img, "image");

  // 값이 있을 경우에만 브라우저에 출력
  function setInfo(key, value, text) {

    

    if ((value != 'default') && (value != null)) {        
      
      // 프로필 이미지일 경우
      if (text == 'image') {      
          
          // key.src = "../editprofile/image/"+value;        
          key.src = "https://hangle-square.s3.ap-northeast-2.amazonaws.com/Profile_Image/"+value;     
      }   
         
    }
    else {
      key.innerText = "";
    }
  }
}

// 네비바 우측 상단 유저 프로필 아이콘 클릭 시 드롭다운 메뉴
async function userIcon_click() { 
    
  let dropdown_ct = document.getElementById("user_dropdown"); 
 
  dropdown_ct.style.display = 'block';  

}

// 강사되기/강사페이지 클릭 시
const teacher_page = document.getElementById("teacher_page");

const go_teacher_page = async () => {

  // 드롭다운의 값 가져오기 (강사되기 or 강사페이지)
  let dropdownText = teacher_page.innerHTML;
  
  // 강사 신청 안한 계정이면 강사 등록 페이지로 이동
  if (dropdownText == '강사 되기') {
        
    // 유저 프로필에 항목 다 채운 경우에만 강사 등록 화면으로 이동
    const body = {
    
      token: checkCookie
    };
  
    const res = await fetch('/registeacher/regischeckProcess.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(body)
    });    
    
    const response = await res.json();     
    

    // 모두 채웠을 경우 강사 등록 화면으로 이동
    
    if (response.success == 'yes') {

      location.replace("/registeacher/");

    }
    else {

      alert("강사 등록 시 회원 정보를 모두 작성해야 합니다.");
      location.replace("/editprofile/");
    }
    
  }
  // 강사일 경우 강사페이지의 내 수업으로 이동
  else {
    
    location.assign("/teacherpage/t_myclass/");
  }
}
teacher_page.addEventListener('click', go_teacher_page)


// 로그아웃 클릭시
const logout = document.getElementById("logout");

const clickLogout = async () => {

  // 쿠기 삭제
  deleteCookie("user_info");

  // 메인화면으로 이동
  location.replace("/");
}

logout.addEventListener('click', clickLogout)

// 내 정보 클릭시
const goMyinfo = () =>  {
  
  location.assign("/myinfo/");
}
const myinfo = document.getElementById("myinfo");
myinfo.addEventListener('click', goMyinfo)


// 내 수업 클릭시
const goMyclasses = () =>  {
  
  location.assign("/myclasses/all/");
}
const myclass = document.getElementById("myclasses");
myclass.addEventListener('click', goMyclasses);


// 내 캘린더 클릭시
const goMyschedule = () => {

  location.assign("/myschedule/");
}
const mycalendar = $('#myschedule');
mycalendar.addEventListener('click', goMyschedule);


