// const dayjs = require("dayjs");

// 유저 id 받아온 후 로컬 스토리지에서 삭제
const {id} = JSON.parse(localStorage.getItem("user_id"));
let U_id = id;

console.log(U_id);
// localStorage.removeItem("user_id");

// 수업 예약할 때 강사 상세인지, 수업 상세인지 표시 (나중에 수업 시간 모달 띄울 때 분기처리 하기 위해)
let checkStartpoint = "teacher";

// 해당 유저의 utc 가져온후 date에 가져온 utc 적용
// 쿠키 값 가져오기   
let checkCookie = getCookie("user_info");
get_utc(checkCookie);

// 전역으로 사용할 timezone 선언
let timezone;

// 서버에서 요청받은 일정이 담긴 string값 담을 변수 선언
let schedule_string;
// 서버에서 받은 일정의 상태 (승인대기/미완료/완료/취소된 수업)
let schedule_string_status;

// 모달창에서 수정할 때 일정 담긴 string을 배열로 변환하는 변수 선언
let array_for_edit = new Array();

// 타임스탬프 담을 전역 변수 선언
let time;

// 이전 날짜로 이동하는 버튼 초기화(이번주에서는 이전 버튼 비활성화 되는 것 처리하기 위해)
let beforeDate_btn = document.getElementById("beforeDate_btn");

async function get_utc(tokenValue) {
   

    const body = {
    
        token: tokenValue,
        
      };
    
      const res = await fetch('../utils/utc.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
      });  

      const response = await res.json();  
      const success = response.success;
      const timezone_s = response.user_timezone;      

      timezone = timezone_s;
     
      console.log("success : "+success);
      if (success == "yes") {

        getDate("header_s", timezone, "");

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
        
                
        // checkbox값 부여된 이후에 저장된 일정 세팅
        setschedule("_l", "");

        // 이번주일 경우 이전 버튼 비활성화 되게 처리
        checkBeforebtn(beforeDate_btn, timezone);
      }
      else {
        console.log("타임존 못불러옴")
      }
}

function getDate(header_date, timezone, for_modal) {

  // 우선 전역 time 초기화
  time = 0;

  let header_s = document.getElementById(header_date);

  // 세팅하기 전에 일단 초기화
  while(header_s.firstChild)  {
      header_s.removeChild(header_s.firstChild);
    }

  // 현재 날짜 객체 생성
  let now = new Date();
  
  // 현재 날짜의 시/분/초 초기화
  now.setHours(0);
  now.setMinutes(0);
  now.setSeconds(0);
  
  // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
  const offset = (now.getTimezoneOffset()/60);  
  now.setHours(now.getHours() + offset); 
      
  // 날짜 표시하기 전에 받아온 타임존 적용 
  const string_to_int = parseInt(timezone);
  now.setHours(now.getHours() + string_to_int);
    
  // 현재 타임스탬프 전역 변수에 대입
  time = now.getTime();  
  
  time = time - (1000 * 60 * 60 * 24) // 반복문 시작부터 time 더해지므로 디폴트 값으로 미리 한 번 빼놓기  
  
  // 시간대에 맞게 날짜 세팅
  setDate_Value(header_s, for_modal);
}
// getDate("header_s", timezone);

