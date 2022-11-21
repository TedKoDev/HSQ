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
      
      console.log(response);
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

      console.log(user_name);
      console.log(user_bday);
    

      // 이름, 나이, 성별, 출신국가, 거주국가 대입 (구사 가능 언어, 한국어 구사 수준은 프로필 편집 이후에 다시)
      let name = document.getElementById("name"); 
      let bday = document.getElementById("bday"); 
      let sex = document.getElementById("sex"); 
      let country = document.getElementById("country"); 
      let residence = document.getElementById("residence"); 
      let intro = document.getElementById("intro");

      // 이름, 자기소개는 그냥 출력하고 나이, 성별, 출신/거주 국가는 값이 있을 때만 출력
      name.innerText = user_name;   
      bday.innerText = user_bday;
      setInfo(bday, user_bday);
      setInfo(sex, user_sex);      
      setInfo(country, user_country);
      setInfo(residence, user_residence);
      setInfo(intro, user_intro);
      // intro.innerText = user_intro;      
      
    }

    // 값이 있을 경우에만 브라우저에 출력
    function setInfo(key, value) {

      if (value != 'default') {        
        
        // 생년월일일경우 받아온 것 파싱해서 년월일 글자 붙여서 출력
        // if (key == 'bday') {
          
        //   const bday_array = value.split('.');

        //   key.innerText = bday_array[0]+'년 '+bday_array[1]+'월 '+bday_array[2]+'일';
        // }
        key.innerText = value;

        console.log(key.value);
      }
      else {
        key.innerText = "";
      }
    }


    // 수정 버튼 클릭 시 수정 가능하도록 뷰 변경

    // 1. 프로필 이미지 수정
    
    



    // 2. 이름 수정

    // 현재 이름 가져오기
    let now_name = document.getElementById('name');
    // 이름 입력창 id 가져오기
    let input_name = document.getElementById('input_name');
    // 이름이랑 편집 아이콘 있는 div 가져오기
    let name_not_edit_div = document.getElementById('namediv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let name_click_edit_div = document.getElementById('namediv_click_edit'); 


    // 이름 수정   
    function editing_name() {           
                                   
      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      name_click_edit_div.style.display = 'block';
      // 이름이랑 편집 아이콘 안보이게 처리
      name_not_edit_div.style.display = 'none'; 
     
      // 현재 이름 입력창에 넣기
      input_name.value = now_name.innerHTML;
    }

    // 이름 수정 취소
    function edit_cancel_name() {              

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      name_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 다시 보이게 처리
      name_not_edit_div.style.display = 'block'; 
    }

    // 이름 수정 완료
    function edit_done_name() {
      
      // 입력창에서 수정한 값을 이름에 적용하기
      now_name.innerHTML = input_name.value;

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      name_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 안보이게 처리
      name_not_edit_div.style.display = 'block';       
      
      console.log(checkCookie);
      post_edit(checkCookie, "name", now_name.innerHTML);
      
    }


     // 3. 생년월일 수정
    // 현재 생년월일 가져오기
    let now_bday = document.getElementById('bday');
    // 년/월/일 id 가져오기
    let input_year = document.getElementById('select_year');
    let input_month = document.getElementById('select_month');  
    let input_day = document.getElementById('select_day');      
    // 생년월일이랑 편집 아이콘 있는 div 가져오기
    let bday_not_edit_div = document.getElementById('bdaydiv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let bday_click_edit_div = document.getElementById('bdaydiv_click_edit'); 

    // 생년월일 수정   
    function editing_bday() {           
                                   
      // 생년월일 값이 있을 경우에만 년/월/일을 대입
      if (now_bday.innerHTML != '') {
        
        // 서버에서 1997.1.27 이런 식으로 올 예정이므로 .를 기준으로 파싱 우선은 예시로 1997.1.27이라는 문자열로 테스트
        const bday_string = now_bday.innerHTML;

        const bday_array = bday_string.split('.');

        console.log(bday_array);
        // 년/월/일을 각각의 select에 대입
        input_year.value = bday_array[0];
        input_month.value = bday_array[1];
        input_day.value = bday_array[2];               
      }
      

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      bday_click_edit_div.style.display = 'block';
      // 이름이랑 편집 아이콘 안보이게 처리
      bday_not_edit_div.style.display = 'none';     
      
    }

    // 생년월일 수정 취소
    function edit_cancel_bday() {              

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      bday_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 다시 보이게 처리
      bday_not_edit_div.style.display = 'block'; 
    }

    // 생년월일 수정 완료
    function edit_done_bday() {
      
      // 입력창에서 수정한 년/월/일을 합쳐서 생년월일 적용하기
      now_bday.innerHTML = input_year.value+'.'+input_month.value+'.'+input_day.value;

      // 서버에 보낼 문자열 (년/월/일 사이에 . 추가)
      const bday_for_server = now_bday.innerHTML;

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      bday_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 안보이게 처리
      bday_not_edit_div.style.display = 'block';       
            
      post_edit(checkCookie, "bday", bday_for_server);
      
    }


    // 수정 사항 서버에 전달하는 함수 (백엔드 부분 처리될 때까지 보류)
    async function post_edit(token, position, desc) {

      const body = {
        token: token,
        position: position,
        desc: desc,
      };
      const res = await fetch('./editprofileProcess.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
      });

      // 받아온 json 형태의 객체를 string으로 변환하여 파싱
      const response = await res.json();   
      console.log(response);  
      const userinfo_json = JSON.stringify(response);     
      const userinfo_parse = JSON.parse(userinfo_json);

    }

    

    