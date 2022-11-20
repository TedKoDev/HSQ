    // 토큰 보내서 유저 정보 가져오기 
    // 가져올 정보 목록 :
    
    // - name 이름    
    // - p_img 프로필이미지
    // - bday 생일
    // --sex 성별
    // - contact 연락처
    // - country 출신국가
    // - residence 거주국가    
    // - language 구사 가능 언어
    // - korean 한국어 구사 수준    
    // - intro 자기소개
    
    // 쿠기 값(토큰) 가져오기
    let tokenValue = getCookie(cookieName);   
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

      // 어짜피 내 정보 가져오는건 myinfoProcess랑 똑같으니까 거기에서 가져옴
      const res = await fetch('../myinfo/myinfoProcess.php', {
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

      
      const user_name = userinfo_parse.name;      
      const user_p_img = userinfo_parse.p_img; 
      const user_bday = userinfo_parse.bday; 
      const user_sex = userinfo_parse.sex; 
      const user_contact = userinfo_parse.contact; 
      const user_country = userinfo_parse.country; 
      const user_residence = userinfo_parse.residence;       
      const user_language = userinfo_parse.language; 
      const user_korean = userinfo_parse.korean;       
      const user_intro = userinfo_parse.intro; 
    

      // 이름, 나이, 성별, 출신국가, 거주국가 대입 (구사 가능 언어, 한국어 구사 수준은 프로필 편집 이후에 다시)
      let name = document.getElementById("name"); 
      let bday = document.getElementById("bday"); 
      let sex = document.getElementById("sex"); 
      let country = document.getElementById("country"); 
      let residence = document.getElementById("residence"); 
      let intro = document.getElementById("intro");

      // 이름, 자기소개는 그냥 출력하고 나이, 성별, 출신/거주 국가는 값이 있을 때만 출력
      name.innerText = user_name;    
      setInfo(bday, user_bday);
      setInfo(sex, user_sex);      
      setInfo(country, user_country);
      setInfo(residence, user_residence);
      setInfo(intro, user_intro);
      // intro.innerText = user_intro;      
      
    }

    // 수정 버튼 클릭 시 수정 가능하도록 뷰 변경
    // 이름 수정
    function editingName(name, namediv_not_edit) {        
        
        // 현재 이름 가져오기
        const user_name = document.getElementById(name);

        const namediv = document.getElementById(namediv_not_edit);
        
        namediv.style.display = 'none';

    }

    // 값이 있을 경우에만 브라우저에 출력
    function setInfo(key, value) {

      if (value != null) {
        key.innerText = value;
      }
      else {
        key.innerText = "없음";
      }
    }