// 일정 등록에 세팅하는 함수
async function setschedule(type, for_modal) {    

  // 로컬 시간대 추출
  const date = new Date();
  const utc = -(date.getTimezoneOffset() / 60);

  console.log("t_id : "+U_id);

  // 토큰, 로컬 시간대, 강사id 전송해서 해당 강사의 스케줄 받아오기
  const body = {

      token: checkCookie,
      user_timezone: utc,
      user_id_teacher: U_id
  };
  const res = await fetch('../restapi/schedule.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(body)
  });

  const response = await res.json(); 
  const check = response.success; 

  console.log(response);
  schedule_string = response.teacher_schedule_list;
  schedule_string_status = response.teacher_schedule_list_status;  

  // 값이 있을 경우에만 추출해서 대입
  if (check == "yes") {     

      // 서버에서 받아온 string 배열로 변환
      const scheduleList = schedule_string.split('_');
      // 서버에서 받아온 일정의 상태 배열로 변환
      const statusList = schedule_string_status.split('_');
      

      // 현재 모달창에서 체크하고 있는 배열 가져오기
      let check_array = new Array();
      check_array = array_for_edit;

      // 디폴트로 일단 회색으로 칠해놓기
      const default_label = document.getElementsByName("schedule_label");
      for (label of default_label) {
          label.style.backgroundColor = '#9CA3AF';
      }
      

      // 일정 체크박스 개수만큼 반복문 돌리기
      for (let i = 1; i <= 336; i++ ) {

          // 체크박스의 value값 가져오기
          let input_i = document.getElementById(i+for_modal).value;   
          let label = document.getElementById(i + type);                 

          // 모달창 아닐 때만 서버에서 받아온 값 뿌려주기
          // if (for_modal == "") {
              // 서버에서 받아온 값 뿌려주기
              for (let j = 0; j < scheduleList.length; j++) {
                                  
                  // 체크박스의 값과 서버에서 받아온 array값 중 일치하는 것이 있을 경우 색깔 칠하기
                  if (input_i == scheduleList[j]) {       
                                                      
                      
                      label.style.backgroundColor = '#2563EB';

                      // 예약 불가능한 상태일 경우 색깔 다른색으로 칠하기
                      // 9 : 예약 가능한 상태. 2 : 수업 취소된 상태 -> 9나 2가 아닐 경우 수업 신청 못함
                      if (!(statusList[j] == 9 || statusList[j] == 2)) {
                                                   
                        console.log("pass");
                        label.style.backgroundColor = '#6B7280';                   
                      }
                  }               
              }
              // 현재 시간 이전 날짜일 경우에는 디폴트 색인 회색으로 두기
              if(checkNow_forSchedule(input_i)) {
                
                label.style.backgroundColor = '#9CA3AF';
              }              
              
          // }
          // 모달창이면 서버에서 받아온거 바로 뿌려주지 말고 모달창 켰을 때 담은 배열에 있는값들 뿌려주기
          // else {
          //   // 현재 체크하고 있는 array 개수만큼 반복문 돌려서 체크 (현재 편집중인 사항 표시하기 위해)
          //   for (let z = 0; z < check_array.length; z++) {
                                            
          //       if (input_i == check_array[z]) {
                    
          //           // console.log("input_i : "+input_i);
          //           // console.log("test_array[j] : "+test_array[j]);
                    
          //           let label = document.getElementById(i + type);
          //           // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
          //           let input = document.getElementById(i+"_m");

          //           input.checked = true;
          //           label.style.backgroundColor = '#2563EB';
          //       }
                            
          //   }
          // }            
      }
  }
}

// 이전,다음 버튼 누를 때 날짜 세팅하고 check value 재 대입 해주는 함수
function setDate_Value(header_s, for_modal) {

  let week = new Array('일', '월', '화', '수', '목', '금', '토');

          
      let num = 0; // 날짜에 따라 value값 대입해주기 위한 임의의 num
  
      for (let i = 0; i < 8; i++) {
  
          if (i == 0) {
  
              let utc_show = document.createElement("div");
              utc_show.innerHTML = [
                  '<div class = "flex flex-col w-20">', 
                      '<div class = "mx-auto"></div>',            
                  '</div>'
              ].join("");
  
              header_s.appendChild(utc_show);
  
          } else {
  
              time = time + (1000 * 60 * 60 * 24);
  
              let new_Date = new Date(time);
  
              let date = new_Date.getDate();
              let month = new_Date.getMonth()+1;

              let day_array = new_Date.getDay();
              let day = week[day_array];            
  
              let date_day = document.createElement("div");
              date_day.innerHTML = [
                  '<div class = "flex flex-col w-20">', '<div class = "mx-auto">' + day,
                          '</div>',
                  '<div class = "mx-auto">' + month+"/"+date + '</div>',
                  '</div>'
              ].join("");
  
              header_s.appendChild(date_day);     
                  
  
              // 336개의 체크박스 value에 년-월-일-시간을 대입
              // 우선 해당 열의 년/월/일 추출
              const year_s = new_Date.getFullYear();
              const month_s = new_Date.getMonth()+1;
              const day_s = new_Date.getDate();
              
              const test_day = year_s+"-"+month_s+"-"+day_s;
            
              // day.js 써서 타임스탬프로 변환
              let test_dayjs = dayjs(test_day);
              test_dayjs.format();
                 
              
              // 00:00 ~ 24:00에 해당하는 48개 체크박스에 해당 타임스탬프+시간대의 조합으로 value값 부여
              for (let j = 1; j <= 48; j++) {
                  
                  // 반복문 거칠때마다 우선 위에서 선언한 num 1씩 더하기
                  num = num + 1;
                  // 해당 체크박스의 id 가져오기 (value 세팅해주기 위해)
                  const checkbox = document.getElementById(num+for_modal);
                  // 체크박스 위치에 따라 시간 더해주기
                  let add_dayjs = test_dayjs.set("m", 30*j);
                  // 체크박스의 value에 더한 값의 타임스탬프를 넣어주기
                  checkbox.setAttribute("value", add_dayjs.valueOf());
                                                        
                  if (for_modal == "_m") {

                      // console.log(checkbox.value);                        
                  }
              }
          }
  
      }        

      // 모든 세팅 끝나면 타임 다시 일주일 전으로 되돌리기
      time = time - 7*(1000 * 60 * 60 * 24);
}

