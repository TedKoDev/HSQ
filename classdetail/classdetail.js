// 수업 id, 강사 id 받아오기
const {class_id, teacher_id} = JSON.parse(localStorage.getItem("c_and_t_id"));

// 수업 id, 강사 id 선언
let C_id = class_id;
let U_id = teacher_id;

// 최종 예약 때 보낼 용도의 수업 id, 수업이름 선언
let clId_final = class_id;
let clName_final;

// 수업 예약할 때 강사 상세인지, 수업 상세인지 표시 (나중에 수업 시간 모달 띄울 때 분기처리 하기 위해)
let checkStartpoint = "class";

// 수업 정보, 강사 정보 가져와서 화면에 표시
getClassinfo(C_id);
getTeacherinfo(U_id);

// 일정 정보 가져와서 화면에 표시 (강사id, 쿠키값(있을 경우) 전송)

// getDate : utc 기준 날짜 세팅
// setDate_Value : 날짜 기준으로 checkbox에 value 세팅
// setscheudle : 일정표에 색깔 표시
// change_schedule : 이전/다음 버튼 누를 때 날짜 바뀌고 그에 해당하는 일정 표시


// 일정 세팅에 필요한 전역 변수들 
// timezone 전역 변수 선언
let timezone;
// 서버에서 요청받은 일정이 담긴 string값 담을 변수 선언
let schedule_string;
// 모달창에서 수업 신청할 때 일정 담긴 string을 배열로 변환하는 변수 선언
let array_for_edit = new Array();
// 타임스탬프 담을 전역 변수 선언
let time;

// 수업 이름 전역으로 선언 (모달창 하단에 표기할 용도)
let clname_g;

// 이전 날짜로 이동하는 버튼 초기화(이번주에서는 이전 버튼 비활성화 되는 것 처리하기 위해)
let beforeDate_btn = document.getElementById("beforeDate_btn");

// 모달창 하단에 수업 이름 표시하는 뷰 초기화
let cl_name_b = document.querySelectorAll(".cl-name");

// 일정 표시
getSchedule(U_id, checkCookie);

async function getSchedule(teacher_id, tokenvalue) {

  // 로컬 타임존도 보내기
  const date = new Date();    
  const utc = -(date.getTimezoneOffset() / 60);  

  const body = {
    
    tusid : teacher_id,
    token : tokenvalue,
    utc : utc,    
  };
 
  const res = await fetch('../restapi/schedule.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;'
    },
    body: JSON.stringify(body)
  });  

  const response = await res.json(); 
  
  console.log(response);

  if (response.success == "yes") {

    // 전역으로 선언한 일정에 가져온 값 대입
    schedule_string = response.schedule;
    // 전역으로 선언한 timezone 값 대입
    timezone = response.timezone;

    console.log("STRING : "+schedule_string);

    // 세팅
    // header_s : (모달창이 아닌)웹페이지에 있는 날짜
    // timezone : 받아온 시간대 or 로컬 시간대
    // "" : (모달창이 아닌) 웹페이지의 checkbox id 표시용도

    // 시간대에 맞게 날짜 세팅
    getDate("header_s", timezone) 

    // 날짜에 맞게 checkbox에 value 세팅
    setDate_Value("header_s", "");

    // checkbox에 일정 표시
    // "_l"/"_m_l" : 웹페이지의 label id인지 모달창의 label id인지
    // ""/"_m" : 웹페이지의 checkbox input id인지, 모달창의 id인지    
    setschedule("_l", "", schedule_string);

    // 이번주일 경우 이전 버튼 비활성화 되게 처리
    checkBeforebtn(beforeDate_btn, timezone);

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
    console.log("통신 오류");
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

}

