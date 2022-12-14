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
    
    
    // 구사 가능 언어 재사용하기 위한 전역 변수
    var language_can;    

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

      
      const user_name = userinfo_parse.user_name;      
      const user_p_img = userinfo_parse.user_img; 
      const user_bday = userinfo_parse.user_birthday; 
      const user_sex = userinfo_parse.user_sex; 
      const user_contact = userinfo_parse.user_contact; 
      const user_country = userinfo_parse.user_country; 
      const user_residence = userinfo_parse.user_residence;   
      const user_timezone = userinfo_parse.user_timezone;    
      const user_language = userinfo_parse.user_language; 
      const user_korean = userinfo_parse.uesr_korean;       
      const user_intro = userinfo_parse.user_intro; 

      // const user_intro_parsing = user_intro.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n');

      // console.log(user_name);
      // console.log(user_bday);                 

      // 프로필이미지, 이름, 나이, 성별, 출신국가, 거주국가 대입 (구사 가능 언어, 한국어 구사 수준은 프로필 편집 이후에 다시)
      let p_img = document.getElementById("profile_image");
      let name = document.getElementById("name"); 
      let bday = document.getElementById("bday"); 
      let sex = document.getElementById("sex"); 
      let country = document.getElementById("country"); 
      let residence = document.getElementById("residence"); 
      let utc = document.getElementById("utc"); 
      let intro = document.getElementById("intro");
      let language = document.getElementById("language");
      let korean = document.getElementById("korean");

      // 이름, 자기소개는 그냥 출력하고 나이, 성별, 출신/거주 국가는 값이 있을 때만 출력
      name.innerText = user_name;   
      setInfo(p_img, user_p_img, "image");
      setInfo(bday, user_bday, "");
      setInfo(sex, user_sex, "");      
      setInfo(country, user_country, "");
      setInfo(residence, user_residence, "");
      
      setInfo(intro, user_intro, "");
      setInfo(korean, user_korean, "");

      // 구사 가능 언어 전역 변수에 서버에서 가져온 string 대입   
      language_can = user_language;      
      
      // 구사 가능 언어는 별도의 함수로 출력
      setLanguage(language, language_can);     

      console.log("first : "+language_can);

      // utc도 별도의 함수로 출력
      setTimezone(utc, user_timezone)                        
    }

    // 값이 있을 경우에만 브라우저에 출력
    function setInfo(key, value, text) {

      if ((value != 'default') && (value != null)) {     
        
        // 프로필 이미지일 경우
        if (text == 'image') {
          
          // key.src = "../editprofile/image/"+value;
          key.src = "https://hangle-square.s3.ap-northeast-2.amazonaws.com/Profile_Image/"+value;

        }

        else {
          key.innerText = value+text;
        }     

        // console.log(key.value);
      }
      else {
        key.innerText = "";
      }
    }
    
     // 구사 가능 언어 출력은 별도의 함수로 처리
     function setLanguage(key, value) {
        
      // 값이 있을 경우에만 등록한 구사 가능 언어 수만큼 화면에 출력
      if ((value != 'default') && (value != null)) {  

        const json_parse = JSON.parse(language_can);      
        
        // 처음에는 key 값 초기화 (리턴 클릭했을 경우 기존 값들 없애줘야 함)
        while (key.hasChildNodes())
        {
          key.removeChild(key.firstChild);       
        }
        
        for (let key_l in json_parse) {

          let language_list = document.createElement('span');          
          language_list.innerHTML = ['<span class = "mr-4">'+key_l+' : '+json_parse[key_l]+'</span>'].join("");
          key.appendChild(language_list);

          // console.log(key_l, value[key_l]);          
        }                 
                             
      }       
      else {
        key.innerText = "";
      }
    }
   
    function setTimezone(key, value) {
      
      let string;

      if (value >= 0) {      

        string = "UTC+"+value+":00";
        
      }
      else {      
        
        string = "UTC"+value+":00";       
        
      }

      key.innerText = string;
      

      // key.innerText = "UTC"+value.toString().length < 2 ? '0' + value : value;
    }
   


    // 수정 버튼 클릭 시 수정 가능하도록 뷰 변경

    // 1. 프로필 이미지 수정
    function image_change() {

      const sample_image = document.getElementsByName('image')[0]; 
      sample_image.addEventListener('change', () => {
        
        
        upload_image(sample_image.files[0]);          
            
      });
    }

    function upload_image(file) {
      
        //FormData형태에 file을 담아 fetch로 php로  넘기기
        const form_data = new FormData();

        console.log(tokenValue);
        
        form_data.append('sample_image', file); // 파일값 
        form_data.append('token', tokenValue);   // 토큰값 
        
        console.log(form_data);
        
        fetch("./editimage.php", {

          method:"POST",

            body:form_data            

        })

        .then(function(response){

          console.log(response);
          return response.json();

        }).then(function(responseData){
          
          console.log(responseData.image_path);
          document.getElementById('profile_image').src = responseData.image_path;                      
          // document.getElementById('user_image').src = "../editprofile/"+responseData.image_source; 
          document.getElementById('user_image').src = responseData.image_path; 

          console.log(responseData.image_path);
        });
    }
    

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
      
      console.log(tokenValue);
      post_edit(tokenValue, "name", now_name.innerHTML);
      
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
            
      post_edit(tokenValue, "bday", bday_for_server);
      
    }


    // 4. 성별 수정
    // 현재 성별 가져오기
    let now_sex = document.getElementById('sex');
    // 성별 입력 id 가져오기
    let input_sex = document.getElementById('select_sex');        
    // 생년월일이랑 편집 아이콘 있는 div 가져오기
    let sex_not_edit_div = document.getElementById('sexdiv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let sex_click_edit_div = document.getElementById('sexdiv_click_edit'); 

    // 성별 수정 클릭
    function editing_sex() {

      // 성별 값이 있을 경우에만 년/월/일을 대입
      if (now_sex.innerHTML != '') {
               
        const sex_string = now_sex.innerHTML;

        input_sex.value = sex_string;            
      }

       // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
       sex_click_edit_div.style.display = 'block';
       // 이름이랑 편집 아이콘 안보이게 처리
       sex_not_edit_div.style.display = 'none';   
      
    }

    // 성별 수정 취소
    function edit_cancel_sex() {

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      sex_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 안보이게 처리
      sex_not_edit_div.style.display = 'block'; 
    }

    // 성별 수정 완료
    function edit_done_sex() {

      // 입력창에서 수정한 성별을 화면에 표시
      now_sex.innerHTML = input_sex.value;

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      sex_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 다시 보이게 처리
      sex_not_edit_div.style.display = 'block';

      // 서버로 저장 요청
      post_edit(tokenValue, "sex", now_sex.innerHTML);
    }


    // 5. 국적/거주지 수정
    // 현재 국적 가져오기
    let now_country = document.getElementById('country');
    // 국적 입력 id 가져오기
    let input_country = document.getElementById('select_country');        
    // 국적이랑 편집 아이콘 있는 div 가져오기
    let country_not_edit_div = document.getElementById('countrydiv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let country_click_edit_div = document.getElementById('countrydiv_click_edit');
    
    // 현재 거주지 가져오기
    let now_residence = document.getElementById('residence');
    // 거주지 입력 id 가져오기
    let input_residence = document.getElementById('select_residence');        
    // 거주지랑 편집 아이콘 있는 div 가져오기
    let residence_not_edit_div = document.getElementById('residencediv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let residence_click_edit_div = document.getElementById('residencediv_click_edit');

    // 국적 수정 클릭
    function editing_country() {

      editing_nation(now_country, input_country, country_click_edit_div, country_not_edit_div); 
      
    }

    // 거주지 수정 클릭
    function editing_residence() {

      editing_nation(now_residence, input_residence, residence_click_edit_div, residence_not_edit_div);
      
    }

    // 국적/거주지 수정 함수
    function editing_nation(now_, input_, click_edit, not_edit) {

        // 값이 있을 경우에만 대입
        if (now_.innerHTML != '') {        
        
          const string = now_.innerHTML;

          input_.value = string;            
        }

        // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
        click_edit.style.display = 'block';
        // 텍스트랑 편집 아이콘 안보이게 처리
        not_edit.style.display = 'none';   
    }

    // 국적 수정 취소 클릭
    function edit_cancel_country() {

      edit_cancel_nation(country_click_edit_div, country_not_edit_div);
    }

    // 거주지 수정 취소 클릭
    function edit_cancel_residence() {
     
      edit_cancel_nation(residence_click_edit_div, residence_not_edit_div);
    }

    // 국적/거주지 수정 취소 함수
    function edit_cancel_nation(click_edit, not_edit) {

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      click_edit.style.display = 'none';
      // 텍스트랑 편집 아이콘 안보이게 처리
      not_edit.style.display = 'block'; 
    }

    // 국적 수정 완료
    function edit_done_country() {

      edit_done_nation('country', now_country, input_country, country_click_edit_div, country_not_edit_div);
    }

    // 거주지 수정 완료
    function edit_done_residence() {

      edit_done_nation('residence', now_residence, input_residence, residence_click_edit_div, residence_not_edit_div);
    }

    // 국적/거주지 수정 완료 함수
    function edit_done_nation(nation, now_, input_, click_edit, not_edit) {

      // 입력창에서 수정한 값을 화면에 표시
      now_.innerHTML = input_.value;

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      click_edit.style.display = 'none';
      // 텍스트랑 편집 아이콘 다시 보이게 처리
      not_edit.style.display = 'block';

      // 서버로 저장 요청
      post_edit(tokenValue, nation, now_.innerHTML);
    }

    // 6. 시간대 수정
    // 현재 시간대 가져오기
    let now_utc = document.getElementById('utc');
    // 시간대 입력 id 가져오기
    let input_utc = document.getElementById('select_utc');        
    // 시간대랑 편집 아이콘 있는 div 가져오기
    let utc_not_edit_div = document.getElementById('utcdiv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let utc_click_edit_div = document.getElementById('utcdiv_click_edit');

    // 시간대 수정 아이콘 클릭
    function editing_utc() {

       // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
       utc_click_edit_div.style.display = 'block';
       // 텍스트랑 편집 아이콘 안보이게 처리
       utc_not_edit_div.style.display = 'none';               
    }

    // 시간대 수정 취소 클릭
    function edit_cancel_utc() {

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      utc_click_edit_div.style.display = 'none';
      // 텍스트랑 편집 아이콘 보이게 처리
      utc_not_edit_div.style.display = 'block'; 
    }
  
    // 시간대 수정 완료 클릭
    function edit_done_utc() {
      
      // 입력창에서 수정한 값을 화면에 표시
      now_utc.innerHTML = input_utc.options[input_utc.selectedIndex].text;

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      utc_click_edit_div.style.display = 'none';
      // 텍스트랑 편집 아이콘 다시 보이게 처리
      utc_not_edit_div.style.display = 'block';

      // 서버로 저장 요청
      post_edit(tokenValue, "utc", input_utc.value);
    }




    // 7. 자기 소개 수정
    // 현재 자기소개 가져오기
    let now_intro = document.getElementById('intro');
    // 자기소개 입력 id 가져오기
    let input_intro = document.getElementById('input_intro');        
    // 자기소개랑 편집 아이콘 있는 div 가져오기
    let intro_not_edit_div = document.getElementById('introdiv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let intro_click_edit_div = document.getElementById('introdiv_click_edit');


    // 자기소개 수정   
    function editing_intro() {           
                                   
      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      intro_click_edit_div.style.display = 'block';
      // 이름이랑 편집 아이콘 안보이게 처리
      intro_not_edit_div.style.display = 'none';          

      // 자기소개 값이 있을 경우에만 현재 자기소개 입력창에 넣기
      if (now_intro.innerHTML != '') {

        input_intro.value = now_intro.innerHTML.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n');
      } 
    }

    // 자기소개 수정 취소
    function edit_cancel_intro() {              

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      intro_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 다시 보이게 처리
      intro_not_edit_div.style.display = 'block'; 
    }

    // 자기소개 수정 완료
    function edit_done_intro() {           

      // 입력창에서 수정한 값을 자기소개에 적용하기
      now_intro.innerHTML = input_intro.value.replace(/(\n|\r\n)/g, '<br>');

      // 줄바꿈 치환해서 서버에 저장
      let string = now_intro.innerHTML.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n');

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      intro_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 안보이게 처리
      intro_not_edit_div.style.display = 'block';       
      
      // 서버에 저장 요청
      post_edit(tokenValue, "intro", string);
      
    }

    // 8. 구사 가능 언어 수정
    // 현재 구사 가능 언어 가져오기
    let now_language = document.getElementById('language');
    // 자기소개 입력 id 가져오기
    let input_language = document.getElementById('input_language');        
    // 자기소개랑 편집 아이콘 있는 div 가져오기
    let language_not_edit_div = document.getElementById('languagediv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let language_click_edit_div = document.getElementById('languagediv_click_edit');

    // 구사가능 언어 수정 
    function editing_language() {    
      
      // 리턴 버튼 보이게
      const return_btn = document.getElementById('language_return_btn');
      return_btn.style.display = 'block';
                                   
      // 저장, 취소 버튼 안 보이게
      const save_btn = document.getElementById('save_language_btn');
      const cancel_btn = document.getElementById('cancel_language_btn');
      save_btn.style.display = 'none';
      cancel_btn.style.display = 'none';

      let now_language = document.getElementById('language');
      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      language_click_edit_div.style.display = 'block';
      // 이름이랑 편집 아이콘 안보이게 처리
      language_not_edit_div.style.display = 'none';          

      // 구사 가능 언어 값이 있을 경우에만 개수 만큼 select 만들고 key, value 집어넣기
      if (now_language.innerHTML != '') {
                          
        let json_parse = JSON.parse(language_can);

        // 구사 가능 언어 div의 id값을 다르게 주기 위한 index
        let index = 0;

        // 구사 가능한 언어 목록 표시용 div 가져오기
          let now_select = document.getElementById('now_select');   
                
         // db에서 받아온 값 렌더링
         language_render(index, json_parse);        

      } 
    }

    // 구사 가능 언어 더 추가
    function add_select() {

      // 더 추가 버튼 안보이게 (취소 버튼 누를 때 다시 보여야 함)
      const add_language = document.getElementById('add_language');
      add_language.style.display = 'none';

      // 저장, 취소 버튼 다시 보이게
      const save_btn = document.getElementById('save_language_btn');
      const cancel_btn = document.getElementById('cancel_language_btn');
      save_btn.style.display = 'block';
      cancel_btn.style.display = 'block';

      // 언어 삭제 버튼 안보이게
      const delete_l = document.getElementsByName('delete_l');
      const delete_length = delete_l.length;     
      for (let i = 0; i < delete_length; i++) {
        delete_l[i].style.display = 'none';
      }      

      // 구사 가능 언어 불러오기      
      
      console.log("language_can : "+language_can);

      // 만약 기존 값이 있을 경우
      if ((language_can != 'default') && (language_can != null)) {

        let json_parse = JSON.parse(language_can);

        // div와 select에 id값 부여하기 위한 index (현재 json 길이에 1 추가)
        let index = Object.keys(json_parse).length + 1;
        console.log("index : "+index);
        
        // selector 추가
        add_language_select(index);
        
      } 
      // 기존 값이 없을 경우 
      else {

        // index 0으로 할당
        let index = 0;     
        
        add_language_select(index);
      }
      
    }

    // 구사 가능 언어 선택 추가 함수
    function add_language_select(index) {

      // select 용 div 가져오기
      let select_box = document.getElementById('select_box');
      // select를 담을 div 태그 생성
      const div = document.createElement('div');
      // select용 div에 div에 새롭게 생성한 div 연결
      select_box.appendChild(div);
      // div의 id에 값 부여
      div.setAttribute("id", "div_"+index);      
      

      //// 언어용 select 생성
      const select_language = document.createElement('select');
      // select에 select의 인덱스값 부여
      select_language.setAttribute("id", "select_language_"+index);
      // select에 css 설정
      select_language.setAttribute("class", "w-44 px-1 py-1 text-sm text-gray-500 rounded border border-gray-200 mb-3 mr-3");    

      // select 안에 option 추가
      select_language.innerHTML = [         
        '<option value="" disabled selected hidden>언어</option>',   
        "<option value = '영어'>영어</option>",
        "<option value = '스페인어'>스페인어</option>",
        "<option value = '중국어'>중국어</option>",
        "<option value = '일본어'>일본어</option>",
        "<option value = '러시아어'>러시아어</option>",
        "<option value = '프랑스어'>프랑스어</option>"].join("");    
      
      // select를 div 아래에 연결
      div.appendChild(select_language);


      //// 레벨용 select 생성
      const select_level = document.createElement('select');
      // select에 값 부여
      select_level.setAttribute("id", "select_level_"+index);
      
      // select에 css 설정
      select_level.setAttribute("class", "w-44 px-1 py-1 text-sm text-gray-500 rounded border border-gray-200 mb-3 mr-3");
     
      // select 안에 option 추가
      select_level.innerHTML = [   
        '<option value="" disabled selected hidden>레벨</option>',          
        "<option value = 'A1'>A1 : 초보</option>",
        "<option value = 'A2'>A2 : 기초</option>",
        "<option value = 'B1'>B1 : 중급</option>",
        "<option value = 'B2'>B2 : 중상급</option>",
        "<option value = 'C1'>C1 : 고급</option>",
        "<option value = 'C2'>C2 : 고급 이상</option>",
        "<option value = '원어민'>원어민</option>"].join("");             
     
      // 언어용 select 뒤에 레벨용 select 배치
      select_language.after(select_level);
    }

    // 구사 가능 언어 저장 (현재 보이는 select의 정보를 기존의 json과 합치기)
    function edit_done_language() {

      // 언어 삭제 버튼 다시 보이게      
      const delete_l = document.getElementsByName('delete_l');
      const delete_length = delete_l.length;     
      for (let i = 0; i < delete_length; i++) {
        delete_l[i].style.display = 'block';
      }  

      // 구사 가능 언어 불러와서 파싱  
      // 기존 값이 있을 경우
      if ((language_can != 'default') && (language_can != null)) {

        let json_parse = JSON.parse(language_can);

        //  추가한 select의 id값을 가져오기 위한 index (현재 json 길이에 1 추가)
        let index = Object.keys(json_parse).length + 1;

        // 언어 select랑 레벨 select값 가져오기
        const select_language = document.getElementById("select_language_"+index).value;
        const select_level = document.getElementById("select_level_"+index).value;
      
        // 기존의 json과 새로운 key,value 합체
        json_parse[select_language] = select_level;
        
        // 전역 변수에 json 추가된 내역 string으로 변환해서 대입
        language_can = JSON.stringify(json_parse);

        // 서버에 저장 요청
        post_edit(tokenValue, "language", language_can);

        console.log(language_can);

        // 1)저장,취소 버튼 안보이게 하고 2)더추가 버튼 보이게하고 3) select 삭제
        const add_language = document.getElementById('add_language');
        const save_btn = document.getElementById('save_language_btn');
        const cancel_btn = document.getElementById('cancel_language_btn');
        const select_box = document.getElementById('select_box');

        add_language.style.display = 'block';
        save_btn.style.display = 'none';
        cancel_btn.style.display = 'none';           
        // select용 div 안에 자식 요소 (이 경우 select) 모두 삭제
        while (select_box.hasChildNodes()) {

          select_box.removeChild(select_box.firstChild);
        }

        
          // 변경 사항에 맞추어 재 렌더링
          // 구사 가능 언어 div의 id값을 다르게 주기 위한 index
          let index_after = 0;        

          // 구사 가능한 언어 목록 표시용 div 가져오기
          let now_select = document.getElementById('now_select');  
          // now_select의 값 초기화     
          while (now_select.hasChildNodes()) {

            now_select.removeChild(now_select.firstChild);
          }        

          // 수정 반영해서 재 렌더링
          language_render(index_after, json_parse);    

        }
        // 기존 값이 없을 경우
        else {
          
          // index 0으로 할당
          let index = 0;

          // 언어 select랑 레벨 select값 가져오기
          const select_language = document.getElementById("select_language_"+index).value;
          const select_level = document.getElementById("select_level_"+index).value;
        
          // 기존의 json과 새로운 key,value 합체
          // json_parse[select_language] = select_level;
          
          // 새로운 json 생성
          const new_json = new Object();
          new_json[select_language] = select_level;

          // 전역 변수에 새로운 json string으로 변환해서 대입
          language_can = JSON.stringify(new_json);

          // 서버에 저장 요청
          post_edit(tokenValue, "language", language_can);

          console.log(language_can);

          // 1)저장,취소 버튼 안보이게 하고 2)더추가 버튼 보이게하고 3) select 삭제
          const add_language = document.getElementById('add_language');
          const save_btn = document.getElementById('save_language_btn');
          const cancel_btn = document.getElementById('cancel_language_btn');
          const select_box = document.getElementById('select_box');

          add_language.style.display = 'block';
          save_btn.style.display = 'none';
          cancel_btn.style.display = 'none';           
          // select용 div 안에 자식 요소 (이 경우 select) 모두 삭제
          while (select_box.hasChildNodes()) {

            select_box.removeChild(select_box.firstChild);
          }

          
            // 변경 사항에 맞추어 재 렌더링
            // 구사 가능 언어 div의 id값을 다르게 주기 위한 index
            let index_after = 0;        

            // 구사 가능한 언어 목록 표시용 div 가져오기
            let now_select = document.getElementById('now_select');  
            // now_select의 값 초기화     
            while (now_select.hasChildNodes()) {

              now_select.removeChild(now_select.firstChild);
            }        

            // 새롭게 생성한 json 랜더링
            language_render(index_after, new_json);
        }       
    }

    // function language_render_setting(json, select_language, select_level) {

    //   // 새로운 json 생성
    //   json = new Object();
    //   json[select_language] = select_level;

    //   // 전역 변수에 새로운 json string으로 변환해서 대입
    //   language_can = JSON.stringify(new_json);

    //   // 서버에 저장 요청
    //   post_edit(tokenValue, "language", language_can);

    //   console.log(language_can);

    //   // 1)저장,취소 버튼 안보이게 하고 2)더추가 버튼 보이게하고 3) select 삭제
    //   const add_language = document.getElementById('add_language');
    //   const save_btn = document.getElementById('save_language_btn');
    //   const cancel_btn = document.getElementById('cancel_language_btn');
    //   const select_box = document.getElementById('select_box');

    //   add_language.style.display = 'block';
    //   save_btn.style.display = 'none';
    //   cancel_btn.style.display = 'none';           
    //   // select용 div 안에 자식 요소 (이 경우 select) 모두 삭제
    //   while (select_box.hasChildNodes()) {

    //     select_box.removeChild(select_box.firstChild);
    //   }

      
    //     // 변경 사항에 맞추어 재 렌더링
    //     // 구사 가능 언어 div의 id값을 다르게 주기 위한 index
    //     let index_after = 0;        

    //     // 구사 가능한 언어 목록 표시용 div 가져오기
    //     let now_select = document.getElementById('now_select');  
    //     // now_select의 값 초기화     
    //     while (now_select.hasChildNodes()) {

    //       now_select.removeChild(now_select.firstChild);
    //     }        

    //     // 새롭게 생성한 json 랜더링
    //     language_render(index_after, json);
    // }

    // 구사가능언어 수정 취소 (구사가능언어에서는 아예 취소되는게 아니라 select하던 것만 취소되는 형태)
    function edit_cancel_language() {        
            
      // 언어 삭제 버튼 다시 보이게      
      const delete_l = document.getElementsByName('delete_l');
      const delete_length = delete_l.length;     
      for (let i = 0; i < delete_length; i++) {
        delete_l[i].style.display = 'block';
      }
      
      // 더 추가 버튼 다시 보이게
      const add_language = document.getElementById('add_language');
      add_language.style.display = 'block';

      // select 용 div 가져오기
      let select_box = document.getElementById('select_box');

      // select용 div 안에 자식 요소 (이 경우 select) 모두 삭제
      while (select_box.hasChildNodes()) {

        select_box.removeChild(select_box.firstChild);
      }

      // 저장, 취소 버튼 안 보이게
      const save_btn = document.getElementById('save_language_btn');
      const cancel_btn = document.getElementById('cancel_language_btn');
      save_btn.style.display = 'none';
      cancel_btn.style.display = 'none';
    }

    // 처음 편집 클릭할 때 구사 가능 언어 렌더링 되거나 저장 후 재 랜더링 
    function language_render(index, json_parse) {

      // 우선 기존 값들 없애기
      while (now_select.hasChildNodes() )
      {
        now_select.removeChild(now_select.firstChild );       
      }

      for (let key_l in json_parse) {         
          
        // index값 1 증가
        index = index + 1;

        // 구사 가능 언어 담을 div 태그 생성
        const div = document.createElement('div');
        // div의 id에 인덱스값 부여
        div.setAttribute("id", "div_"+index);
        // 배치를 위한 속성 부여
        div.setAttribute("class", "flex justify-between")
        // div에 이름 부여 (삭제 시 이름 가져와서 삭제할 수 있도록)
        div.setAttribute('title', key_l);
                           
        // 텍스트 담을 span 태그 생성
        const span = document.createElement('span');
        // span의 id에 인덱스값 부여
        span.setAttribute("id", "span_"+index);
        // span에 속성 부여
        span.setAttribute("class", "text-sm text-gray-500 my-1");
        // 생성한 span에 구사 가능 언어 및 구사 수준 대입        
        span.innerHTML = key_l+" : "+json_parse[key_l];     
        
        //// 삭제용 버튼 생성
        const delete_btn = document.createElement('a');          
        // 버튼에 id, class, 이름 값 부여
        delete_btn.setAttribute("id", index);
        delete_btn.setAttribute("class", "px-2 my-2 font-semibold bg-gray-500 text-xs text-white hover:bg-gray-700 hover:text-white rounded-full border")
        delete_btn.setAttribute("name", "delete_l");
        
        console.log("name : "+delete_btn.getAttribute("name"));

        delete_btn.innerHTML = "삭제";
        console.log("id : "+delete_btn.id);
        
        // div에 span이랑 a(버튼) 연결
        div.append(span);
        div.append(delete_btn);
        // 새롭게 생성한 div 연결
        now_select.appendChild(div);  
        
        
        // 삭제 버튼 클릭 시 해당 구사 가능 언어 삭제
        delete_btn.addEventListener('click', () => {          

          const id = delete_btn.id;

          console.log("div_"+id);
          // 삭제하려는 div 가져오기            
          const delete_div = document.getElementById("div_"+id);    
          
          const key = delete_div.getAttribute('title');
          
          // 전역으로 선언한 구사가능언어에서 해당 값 제외
          let json_parse = JSON.parse(language_can);

          console.log(key);
          delete json_parse[key];

          // 전역 변수에 다시 string으로 변환해서 대입
          language_can = JSON.stringify(json_parse);

          // 서버에 삭제 요청
          post_edit(tokenValue, "language", language_can);
          
          // 해당 div 삭제
          delete_div.parentNode.removeChild(delete_div);
        });
            
      }
    }

    // 돌아가기 버튼
    function language_return() {

      // 언어 삭제 버튼 안 보이게
      // const delete_l = document.getElementsByName('delete_l');
      // delete_l.style.display = 'block';

      // 리턴 버튼 안 보이게
      const return_btn = document.getElementById('language_return_btn');
      return_btn.style.display = 'none';

      // 수정 이전 화면 보이게 하고 수정 클릭 했을 때 화면 안보이게
      language_not_edit_div.style.display = 'block';
      language_click_edit_div.style.display = 'none';

      // 전역 변수 가져와서 해당 값들 다시 화면에 출력
      const json_parse = JSON.parse(language_can);     
      setLanguage(language, json_parse);
    }


    // 9. 한국어 수준 수정
    // 현재 한국어 수준 가져오기
    let now_korean = document.getElementById('korean');
    // 수준 입력 id 가져오기
    let input_korean = document.getElementById('select_korean');        
    // 생년월일이랑 편집 아이콘 있는 div 가져오기
    let korean_not_edit_div = document.getElementById('koreandiv_not_edit');
    // 편집 아이콘 클릭했을 때 나오는 div 가져오기
    let korean_click_edit_div = document.getElementById('koreandiv_click_edit'); 

    // 한국어 수정 클릭
    function editing_korean() {

      // 한국어 값이 있을 경우에만 값 대입
      if (now_korean.innerHTML != '') {
               
        const korean_string = now_korean.innerHTML;

        input_korean.value = korean_string;            
      }

       // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
       korean_click_edit_div.style.display = 'block';
       // 텍스트랑 편집 아이콘 안보이게 처리
       korean_not_edit_div.style.display = 'none';   
      
    }

    // 한국어 수정 취소
    function edit_cancel_korean() {

      // 편집 아이콘 클릭했을 때 나오는 div 보이게 처리
      korean_click_edit_div.style.display = 'none';
      // 텍스트랑 편집 아이콘 안보이게 처리
      korean_not_edit_div.style.display = 'block'; 
    }

    // 한국어 수정 완료
    function edit_done_korean() {

      // 입력창에서 수정한 성별을 화면에 표시
      now_korean.innerHTML = input_korean.value;

      // 편집 아이콘 클릭했을 때 나오는 div 안 보이게 처리
      korean_click_edit_div.style.display = 'none';
      // 이름이랑 편집 아이콘 다시 보이게 처리
      korean_not_edit_div.style.display = 'block';

      // 서버로 저장 요청
      post_edit(tokenValue, "korean", now_korean.innerHTML);
    }

        
    // 수정 사항 서버에 전달하는 함수 (백엔드 부분 처리될 때까지 보류)
    async function post_edit(token, position, desc) {

      const body = {
        token: token,
        position: position,
        class_description: desc,
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