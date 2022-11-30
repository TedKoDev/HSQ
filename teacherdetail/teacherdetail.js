// 유저 id 받아온 후 로컬 스토리지에서 삭제
const {id} = JSON.parse(localStorage.getItem("user_id"));
localStorage.removeItem("user_id");

let U_id = id;
// console.log(U_id);


// 수업 가능 시간 부분에 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력

// 해당 유저의 utc 가져온후 date에 가져온 utc 적용

get_utc(checkCookie);

async function get_utc(tokenValue) {

    // 로컬 타임존도 보내기
    const date = new Date();    
    const utc = -(date.getTimezoneOffset() / 60);

    const body = {
    
        token: tokenValue,
        utc: utc,
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

        // 현재 시간대 텍스트에 timezone 세팅
        const utc = document.getElementById("utc");
        let utc_string;

        if (utc >= 0) {      
  
          utc_string = "(UTC+"+timezone+":00)";
          
        }
        else {      
          
          utc_string = "(UTC"+timezone+":00)";       
          
        }

        utc.innerHTML = utc_string;
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
getTeacherdatail(checkCookie, U_id); 

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
      
      console.log("user_id : "+U_id);
      console.log("name : "+name);
      console.log("certi : "+certi);
      console.log("language : "+language);
      console.log("intro : "+intro);

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
      setClass(class_list);

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
      language_list.innerHTML = ['<span class = "mr-2 text-sm">'+key_l+' - '+json_parse[key_l]+'</span>'].join("");
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

// 수업 목록 출력

function setClass(class_list) {

  // 수업 개수 만큼 반복문 돌린 뒤 태그 생성해서 출력
  let class_items = document.getElementById("class_list");
  for (let i = 0; i < class_list.length; i++) {

    // 대입할 데이터 파싱
    const class_id = class_list[i].class_id;
    const clname = class_list[i].clname;
    const cldesc = class_list[i].cldisc;
    const clpeoeple = class_list[i].clpeople;
    const cltype = class_list[i].cltype;
    const tp = class_list[i].tp;   
    const cllevel = class_list[i].cllevel;
    
    // console.log("tp0 : "+tp[0].Price);
    // console.log("tp1 : "+tp[1].Price);

    console.log("cllevel : "+cllevel);

    // 가격 파싱
    const price_30 = tp[0].Price;
    const price_60 = tp[1].Price;
    

    // 수업 뷰 출력을 위한 태그 생성
    const class_div = document.createElement('div');
    // 해당 div의 id로 클래스의 id 매칭하고 스타일 부여
    class_div.setAttribute("id", "class_"+class_id);
    class_div.setAttribute("class", "ml-4 mr-4 bg-gray-200 hover:bg-gray-300 justify-between rounded-lg my-2");

    const div = document.createElement('div');    
    div.setAttribute("id", "click_"+class_id);
    // console.log("pass");
    div.innerHTML = [      
        '<div class = "flex justify-between">',
          '<div class = "flex flex-col px-4">',
            '<div class = "text-base font-normal mb-3 mt-1">'+clname+'</div>',          
            '<div id = type_'+class_id+' class = "flex mb-2 text-sm">',          
                        
            '</div>',
          '</div>',   
          '<div class = "flex flex-col my-auto px-4">',
            '<div>30분 : <a>'+price_30+' $</a></div>',
            '<div>60분 : <a>'+price_60+' $</a></div>',
          '</div>',
        '</div>'      
    ].join("");
   
    class_div.appendChild(div);
    class_items.appendChild(class_div);

    // 수업레벨, 수업 유형 덧붙이기 위해 div id 가져오기
    const type_div = document.getElementById("type_"+class_id);

    // 수업 레벨 가져온 다음 배열로 바꾸어서 대입
    const level_array = cllevel.split("_");
    const level_string = level_array[0]+" - "+level_array[1];
    const level_a = document.createElement("a");
    level_a.setAttribute("class", "text-gray-700 mr-2")
    level_a.innerHTML = level_string;
    type_div.appendChild(level_a);

     // 수업 유형 배열로 전환
     const type_array = cltype.split(",");

     // 배열 개수만큼 반복문 돌려서 태그 생성 후 대입
     for (let j = 0; j < type_array.length; j++) {
       
      // console.log(type_array[j]);
      const type = document.createElement("a");
      type.setAttribute("class", "bg-gray-500 text-gray-800 mr-2 rounded-lg px-2")
      type.innerHTML = type_array[j];

      
      // console.log(type_div.value);
      type_div.appendChild(type);
     }
    
    // 클릭시 모달창 띄워지게
    click_class(class_id, clname, cldesc, cltype, tp, cllevel);

  }
}

// 클릭 시 모달창 띄우고 값 대입
function click_class(class_id, clname, cldesc, cltype, tp, cllevel) {

  const class_click = document.getElementById("click_"+class_id);    
    const body = document.getElementsByTagName('body')[0];
    const overlay = document.querySelector('#overlay')

    const show_modal = () => {
      
      overlay
          .classList
          .toggle('hidden')
      overlay
          .classList
          .toggle('flex')

      body
          .classList
          .add('scrollLock'); 
          
      // 값 대입
      setModal(class_id, clname, cldesc, cltype, tp, cllevel)
    }

    class_click.addEventListener("click", show_modal)
}

function setModal(class_id, clname, cldesc, cltype, tp, cllevel) {

  const clname_m = document.getElementById("clname_m");
  const cllevel_m = document.getElementById("cllevel_m");
  const cltype_m= document.getElementById("cltype_m");
  const cldesc_m = document.getElementById("cldesc_m");
  const clprice30_m = document.getElementById("clprice30_m");
  const clprice60_m = document.getElementById("clprice60_m");

  // 이름 설명 대입
  clname_m.innerHTML = clname;
  cldesc_m.innerHTML = cldesc;

  // 수업 레벨 대입
  // 수업 레벨 가져온 다음 배열로 바꾸어서 대입
  const level_array = cllevel.split("_");
  const level_string = level_array[0]+" - "+level_array[1];
  const level_a = document.createElement("a");
  level_a.setAttribute("class", "text-gray-700 mr-2")
  level_a.innerHTML = level_string;
  cllevel_m.appendChild(level_a);

  // 가격 대입
  clprice30_m.innerHTML = "30분 : "+tp[0].Price+" $";
  clprice60_m.innerHTML = "60분 : "+tp[1].Price+" $";

  // 수업 유형 대입
  // 수업 유형 배열로 전환
  const type_array = cltype.split(",");

  // 배열 개수만큼 반복문 돌려서 태그 생성 후 대입
  for (let j = 0; j < type_array.length; j++) {
    
   // console.log(type_array[j]);
   const type = document.createElement("a");
   type.setAttribute("class", "mx-2 border-2 border-gray-700 rounded px-1")
   type.innerHTML = type_array[j];
   
   // console.log(type_div.value);
   cltype_m.appendChild(type);
  }

}

// 자기소개, 강의 스타일 클릭했을 때 해당하는 div 보이게 처리
function show_intro(type) {

  const intro_menu = document.getElementById("intro_menu");
  const t_intro_menu = document.getElementById("t_intro_menu");
  const intro_div = document.getElementById("intro_div");
  const t_intro_div = document.getElementById("t_intro_div");

  // 자기 소개 클릭할 경우
  if (type == 'intro_menu') {

    intro_menu.setAttribute("class", "px-3 font-semibold border-b-2");
    t_intro_menu.setAttribute("class", "px-3 font-normal border-0");
    intro_div.style.display = 'block';
    t_intro_div.style.display = 'none';

  }
  // 강의 스타일 클릭한 경우
  else {
    intro_menu.setAttribute("class", "px-3 font-normal border-0");
    t_intro_menu.setAttribute("class", "px-3 font-semibold border-b-2");
    intro_div.style.display = 'none';
    t_intro_div.style.display = 'block';
  }  
}

// 수업 클릭했을 때 모달창 띄우기
function show_modal(class_id) {

  console.log("pass");

  const body = document.getElementsByTagName('body')[0];

  const overlay = document.querySelector('#overlay')
  const edit_btn = document.getElementById('edit_schedule_btn')

  overlay.classList.toggle('hidden');
  overlay.classList.toggle('flex');
  body.classList.add('scrollLock');
}

// 모달창 취소, 예약 클릭 했을 떄
window.addEventListener('DOMContentLoaded', () => {

  const body = document.getElementsByTagName('body')[0];

  const overlay = document.querySelector('#overlay')  
  const closeBtn = document.querySelector('#close-modal')
  

  // 모달창 취소 클릭
  const cancel_modal = () => {                           

      overlay
          .classList
          .toggle('hidden')
      overlay
          .classList
          .toggle('flex')

      body
          .classList
          .remove('scrollLock');    
          
      // 일정 다시 세팅
      // setschedule("_l");

  }              
  closeBtn.addEventListener('click', cancel_modal)  
})
