  // 이름 실시간 체크
  function printName() {

    const name = document.getElementById('name');    
    const name_check = document.getElementById('nameCheck');

    if (name.value.length >=3 && name.value.length <= 20) {

      name.style.borderColor = '#9CA3AF';
      name_check.style.visibility = 'hidden';          
    }
    else {
      name.style.borderColor = '#EF4444';
      name_check.style.visibility = 'visible';
    }
  }

  // 이메일 실시간 체크
  function printEmail() {

    const email = document.getElementById('email');    
    const email_check = document.getElementById('emailCheck');

    if(!isEmail(email.value)){	

        email.style.borderColor = '#EF4444';
        email_check.style.visibility = 'visible';
        email_check.innerHTML = '유효한 이메일 주소를 입력하세요.'
        
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

    let regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;

    return regExp.test(asValue); // 형식에 맞는 경우 true 리턴	

  }

  // 비번 실시간 체크
  function printPw() {

    btnCheck();
  }

  // 이름/이메일/비밀번호 입력값이 모두 유효할 때만 버튼 활성화
  function btnCheck() {

    const name = document.getElementById('name');
    const email = document.getElementById('email').value;
    const pw = document.getElementById('pw');
    const signup_btn = document.getElementById('signup_btn');

    if ((name.value.length >=3 && name.value.length <=20)  && isEmail(email) && pw.value.length >= 8) {
        
        console.log("yes");
        signup_btn.disabled = false;
    }
    else {
        console.log("no");
        signup_btn.disabled = true;
    }
  }

  // 회원가입시 입력한 정보 서버에 전송 후 결과에 따라 회원가입 실패 or 회원가입 성공 후 로그인 되어 메인페이지로 이동
  async function postData() {

    // 전송할 이름, 이메일, 비번
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById('pw').value;

    // 로컬 타임존도 보내기
    const date = new Date();    
    const utc = -(date.getTimezoneOffset() / 60);

    const body = {
      name: name,
      email: email,
      password: password,
      utc: utc,
    };
    const res = await fetch('./signupProcess.php', {
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

      const user_message = userinfo_parse.message;
      const user_name = userinfo_parse.name;
      const user_token = userinfo_parse.token;

      console.log(user_message);
      console.log(user_name);
      console.log(user_token);

    // 중복된 이메일이 아닐 경우 
    if (user_message == "yes") {

      // 토큰을 넣은 쿠키 생성. 쿠키 만료일은 30일
      setCookie("user_info", user_token, "30")

      // 메인화면으로 이동
      location.replace("../index.php");

    }
    // 중복된 이메일일 경우 '
    else if (user_message == "no") {

      const email_check2 = document.getElementById('emailCheck');
      const input = document.getElementById("email");

      email_check2.style.visibility = 'visible';
      email_check2.innerHTML = '이미 등록된 이메일 주소입니다.'
      input.style.borderColor = '#EF4444'; // 경고 텍스트와 같은 색깔로 테두리도 변경
    }
  }  