// 일정 표시 관련 변수 및 함수

// schedule.js에 선언된 변수,함수들 export

// timezone 전역 변수 선언
export let timezone;
// 서버에서 요청받은 일정이 담긴 string값 담을 변수 선언
export let schedule_string;
// 모달창에서 수업 신청할 때 일정 담긴 string을 배열로 변환하는 변수 선언
export let array_for_edit = new Array();
// 타임스탬프 담을 전역 변수 선언
export let time;

export function test() {

    console.log("testtest");
}


export async function getSchedule(teacher_id, tokenvalue) {

  // 로컬 타임존도 보내기
  const date = new Date();    
  const utc = -(date.getTimezoneOffset() / 60);
  
  console.log("utc : "+utc);

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

  if (response.success == "yes") {

    // 전역으로 선언한 일정에 가져온 값 대입
    schedule_string = response.schedule;
    // 전역으로 선언한 timezone 값 대입
    timezone = response.timezone;

    console.log(response);

    // 세팅
    // header_s : (모달창이 아닌)웹페이지에 있는 날짜
    // timezone : 받아온 시간대 or 로컬 시간대
    // "" : (모달창이 아닌) 웹페이지의 checkbox id 표시용도

    // 시간대에 맞게 날짜 세팅
    getDate("header_s", timezone) // 일단은 timezone 받아오는거 수정될 때까지 9로 하드코딩

    // 날짜에 맞게 checkbox에 value 세팅
    setDate_Value("header_s", "");

    // checkbox에 일정 표시
    // "_l"/"_m_l" : 웹페이지의 label id인지 모달창의 label id인지
    // ""/"_m" : 웹페이지의 checkbox input id인지, 모달창의 id인지
    
    setschedule("_l", "", schedule_string);

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

export function getDate(header_date, timezone) {

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
export function setDate_Value(header_s, for_modal) {

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

// 이전,다음 버튼 클릭시 그 주에 해당하는 날짜 변경되고 checkbox의 value값도 그에 따라 변경
// type : before/after - 이전 버튼인지 다음 버튼인지
// id : header_s/header_s_m - 웹페이지 날짜인지, 모달창 날짜인지
// l_m : "_l"/"_m_l" - 웹페이지의 checkbox label id인지, 모달창의 label id인지
// for_modal : ""/"_m" - 웹페이지의 checkbox input id인지, 모달창의 id인지
export function change_schedule(type, id, l_m, for_modal) {

    console.log("id : "+id);
  let header_s = document.getElementById(id);

  // 세팅하기 전에 일단 초기화
  while(header_s.firstChild)  {
      header_s.removeChild(header_s.firstChild);
  }     

  // 이전 버튼 클릭할 경우
  if (type == 'before') {

      console.log("before");
      console.log("time : "+time);
     
      // time 스탬프 값 일주일 빼놓기 
      time = time - (7*(1000 * 60 * 60 * 24));
      
      console.log(dayjs(time).format('YYYY/MM/DD'));

      // getDate(header_s, timezone, for_modal);
      setDate_Value(header_s, for_modal);

  }
  // 다음 버튼 클릭할 경우
  else {      
      
      // time 스탬프 값 일주일 더해놓기 
      time = time + (7*(1000 * 60 * 60 * 24));
      
      // getDate(header_s, timezone, for_modal);
      setDate_Value(header_s, for_modal);
  }

  // checkbox값 부여된 이후에 저장된 일정 세팅
  setschedule(l_m, for_modal);
  
}

export async function setschedule(type, for_modal, s_string) {    
            
      let test_array = s_string.split('_');      

      // 현재 모달창에서 체크하고 있는 배열 가져오기
      let check_array = new Array();
      check_array = array_for_edit;

      // 디폴트로 일단 회색으로 칠해놓기
      let default_label = document.getElementsByName("schedule_label");
      
      for (const label of default_label) {
        
          label.style.backgroundColor = '#9CA3AF';
      }           

      // 일정 체크박스 개수만큼 반복문 돌리기
      for (let i = 1; i <= 336; i++ ) {
          
          // 체크박스의 value값 가져오기
          let input_i = document.getElementById(i+for_modal).value;
          
          // 모달창 아닐 때만 서버에서 받아온 값 뿌려주기
          if (for_modal == "") {
                          
              for (let j = 0; j < test_array.length; j++) {
                              
                  if (input_i == test_array[j]) {                                           
                      
                      let label = document.getElementById(i + type);                    
                      // let input = document.getElementById(i+"_m");
  
                      // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
                      // input.checked = true;
                      label.style.backgroundColor = '#2563EB';                      
                  }               
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
