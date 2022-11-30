// 유저 id 받아온 후 로컬 스토리지에서 삭제
// const {id} = JSON.parse(localStorage.getItem("user_id"));
// localStorage.removeItem("user_id");

// let U_id = id;
// console.log(U_id);


// 수업 가능 시간 부분에 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력

// 해당 유저의 utc 가져온후 date에 가져온 utc 적용

get_utc(checkCookie);

async function get_utc(tokenValue) {

    const body = {
    
        token: tokenValue
      };
    
      const res = await fetch('../util/utc.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
      });  

      const response = await res.json();  
      const success = response.success;
      const timezone = response.timezone;

      if (success == "yes") {

        getDate("header_s", timezone);
      }
      else {
        console.log("타임존 못불러옴")
      }
}

// getDate("header_s", timezone);

function getDate(header_date, timezone) {

    let header_s = document.getElementById(header_date);

    // 세팅하기 전에 일단 초기화
    while(header_s.firstChild)  {
        header_s.removeChild(header_s.firstChild);
      }

    let now = new Date();
    
    const string_to_int = parseInt(timezone);
    now.setHours(now.getHours() + string_to_int);
    
    let time = now.getTime();
    let todayDate = now.getDate();

    let week = new Array('일', '월', '화', '수', '목', '금', '토');

    time = time - (1000 * 60 * 60 * 24)
    for (let i = 0; i < 8; i++) {

        if (i == 0) {

            let utc_show = document.createElement("div");
            utc_show.innerHTML = [
                '<div class = "flex flex-col w-20">', '<div class = "mx-auto"></div>',            
                '</div>'
            ].join("");

            header_s.appendChild(utc_show);

        } else {

            time = time + (1000 * 60 * 60 * 24);

            let new_Date = new Date(time);

            let date = new_Date.getDate();

            let day_array = new_Date.getDay();
            let day = week[day_array];
            // console.log(date);
            // console.log(day);

            let date_day = document.createElement("div");
            date_day.innerHTML = [
                '<div class = "flex flex-col w-20">', '<div class = "mx-auto">' + day +
                        '</div>',
                '<div class = "mx-auto">' + date + '</div>',
                '</div>'
            ].join("");

            header_s.appendChild(date_day);        
        }
    }
}

// 클릭한 유저 ID랑 유저의 토큰 보내서 강사 상세 정보 가져오기
getTeacherdatail(checkCookie, 32); // 일단 강사 id는 32로 하드코딩

async function getTeacherdatail(tokenValue, usid) {

    console.log("checkCookie : "+tokenValue);

    const body = {
    
        token: tokenValue,
        usid: usid,
      };
    
      const res = await fetch('./teacherdetailProcess.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
      });  
      
      const response = await res.json(); 
      
      const result = response.result[0];
      console.log(response);      

      console.log(result);
      const name = result.U_Name;
      const certi = result.U_T_Special;
      const language = result.U_D_Language;
      const intro = result.U_D_Intro;
      const t_intro = result.U_T_Intro;
      const p_img = result.U_D_Img;
      const country = result.U_D_Country;
      const residence = result.U_D_Residence;
      const schedule = result.Schedule;
      const class_list = result.class;       
      

      // 바로 대입할 수 있는 것들 우선 대입 
      // 바로 대입할 수 있는 요소들의 id값 가져오기
      const user_name = document.getElementById("name");
      const user_p_img = document.getElementById("profile_image");
      const user_certi = document.getElementById("certi");
      const user_language = document.getElementById("language");
      const user_intro = document.getElementById("intro");
      const user_t_intro = document.getElementById("t_intro");
      const user_country = document.getElementById("country");
      const user_residence = document.getElementById("residence");

      // 기본 정보 출력
      user_name.innerHTML = name;    
      setCerti(user_certi, certi);
      setInfo(user_p_img, p_img, "image");      
      setInfo(user_country, country, " 출신, ");
      setInfo(user_residence, residence, " 거주");
      setInfo(user_intro, intro, "");
      setInfo(user_t_intro, t_intro, "");         
      setLanguage(user_language, language);

      // 수업 가능 시간 출력
      setschedule(schedule, "_l");

      // 수업 목록 출력

}

// 값이 있을 경우에만 브라우저에 출력
function setInfo(key, value, text) {

  if ((value != 'default') && (value != null)) {        
    
    // 프로필 이미지일 경우
    if (text == 'image') {
      
      key.src = "../editprofile/image/"+value;
    }

    else {
      key.innerText = value+text;
    }     
            
  }
  else {
    key.innerText = "";
  }
}

function setCerti(key, value) {

  if (value == 'default') {

    key.innerText = '커뮤니티 튜터';
  }
  else {
    key.innerText = '전문 강사';
  }
}

// 구사 가능 언어 출력 용 함수
function setLanguage(key, value) {
    
  
  // 값이 있을 경우에만 등록한 구사 가능 언어 수만큼 화면에 출력
  if ((value != 'default') && (value != null)) {  
    
    let json_parse = JSON.parse(value);
    // // 처음에는 key 값 초기화 (리턴 클릭했을 경우 기존 값들 없애줘야 함)
    // while (key.hasChildNodes())
    // {
    //   key.removeChild(key.firstChild);       
    // }
    
    for (let key_l in json_parse) {

      let language_list = document.createElement('span');          
      language_list.innerHTML = ['<span class = "mr-2">'+key_l+' - '+json_parse[key_l]+'</span>'].join("");
      key.appendChild(language_list);

      // console.log(key_l, value[key_l]);          
    }                 
                         
  }       
  else {
    key.innerText = "";
  }
}

// 일정 등록에 세팅하는 함수
async function setschedule(schedule_string, type) {    
       
  // 값이 있을 경우에만 추출해서 대입  
    
    let test_array = schedule_string.split('_');

    // 디폴트로 일단 회색으로 칠해놓기
    let default_label = document.getElementsByName("schedule_label");
    for (label of default_label) {
        label.style.backgroundColor = '#9CA3AF';
    }    

    // 일정 체크박스 개수만큼 반복문 돌리기
    for (let i = 1; i <= 336; i++ ) {

        // 변환한 array의 개수만큼 반복문 돌리기
        for (let j = 0; j < test_array.length; j++) {
            
            if (i == test_array[j]) {

                let label = document.getElementById(i + "_l");
                // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
                let input = document.getElementById(i+ type);

                input.checked = true;
                label.style.backgroundColor = 'blue';
            }               
        }
    }
  
}