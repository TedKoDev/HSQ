// 로그인시 입력한 정보 서버에 전송 후 결과에 따라 로그인 실패 or 로그인 성공 후 메인페이지로 이동
async function postData() {

    // 전송할 이메일, 비번    
    const email = document.getElementById("email").value;
    const password = document.getElementById('pw').value;

    console.log(email);
    console.log(password);

    const body = {      
    user_email: email,
    password: password,
    };
    const res = await fetch('./loginProcess.php', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });

    // 받아온 json 형태의 객체를 string으로 변환하여 파싱
    const response = await res.json();      
    const userinfo_json = JSON.stringify(response);     
    const userinfo_parse = JSON.parse(userinfo_json);

    const user_message = userinfo_parse.success;
    const user_name = userinfo_parse.user_name;
    const user_token = userinfo_parse.token;

    console.log(user_message);
    console.log(user_name);
    console.log(user_token);

    // 로그인 성공시 
    if (user_message == "yes") {

    // 토큰을 넣은 쿠키 생성. 쿠키 만료일은 30일
    setCookie("user_info", user_token, "30")      
    
    // 메인화면으로 이동
    location.replace("../index.php");
    

    }
    // 로그인 실패시
    else if (user_message == "no") {

    console.log("불일치");

    const warn = document.getElementById("warn");      

    warn.style.visibility = 'visible';      
    }
}    


// // 쿠키 생성 함수
// function setCookie(cName, cValue, cDay){

// const expire = new Date();
// expire.setDate(expire.getDate() + cDay);
// cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)
// if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
// document.cookie = cookies;
// }

// 이메일 입력값 실시간 확인
function printEmail() {

    const email = document.getElementById('email');    
    const email_check = document.getElementById('emailCheck');

    if(!isEmail(email.value)){	
		
        email.style.borderColor = '#EF4444';
        email_check.style.visibility = 'visible';
        
	}
    else {
        email.style.borderColor = '#9CA3AF';
        email_check.style.visibility = 'hidden';
        

    // 비밀번호 친 상태에서 이메일을 지웠다 다시 입력할 수도 있으므로 btnCheck() 함수 깔아놓기
    btnCheck()
    }       
}

//이메일 정규식 체크
function isEmail(asValue) {

	var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;

	return regExp.test(asValue); // 형식에 맞는 경우 true 리턴	

}

// 이메일/비밀번호 입력값이 모두 유효할 때만 버튼 활성화
function btnCheck() {

    const email = document.getElementById('email').value;
    const pw = document.getElementById('pw').value;
    const login_btn = document.getElementById('login_btn');

    if (isEmail(email) && pw > 0) {
        
        console.log("yes");
        login_btn.disabled = false;
    }
    else {
        console.log("no");
        login_btn.disabled = true;
    }
}