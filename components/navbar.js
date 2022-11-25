// 1. 쿠키 여부에 따라 네비바 우측 상단 변경 (로그인/회원가입 or 유저 아이콘)
// 2. 유저 정보 클릭 시 아이콘 하단에 창 (수강신청, 프로필 설정, 로그아웃 등)

// 쿠키 값 가져오기 
let checkCookie = getCookie("user_info");    
let haein = 11;
console.log(haein);
// 쿠키 가져오는 함수
function getCookie(cName) {
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

// 화면 모두 로드되면 쿠키 여부에 따라 메뉴바 우측 상단의 뷰 결정
window.onload = function () {

  // 유저 아이콘, 로그인, 회원가입 뷰 초기화
  let userinfo = document.getElementById("id_user_info"); 
  let login = document.getElementById("id_login");
  let signup = document.getElementById("id_signup");

  if (checkCookie) { // 쿠키가 있을 경우 (로그인이 되어 있는 상태일 경우)       

    userinfo.style.display = 'block';
    login.style.display = 'none';
    signup.style.display = 'none';    

    // 서버에 토큰값 전달
    postToken_nav(checkCookie);
  }
  else {
    
    userinfo.style.display = 'none';
    login.style.display = 'block';
    signup.style.display = 'block';
  }
}

// 쿠키가 있을 경우 쿠키의 토큰값을 서버로 전달한 뒤 프로필 이미지, 유저 이름, 강사여부 받아오기
async function postToken_nav(tokenValue) {

  // console.log(tokenValue);

  const body = {
    
    token: tokenValue
  };

  const res = await fetch('../components/navbarProcess.php', {
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

  const user_p_img = userinfo_parse.p_img;
  const user_name = userinfo_parse.name;
  const user_teacher = userinfo_parse.teacher;

  console.log("user_teacher : "+user_teacher);

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
          
          key.src = "../editprofile/image/"+value;        
      }   
         
    }
    else {
      key.innerText = "";
    }
  }

  // console.log(userinfo_json);
  // console.log(userinfo_parse);
  // console.log(user_profile);
  // console.log(user_name);
  // console.log(user_teacher);
}

// 네비바 우측 상단 유저 프로필 아이콘 클릭 시 드롭다운 메뉴
async function userIcon_click() { 
    
  let dropdown_ct = document.getElementById("user_dropdown"); 
 
  dropdown_ct.style.display = 'block';  

}

// 다른곳 클릭시 드롭다운 없어지게 (일단은 좀 비효율적으로 구현함. 나중에 수정 필요)
document.addEventListener('mouseup', function(e) { 
  
  let usericon = document.getElementById('id_user_info');
  let dropdown_ct = document.getElementById("user_dropdown"); 

  if (!usericon.contains(e.target) && !dropdown_ct.contains(e.target)) {
    dropdown_ct.style.display = 'none';
  }
});


// 강사되기/강사페이지 클릭 시
async function go_teacher_page() {
   

  // 드롭다운의 값 가져오기 (강사되기 or 강사페이지)
  let teacher_dropdown = document.getElementById('teacher_page').innerHTML;
  
  // 강사 신청 안한 계정이면 강사 등록 페이지로 이동
  if (teacher_dropdown == '강사되기') {
        
    // 유저 프로필에 항목 다 채운 경우에만 강사 등록 화면으로 이동
    const body = {
    
      token: checkCookie
    };
  
    const res = await fetch('../registeacher/regischeckProcess.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(body)
    });    
    
    const response = await res.json();     
    

    // 모두 채웠을 경우 강사 등록 화면으로 이동
    
    if (response.success == 'yes') {

      location.replace("../registeacher/registeacher.php");

    }
    else {

      alert("강사 등록 시 회원 정보를 모두 작성해야 합니다.");
      location.replace("../editprofile/editprofile.php");
    }
    
  }
  // 강사일 경우 강사페이지로 이동
  else {
    
    location.assign("../teacherpage/t_myclass.php");
  }
}

// 로그아웃 클릭시
function logout() {
  
  // 쿠기 삭제
	deleteCookie("user_info");

  // 메인화면으로 이동
  location.replace("../index.php");

}

// // 쿠키 삭제하는 함수
// function deleteCookie(name) {
// 	document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
// }