// 이전,다음 버튼 누를 때 날짜 세팅하고 check value 재 대입 해주는 함수
function setDate_Value(header_s, for_modal) {

  let header = document.getElementById(header_s);

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
  
              header.appendChild(utc_show);
  
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
  
              header.appendChild(date_day);     
                  
  
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

// 일정 등록에 세팅하는 함수
async function setschedule(type, for_modal, schedule_string) {      

    console.log("yes");
    // let test_string = "54_62_88";

    // 서버에서 받아온 string 배열로 변환
    let test_array = schedule_string.split('_');

    

    // 현재 모달창에서 체크하고 있는 배열 가져오기
    let check_array = new Array();
    check_array = array_for_edit;

    // 디폴트로 일단 회색으로 칠해놓기
    let default_label = document.getElementsByName("schedule_label");
    for (label of default_label) {
        label.style.backgroundColor = '#9CA3AF';
    }
    

    // 일정 체크박스 개수만큼 반복문 돌리기
    for (let i = 1; i <= 336; i++ ) {

        // 체크박스의 value값 가져오기
        let input_i = document.getElementById(i+for_modal).value;
        let label = document.getElementById(i + type);             

        // 모달창 아닐 때만 서버에서 받아온 값 뿌려주기
        if (for_modal == "") {

            for (let j = 0; j < test_array.length; j++) {
                            
                if (input_i == test_array[j]) {                                      
                                                                         
                    label.style.backgroundColor = '#2563EB';
                }               
            }
            // 현재 시간 이전 날짜일 경우에는 디폴트 색인 회색으로 두기
            if(checkNow_forSchedule(input_i)) {
                
              label.style.backgroundColor = '#9CA3AF';
            } 
        }
        // 모달창이면 서버에서 받아온거 바로 뿌려주지 말고 모달창 켰을 때 담은 배열에 있는값들 뿌려주기
        else {
            // 현재 체크하고 있는 array 개수만큼 반복문 돌려서 체크 (현재 편집중인 사항 표시하기 위해)
            for (let z = 0; z < check_array.length; z++) {
                                            
                if (input_i == check_array[z]) {
                    
                    // console.log("input_i : "+input_i);
                    // console.log("test_array[j] : "+test_array[j]);
                    
                    let label = document.getElementById(i + type);
                    // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
                    let input = document.getElementById(i+"_m");

                    input.checked = true;
                    label.style.backgroundColor = '#2563EB';
                }
                            
            }
        }           
    }  
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

      console.log("before");
     
      // time 스탬프 값 일주일 빼놓기 
      time = time - (7*(1000 * 60 * 60 * 24));
      
      console.log(dayjs(time).format('YYYY/MM/DD'));

      // getDate(header_s, timezone, for_modal);
      setDate_Value(id, for_modal);

  }
  // 다음 버튼 클릭할 경우
  else {      
      
      // time 스탬프 값 일주일 더해놓기 
      time = time + (7*(1000 * 60 * 60 * 24));
      
      // getDate(header_s, timezone, for_modal);
      setDate_Value(id, for_modal);
  }

  // checkbox값 부여된 이후에 저장된 일정 세팅
  setschedule(l_m, for_modal, schedule_string);

  // 이번주일 경우 이전 버튼 비활성화 되게 처리
  checkBeforebtn(beforeDate_btn, timezone);
  
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

async function getClassinfo(C_id) {

    console.log("class_id : "+C_id);

    const body = {
    
        kind : 'cdetail',
        classid : C_id,
        clname : 1,
        cldisc : 1,
        cltype : 1,
        cllevel : 1,
        cltime : 1,
        clprice : 1,
      };
     
      const res = await fetch('../restapi/classinfo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;'
        },
        body: JSON.stringify(body)
      });  

    const response = await res.json();  

    // console.log(response.result);

    const result = response.result[0];

    // console.log(result);

    const clname = result.CL_Name;
    const cldisc = result.CL_Disc;
    const cltype = result.CL_Type;
    const cllevel = result.CL_Level;
    const price = result.tp;

    // 전역변수에 대입 (모달창 하단에 표기할 용도)
    clname_g = clname;
    // 최종 예약 때 보낼 용도의 전역 변수에 대입
    clName_final = clname;

    // 수업 정보와 관련된 id들 가져오기
    const c_name = document.getElementById("c_name");
    const c_disc = document.getElementById("c_disc");
    const c_type = document.getElementById("c_type");
    const c_level = document.getElementById("c_level");
    const c_price30 = document.getElementById("c_price30");
    const c_price60 = document.getElementById("c_price60");

    // 파싱한 json 대입
    c_name.innerText = clname;
    c_disc.innerText = cldisc;
    c_level.innerText = cllevel.replace('_', ' - ');
    c_price30.innerText = price[0];
    c_price60.innerText = price[1];

    // 수업 유형 파싱해서 넣기
    if ((cltype != 'default') && (cltype != null)) {              
     
      let type_string = cltype;            
  
      let type_array = type_string.split(',');
     
      for (let j = 0; j < type_array.length; j++) {

          let type_list = document.createElement('span');          
          type_list.innerHTML = ['<span class = "text-xs ml-1 bg-gray-300 text-gray-800 mr-2 rounded-lg px-2">'+type_array[j]+'</span>'].join("");
          c_type.appendChild(type_list);  
      }                               
                  
  }     
}        
        
