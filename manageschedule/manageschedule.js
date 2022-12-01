// 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력

// 해당 유저의 utc 가져온후 date에 가져온 utc 적용

get_utc(checkCookie);

let timezone;

// 서버에서 요청받은 일정이 담긴 string값 담을 변수 선언
let schedule_string;

// 타임스탬프 담을 전역 변수 선언
let time;

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
      timezone = response.timezone;

      if (success == "yes") {

        // 날짜 설정하고 checkbox값에 timestamp 부여
        getDate("header_s", timezone);

        // checkbox값 부여된 이후에 저장된 일정 세팅
        setschedule("_l");
      }
      else {
        console.log("타임존 못불러옴")
      }
}

function getDate(header_date, timezone) {

    let header_s = document.getElementById(header_date);

    // 세팅하기 전에 일단 초기화
    while(header_s.firstChild)  {
        header_s.removeChild(header_s.firstChild);
      }

    // 현재 날짜 객체 생성
    let now = new Date();

    // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
    const offset = (now.getTimezoneOffset()/60);
    now.setHours(now.getHours() + offset);
    
    // 날짜 표시하기 전에 받아온 타임존 적용 
    const string_to_int = parseInt(timezone);
    now.setHours(now.getHours() + string_to_int);
    
    // 현재 타임스탬프 전역 변수에 대입
    time = now.getTime();
        
    time = time - (1000 * 60 * 60 * 24) // 반복문 시작부터 time 더해지므로 디폴트 값으로 미리 한 번 빼놓기

    setDate_Value(header_s);
}

// 이전,다음 버튼 클릭시 그 주에 해당하는 날짜 변경되고 checkbox의 value값도 그에 따라 변경
function change_schedule(type) {

    let header_s = document.getElementById("header_s");

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

        setDate_Value(header_s);

    }
    // 다음 버튼 클릭할 경우
    else {      
        
        // time 스탬프 값 일주일 더해놓기 
        time = time + (7*(1000 * 60 * 60 * 24));
        
        setDate_Value(header_s);
    }
    
}

// 이전,다음 버튼 누를 때 날짜 세팅하고 check value 재 대입 해주는 함수
function setDate_Value(header_s) {

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
    
                let day_array = new_Date.getDay();
                let day = week[day_array];            
    
                let date_day = document.createElement("div");
                date_day.innerHTML = [
                    '<div class = "flex flex-col w-20">', '<div class = "mx-auto">' + day,
                            '</div>',
                    '<div class = "mx-auto">' + date + '</div>',
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
                    // 해당 체크박스의 값 가져오기 (value 세팅해주기 위해)
                    const checkbox = document.getElementById(num);
                    // 체크박스 위치에 따라 시간 더해주기
                    let add_dayjs = test_dayjs.set("m", 30*j);
                    // 체크박스의 value에 더한 값의 타임스탬프를 넣어주기
                    checkbox.setAttribute("value", add_dayjs.valueOf());
                                        
                }
            }
    
        }        

        // 모든 세팅 끝나면 타임 다시 일주일 전으로 되돌리기
        time = time - 7*(1000 * 60 * 60 * 24);
}



// 서버에 요청해서 일정 데이터 담겨있는 string 불러오기

// 화면 켜지면 저장된 일정 세팅
// setschedule("_l");

// 일정 등록에 세팅하는 함수
async function setschedule(type) {    

    const body = {

        token: checkCookie,       
    
        };
    const res = await fetch('./managescheduleProcess.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });
    
    const response = await res.json();   
    const check = response.success; 
    schedule_string = response.schedule;    

    // 값이 있을 경우에만 추출해서 대입
    if (check == "yes") {

        console.log("yes");
        // let test_string = "54_62_88";

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

                    let label = document.getElementById(i + type);
                    // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
                    let input = document.getElementById(i+"_m");

                    input.checked = true;
                    label.style.backgroundColor = 'blue';
                }               
            }
        }
    }
}

// check일 경우 파란색으로
function test_click(event) {

    let label_id = event.target.id;

    let label = document.getElementById(label_id + "_l");

    let result = "";
    if (event.target.checked) {
        result = event.target.value;

        console.log(event.target.id);
        label.style.backgroundColor = 'blue';

    } else {
        result = "0";

        label.style.backgroundColor = '#9CA3AF';

        // console.log(result);
    }
}

// 모달 관련 코드     

// 일정 수정 완료 (서버에 저장)
async function edit_done() {

    let send_array = new Array();

    for (let i = 1; i <= 336; i++) {

        let input_check = document.getElementById(i+"_m");

        if (input_check.checked) {

            send_array.push(input_check.value);
            
        }                        
    }

    let send_string = send_array.join("_");

    console.log(send_string);                    

    const body = {

        token: checkCookie,
        plan: send_string,  

        };
    const res = await fetch('./manageuploadscheduleProcess.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });    

    // 정상적으로 저장될 경우 수정된 내역 화면에 다시 반영
    const response = await res.json();
    const check = response.success;
    const test_string = response.schedule;

    console.log("check : "+check);
    
    if (check == "yes") {
        
        setschedule("_l");
    }

    const body2 = document.getElementsByTagName('body')[0];
    const overlay2 = document.querySelector('#overlay')

    // 모달창 내리기
    overlay2
        .classList
        .toggle('hidden')
    overlay2
        .classList
        .toggle('flex')

    body2
        .classList
        .remove('scrollLock');

}

// 모달창 보여주기, 모달창 다시 내리기
window.addEventListener('DOMContentLoaded', () => {

    const body = document.getElementsByTagName('body')[0];

    const overlay = document.querySelector('#overlay')
    const edit_btn = document.getElementById('edit_schedule_btn')
    // const closeBtn = document.querySelector('#close-modal')

    const edit_done_btn = document.getElementById('edit_done_btn')
    const edit_cancel_btn = document.getElementById('edit_cancel_btn')

    const schedule_div = document.getElementById('schedule');


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

        // 날짜 뿌려주기
        getDate("header_s_m", timezone);

        // 일정 있는 곳에만 색깔 변환
        setschedule("_m_l");
       
    }

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
        setschedule("_l");

    }            

    edit_btn.addEventListener('click', show_modal)

    // closeBtn.addEventListener('click', cancel_modal)
    edit_cancel_btn.addEventListener('click', cancel_modal)
})