// 이전,다음 버튼 클릭시 그 주에 해당하는 날짜 변경되고 checkbox의 value값도 그에 따라 변경
function change_schedule(type, id, l_m, for_modal) {

  let header_s = document.getElementById(id);

  // 세팅하기 전에 일단 초기화
  while(header_s.firstChild)  {
      header_s.removeChild(header_s.firstChild);
  }     

  // 이전 버튼 클릭할 경우
  if (type == 'before') {     
     
      // time 스탬프 값 일주일 빼놓기 
      time = time - (7*(1000 * 60 * 60 * 24));      

      setDate_Value(header_s, for_modal);

  }
  // 다음 버튼 클릭할 경우
  else {      
      
      // time 스탬프 값 일주일 더해놓기 
      time = time + (7*(1000 * 60 * 60 * 24));
            
      setDate_Value(header_s, for_modal);
  }

  // checkbox값 부여된 이후에 저장된 일정 세팅
  setschedule(l_m, for_modal);
  
  // 이번주일 경우 이전 버튼 비활성화 되게 처리
  checkBeforebtn(beforeDate_btn, timezone);
}


// 현재 시각 이전 날짜는 수업 예약 못하게 처리
function checkNow_forSchedule(value) {

    // 현재 날짜 객체 생성
    const now = new Date();
    
    // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
    const offset = (now.getTimezoneOffset() / 60);
    now.setHours(now.getHours() + offset);    
  
    // 날짜 표시하기 전에 받아온 타임존 적용
    const string_to_int = parseInt(timezone);
    
    now.setHours(now.getHours() + string_to_int);
    
    const s_to_i_value = parseInt(value);
   
    // 현재시간이 체크박스 시간보다 클 경우 true로 설정
    if (dayjs(now.getTime()).format('YYYY/MM/DD : HH:mm') >= dayjs(s_to_i_value).format('YYYY/MM/DD : HH:mm')) {

      return true;
    }
    else {
      return false;
    }
}

// 클릭한 유저 ID랑 유저의 토큰 보내서 강사 상세 정보 가져오기
getTeacherdatail(checkCookie, U_id); 