async function getTeacherinfo(U_id) {    

    const body = {
    
        tusid : U_id,
        timg : 1,
        tname : 1,
        tintro : 1,
        tcountry : 1,
        tresidence : 1,
        tspecial : 1,
        tlanguage : 1,
      };
     
      const res = await fetch('../restapi/teacherinfo.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;'
        },
        body: JSON.stringify(body)
      });  

    const response = await res.json();    
        
    // console.log(response);

    const result = response.result[0];

    const t_name = result.U_Name;
    const t_img = result.U_D_Img;
    const t_special = result.U_T_Special;
    const t_intro = result.U_T_Intro;
    const t_country = result.U_D_Country;
    const t_residence = result.U_D_Residence;
    const t_language = result.U_D_Language;

    // 강사 정보와 관련된 id들 가져오기
    const name_t = document.getElementById("t_name");
    const img_t = document.getElementById("t_img");
    const certi_t = document.getElementById("t_certi");
    const intro_t = document.getElementById("t_intro");
    const country_t = document.getElementById("t_country");
    const residence_t = document.getElementById("t_residence");
    const language_t = document.getElementById("t_speaks");

    // 파싱한 json 대입
    name_t.innerText = t_name;
    country_t.innerText = t_country+"출신";
    residence_t.innerText = t_residence+"거주";
    intro_t.innerText = t_intro;

    if (t_special == "default") {
      certi_t.innerText = '커뮤니티 튜터';
    }
    else {
      certi_t.innerText = '전문 강사';
    }
    img_t.setAttribute("src", s3_url+"Profile_Image/"+t_img);

    // 구사 가능 언어 대입
    const json_parse = JSON.parse(t_language);                  
           
    for (let key_l in json_parse) {

      let language_list = document.createElement('span');          
      language_list.innerHTML = ['<span class = "mr-2">'+key_l+' : '+json_parse[key_l]+'</span>'].join("");
      language_t.appendChild(language_list);
               
    }  

}

// 예약하기 버튼 누를 때 모달창 생성
// 모달 띄우는 코드 (처음 모달창 띄우기, 모달창 닫기, 이전버튼)
const classtimeModal = document.querySelector('.reserve-modal-time');
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
      classtimeModal.classList.remove('hidden');
      body.classList.add('scrollLock');
      
      // 해당 수업의 가격 출력
       getclassPrice_tm();
      
      // 전역으로 선언한 스케줄 array 초기화
      scheduleReserve_array_sm = [];

      // 모달창 하단에 해당 수업 이름 표기 (모든 모달창의 수업 이름에 세팅해 주어야 함)
      for (const name of cl_name_b) {
        name.innerHTML = clname_g;
        
        name.setAttribute(
            "class",
            "cl-name text-xs cl-name mx-1 px-3 py-2 bg-gray-200 rounded-2xl text-gray-800 b" +
                    "order border-gray-500 border-2"
        )
    }
  }    
});

// X버튼 누를 시 모달창 사라지고 모달창에서 설정한 값들 초기화
// 어떤 모달창의 X값을 누르더라도 반영이 되야하므로 반복문으로 처리
for (const close of closeModal) {

  close.addEventListener('click', function() {

    // 모든 모달값 가져오기    
    const classtimeModal = document.querySelector('.reserve-modal-time');
    const scheduleModal = document.querySelector('.reserve-modal-schedule');
    const cmtoolModal = document.querySelector('.reserve-modal-cmtool');

    // 모달 없어지게 처리    
    classtimeModal.classList.add('hidden');
    scheduleModal.classList.add('hidden');
    cmtoolModal.classList.add('hidden');

    // scrollloack 해지
    body.classList.remove('scrollLock');
     
      // 수업 시간 모달창에서 설정한 값들 다시 초기화
      initTimeModal();
      // 수업 일정 모달창에서 설정한 값들 다시 초기화
      initScheduleModal();
      // 커뮤니케이션 도구 모달창에서 설정한 값들 다시 초기화
      initCmtoolModal();
  })
}



