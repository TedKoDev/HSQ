    // 토큰 보내서 유저 정보 가져오기 
    // 가져올 정보 목록 :
    
    // - name 이름    
    // - p_img 프로필이미지
    // - bday 생일
    // --sex 성별    
    // - country 출신국가
    // - residence 거주국가
    
    // - language 구사 가능 언어
    // - korean 한국어 구사 수준
    // - teacher 강사여부 (학생, 튜터, 전문강사)
    // - intro 자기소개
    
    // 쿠기 값(토큰) 가져오기
    let tokenValue = getCookie(cookieName);   
    // 토큰 서버에 전송
  
    sendToken();

    // 화면 모두 로드되면 토큰 보내서 유저 정보 받아오기
    async function sendToken() {     
           
      // 서버에 토큰값 전달
      postToken(tokenValue);

      console.log("testst1");
    
    }

    // 토큰값을 서버로 전달한 뒤 유저 정보 받아오기
    async function postToken(tokenValue) {

      const value = tokenValue;     

      const body = {
        
        token : value,
      };
      console.log("testst2");
      const res = await fetch('./myinfoProcess.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;'
        },
        body: JSON.stringify(body)
      });  

      // 받아온 json 파싱
      const response = await res.json();
           
      const userinfo_json = JSON.stringify(response);     
      const userinfo_parse = JSON.parse(userinfo_json);

      const user_id = userinfo_parse.userid;
      const user_name = userinfo_parse.name;
      const user_email = userinfo_parse.email; 
      const user_p_img = userinfo_parse.p_img; 
      const user_bday = userinfo_parse.bday; 
      const user_sex = userinfo_parse.sex; 
      const user_contact = userinfo_parse.contact; 
      const user_country = userinfo_parse.country; 
      const user_residence = userinfo_parse.residence; 
      const user_point = userinfo_parse.point; 
      const user_language = userinfo_parse.language; 
      const user_korean = userinfo_parse.korean; 
      const user_teacher = userinfo_parse.teacher; 
      const user_intro = userinfo_parse.intro; 
      

      // 이름, 나이, 성별, 출신국가, 거주국가 대입, 구사 가능 언어, 한국어 구사 수준 대임
      let name = document.getElementById("name"); 
      let age = document.getElementById("age"); 
      let sex = document.getElementById("sex"); 
      let country = document.getElementById("country"); 
      let residence = document.getElementById("residence"); 
      let intro = document.getElementById("intro");
      let language = document.getElementById("language");
      let korean = document.getElementById("korean");

      // 이름, 자기소개는 그냥 출력하고 나이, 성별, 출신/거주 국가는 값이 있을 때만 출력
      name.innerText = user_name;    
      setInfo(age, user_bday, " 출생, ");
      setInfo(sex, user_sex, ", ");
      setInfo(country, user_country, " 출신, ");
      setInfo(residence, user_residence, " 거주");
      setInfo(intro, user_intro, "");
      setInfo(korean, user_korean, "")
      // intro.innerText = user_intro;      
      setLanguage(language, JSON.parse(user_language));
    }

    // 값이 있을 경우에만 브라우저에 출력
    function setInfo(key, value, text) {

      if (value != 'default') {                
       
        key.innerText = value+text;

        // console.log(key.value);
      }
      else {
        key.innerText = "";
      }
    }

    // 구사 가능 언어 출력 용 함수
    function setLanguage(key, value) {
        
      // 값이 있을 경우에만 등록한 구사 가능 언어 수만큼 화면에 출력
      if (value != 'default') {  
        
        // // 처음에는 key 값 초기화 (리턴 클릭했을 경우 기존 값들 없애줘야 함)
        // while (key.hasChildNodes())
        // {
        //   key.removeChild(key.firstChild);       
        // }
        
        for (let key_l in value) {

          let language_list = document.createElement('span');          
          language_list.innerHTML = ['<span class = "mr-2">'+key_l+' : '+value[key_l]+'</span>'].join("");
          key.appendChild(language_list);

          // console.log(key_l, value[key_l]);          
        }                 
                             
      }       
      else {
        key.innerText = "";
      }
    }