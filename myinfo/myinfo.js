    // 토큰 보내서 유저 정보 가져오기 
    // 가져올 정보 목록 :
    // - userId 아이디
    // - name 이름
    // - email 이메일
    // - p_img 프로필이미지
    // - bday 생일
    // --sex 성별
    // - contact 연락처
    // - country 출신국가
    // - residence 거주국가
    // - point 포인트
    // - language 구사 가능 언어
    // - korean 한국어 구사 수준
    // - teacher 강사여부 (학생, 튜터, 전문강사)
    // - intro 자기소개
    
    // 쿠기 값(토큰) 가져오기
    let tokenValue = getCookie("user_info");   
    // 토큰 서버에 전송
    sendToken();

    // 화면 모두 로드되면 토큰 보내서 유저 정보 받아오기
    async function sendToken() {     
           
      // 서버에 토큰값 전달
      postToken(tokenValue);
    
    }

    // 토큰값을 서버로 전달한 뒤 유저 정보 받아오기
    async function postToken(tokenValue) {

      const value = tokenValue;     

      const body = {
        
        token : value,
      };

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

    //   console.log("user_id : "+user_id);
    //   console.log("user_name : "+user_name);
    //   console.log("user_email : "+user_email);
    //   console.log("user_p_img : "+user_p_img);
    //   console.log("user_bday : "+user_bday);
    //   console.log("user_sex : "+user_sex);
    //   console.log("user_contact : "+user_contact);
    //   console.log("user_country : "+user_country);
    //   console.log("user_residence : "+user_residence);
    //   console.log("user_point : "+user_point);
    //   console.log("user_languege : "+user_language);
    //   console.log("user_korean : "+user_korean);
    //   console.log("user_teacher : "+user_teacher);      
    //   console.log("user_intro : "+user_intro);

      // 이름, 나이, 성별, 출신국가, 거주국가 대입 (구사 가능 언어, 한국어 구사 수준은 프로필 편집 이후에 다시)
      let name = document.getElementById("name"); 
      let age = document.getElementById("age"); 
      let sex = document.getElementById("sex"); 
      let from_nation = document.getElementById("from_nation"); 
      let now_nation = document.getElementById("now_nation"); 
      let intro = document.getElementById("intro");

      // 이름, 자기소개는 그냥 출력하고 나이, 성별, 출신/거주 국가는 값이 있을 때만 출력
      name.innerText = user_name;    
      setInfo(age, user_bday, "세, ");
      setInfo(sex, user_sex, ", ");
      setInfo(from_nation, user_country, " 출신, ");
      setInfo(now_nation, user_residence, " 거주");
      intro.innerText = user_intro;      
      
    }

    // 값이 있을 경우에만 브라우저에 출력
    function setInfo(key, value, text) {

      if (value != null) {
        key.innerText = value+text;
      }
    }