async function getTeacherdatail(tokenValue, usid) {

    // console.log("checkCookie : "+tokenValue);

     // 로컬 타임존도 보내기
     const date = new Date();    
     const utc = -(date.getTimezoneOffset() / 60);
   
    const body = {
    
        token: tokenValue,
        user_id: usid,
        user_timezone: utc,
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

      // console.log(result);
      const name = result.user_name;
      const certi = result.user_Special;
      const language = result.user_language;
      const intro = result.user_intro;
      const t_intro = result.teacher_intro;
      const p_img = result.user_img;
      const country = result.user_country;
      const residence = result.user_residence;
      // const schedule = result.schedule_list;
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
      // setschedule(schedule, "_l");

      // 수업 목록 출력
      setClass(class_list);

}

// 값이 있을 경우에만 브라우저에 출력
function setInfo(key, value, text) {

  if ((value != 'default') && (value != null)) {        
    
    // 프로필 이미지일 경우
    if (text == 'image') {
      
      // key.src = "../editprofile/image/"+value;
      key.src = s3_url+"Profile_Image/"+value;
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

// 수업 목록 출력

function setClass(class_list) {

  // 수업 개수 만큼 반복문 돌린 뒤 태그 생성해서 출력
  let class_items = document.getElementById("class_list");
  for (let i = 0; i < class_list.length; i++) {

    // 대입할 데이터 파싱
    const class_id = class_list[i].class_id;
    const clname = class_list[i].class_name;
    const cldesc = class_list[i].class_description;
    const clpeoeple = class_list[i].class_people;
    const cltype = class_list[i].class_type;
    const tp = class_list[i].tp;   
    const cllevel = class_list[i].class_level;  

    // 가격 파싱
    const price_30 = tp[0].class_price;
    const price_60 = tp[1].class_price;
    

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

  // 수업레벨, 수업 유형 일단 자식 요소 삭제해서 초기화
  while(cllevel_m.firstChild)  {
    cllevel_m.removeChild(cllevel_m.firstChild);
  }
  while(cltype_m.firstChild)  {
    cltype_m.removeChild(cltype_m.firstChild);
  }

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
const intro_menu = document.getElementById("intro_menu");
const t_intro_menu = document.getElementById("t_intro_menu");
const intro_div = document.getElementById("intro_div");
const t_intro_div = document.getElementById("t_intro_div");

function show_intro(type) {  

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

 // 이번주에서 이전 날짜 버튼 클릭할 수 없게 처리
 function checkBeforebtn(beforeDate_btn, timezone) {

  // 현재 날짜 객체 생성
  const now = new Date();

  // 현재 날짜의 시/분/초 초기화
  now.setHours(0);
  now.setMinutes(0); 
  now.setSeconds(0);
 
  // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
  const offset = (now.getTimezoneOffset() / 60);
  now.setHours(now.getHours() + offset);

  // 날짜 표시하기 전에 받아온 타임존 적용
  const string_to_int = parseInt(timezone);
  now.setHours(now.getHours() + string_to_int);

  const checkTime = now.getTime();
  const time_sm_check = time + (1000 * 60 * 60 * 24); 
  
  // 가공한 날짜가 전역 time_sm과 같을 경우 이전 버튼 비활성화 
  if (dayjs(checkTime).format('YYYY/MM/DD') == dayjs(time_sm_check).format('YYYY/MM/DD')) {
      
      beforeDate_btn.setAttribute("class", "disabled: border-2 border-gray-200 bg-gray-200 text-gray-50 px-1 py-1 rounded ml-1 mr-1");
  }
  // 다를 경우 이전 버튼 활성화
  else {

      beforeDate_btn.setAttribute("class", "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1");
  }

}

// 모달창 관련 코드
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

// 예약하기 버튼 누를 때 모달창 생성
// 모달 띄우는 코드
const classlistModal = document.querySelector('.reserve-modal-class');
const body = document.getElementsByTagName('body')[0];
const showReserve = document.querySelector('.show-reserve');
const closeModal = document.querySelectorAll('.close-modal');

// 예약하기 누르면 수업 목록 모달창부터 
showReserve.addEventListener('click', function() {

    // 로그인 상태일때만 모달창 띄우게
    if (checkCookie == "") {

    alert("로그인이 필요합니다.");
    location.assign("../login/login.php"); 
    }
    else {
        classlistModal.classList.remove('hidden');
        body.classList.add('scrollLock');

        // 수업 목록 모달창에 해당 강사의 수업 목록 표시
        getclassList_cm(U_id);
        
        // 전역으로 선언한 스케줄 array 초기화
        scheduleReserve_array_sm = [];
    }    
});

// X버튼 누를 시 모달창 사라지고 모달창에서 설정한 값들 초기화
// 어떤 모달창의 X값을 누르더라도 반영이 되야하므로 반복문으로 처리
for (const close of closeModal) {

  close.addEventListener('click', function() {

    // 모든 모달값 가져오기
    const classlistModal = document.querySelector('.reserve-modal-class');
    const classtimeModal = document.querySelector('.reserve-modal-time');
    const scheduleModal = document.querySelector('.reserve-modal-schedule');
    const cmtoolModal = document.querySelector('.reserve-modal-cmtool');

    // 모달 없어지게 처리
    classlistModal.classList.add('hidden');    
    classtimeModal.classList.add('hidden');
    scheduleModal.classList.add('hidden');
    cmtoolModal.classList.add('hidden');

    // scrollloack 해지
    body.classList.remove('scrollLock');

      // 수업 목록 모달창에서 설정한 값들 다시 초기화
      initClassModal();
      // 수업 시간 모달창에서 설정한 값들 다시 초기화
      initTimeModal();
      // 수업 일정 모달창에서 설정한 값들 다시 초기화
      initScheduleModal();
      // 커뮤니케이션 도구 모달창에서 설정한 값들 다시 초기화
      initCmtoolModal();
  })
}




// function login_check() {

//   console.log("click");

//   // 토큰 값 있을 때만 예약창 뜨도록
//   if (checkCookie == "") {

//     alert("로그인이 필요합니다.");
//     location.assign("../login/login.php"); 
//   }
//   else {    
//     console.log("click2");             
//     // const overlay_reserve = document.querySelector('.overlay_reserve') 
    
//   }
// }


// (옛날 코드인데 혹시 몰라서 남겨 놓은 것들)
// 일정 등록에 세팅하는 함수 
// async function setschedule(schedule_string, type) {    
       
//   // 값이 있을 경우에만 추출해서 대입  
    
//     let test_array = schedule_string.split('_');

//     // 디폴트로 일단 회색으로 칠해놓기
//     let default_label = document.getElementsByName("schedule_label");
//     for (label of default_label) {
//         label.style.backgroundColor = '#9CA3AF';
//     }    

//     // 일정 체크박스 개수만큼 반복문 돌리기
//     for (let i = 1; i <= 336; i++ ) {

//         // 변환한 array의 개수만큼 반복문 돌리기
//         for (let j = 0; j < test_array.length; j++) {
            
//             if (i == test_array[j]) {

//                 let label = document.getElementById(i + "_l");
//                 // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
//                 let input = document.getElementById(i+ type);

//                 input.checked = true;
//                 label.style.backgroundColor = 'blue';
//             }               
//         }
//     }  
// }

// 날짜 세팅 
// function getDate(header_date, timezone) {

//     let header_s = document.getElementById(header_date);

//     // 세팅하기 전에 일단 초기화
//     while(header_s.firstChild)  {
//         header_s.removeChild(header_s.firstChild);
//       }

//     let now = new Date();
    
//     const string_to_int = parseInt(timezone);
//     now.setHours(now.getHours() + string_to_int);
    
//     let time = now.getTime();
//     let todayDate = now.getDate();

//     let week = new Array('일', '월', '화', '수', '목', '금', '토');

//     time = time - (1000 * 60 * 60 * 24)
//     for (let i = 0; i < 8; i++) {

//         if (i == 0) {

//             let utc_show = document.createElement("div");
//             utc_show.innerHTML = [
//                 '<div class = "flex flex-col w-20">', '<div class = "mx-auto"></div>',            
//                 '</div>'
//             ].join("");

//             header_s.appendChild(utc_show);

//         } else {

//             time = time + (1000 * 60 * 60 * 24);

//             let new_Date = new Date(time);

//             let date = new_Date.getDate();

//             let day_array = new_Date.getDay();
//             let day = week[day_array];
//             // console.log(date);
//             // console.log(day);

//             let date_day = document.createElement("div");
//             date_day.innerHTML = [
//                 '<div class = "flex flex-col w-20">', '<div class = "mx-auto">' + day +
//                         '</div>',
//                 '<div class = "mx-auto">' + date + '</div>',
//                 '</div>'
//             ].join("");

//             header_s.appendChild(date_day);        
//         }
//     }
// }

// 일정 등록에 세팅하는 함수
// async function setschedule(type, for_modal) {    

//   console.log("pass2");

//   const body = {

//       token: checkCookie,       
  
//       };
//   const res = await fetch('../manageschedule/managescheduleProcess.php', {
//   method: 'POST',
//   headers: {
//       'Content-Type': 'application/json;charset=utf-8'
//   },
//   body: JSON.stringify(body)
//   });
  
//   const response = await res.json();   
//   const check = response.success; 
//   schedule_string = response.schedule;  
  
//   console.log('schedule_string : '+schedule_string);

//   // 값이 있을 경우에만 추출해서 대입
//   if (check == "yes") {

//       console.log("yes");
//       // let test_string = "54_62_88";

//       let test_array = schedule_string.split('_');

//       // 디폴트로 일단 회색으로 칠해놓기
//       let default_label = document.getElementsByName("schedule_label");
//       for (label of default_label) {
//           label.style.backgroundColor = '#9CA3AF';
//       }
      

//       // 일정 체크박스 개수만큼 반복문 돌리기
//       for (let i = 1; i <= 336; i++ ) {

//           // 체크박스의 value값 가져오기
//           let input_i = document.getElementById(i+for_modal).value;

//           // console.log(input_i);
//           // 변환한 array의 개수만큼 반복문 돌리기
//           for (let j = 0; j < test_array.length; j++) {
                              
//               if (input_i == test_array[j]) {
                  
//                   // console.log("input_i : "+input_i);
//                   // console.log("test_array[j] : "+test_array[j]);
                  
//                   let label = document.getElementById(i + type);
//                   // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
//                   // 지금 모달창 관련해서 주석처리 해놓은 부분은 나중에 수업 등록하고 일정 선택할 때 필요함
//                   // let input = document.getElementById(i+"_m");

//                   // input.checked = true;
//                   label.style.backgroundColor = 'blue';
//               }               
//           }
//       }
//   }
// }