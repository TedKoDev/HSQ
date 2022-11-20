  
    // 회원가입시 입력한 정보 서버에 전송 후 결과에 따라 회원가입 실패 or 회원가입 성공 후 로그인 되어 메인페이지로 이동
    async function postData() {

        // 전송할 이름, 이메일, 비번
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById('pw').value;
  
        const body = {
          name: name,
          email: email,
          password: password,
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
          
          const warn = document.getElementById("email_warning");
          const input = document.getElementById("email");
  
          warn.style.visibility = 'visible';
          input.style.borderColor = '#EF4444'; // 경고 텍스트와 같은 색깔로 테두리도 변경
        }
      }    
  
  
      // 쿠키 생성 함수
      function setCookie(cName, cValue, cDay){
  
        const expire = new Date();
        expire.setDate(expire.getDate() + cDay);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)
        if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
        document.cookie = cookies;
      }
  
  // function onSignup() {
  
      //   let name = document.getElementById("name").value;
      //   let email = document.getElementById("email").value;
      //   let password = document.getElementById('pw').value;
  
        
      //   fetch("./signupProcess.php", {
      //     method: "POST",
      //     headers: {
      //       "Content-Type": "application/json",
      //     },
      //     body: JSON.stringify({
      //       name: name,
      //       email: email,
      //       password: password,
      //     }),
      //   }).then((response) => response.json())
      //   .then((data) => {        
                
      //   console.log(data)});         
        
      //   console.log(data.toString());
        
      // }