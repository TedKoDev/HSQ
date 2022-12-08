// 수업일정의 checkbox에 value값 부여할 전역 time값 선언
let time_sm;

// 클릭한 수업 횟수 카운트 체크하는 변수 선언 
let classCount_sm = 0;

// 신청한 스케줄 전역으로 선언
let scheduleReserve_array_sm = new Array();
let schedule_string_sm;

// 서버에서 받아온 유저의 timezone 전역으로 쓰기 위해 선언
let timezone_cs;

 // 수업 일정에서 다음 버튼 초기화
 let nextBtn_cs = document.querySelector(".nextBtn_cs");

// 모달창 하단에 수업시간 표시하는 뷰 초기화
let cl_schedule_b = document.querySelectorAll(".cl-schedule");

// 최종적으로 선택할 수업 배열
let clSchedule_final = new Array();

// 수업 일정에서 이전 버튼 초기화
let beforeArrow_clschedule = document.querySelector(".beforeArrow_clschedule");

// 이전 날짜로 이동하는 버튼 초기화(이번주에서는 이전 버튼 비활성화 되는 것 처리하기 위해)
let beforeDate_btn_cs = document.getElementById("beforeDate_btn_cs");


// 해당 강사의 수업 일정 화면에 출력하는 함수
async function getclassSchedule_sm() {

    // 로컬 시간대 추출
    const date = new Date();
    const utc = -(date.getTimezoneOffset() / 60);

    // 토큰, 로컬 시간대, 강사id 전송해서 해당 강사의 스케줄 받아오기
    const body = {

        token: checkCookie,
        utc: utc,
        tusid: U_id
    };
    const res = await fetch('../restapi/schedule.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });

    const response = await res.json();   

    if (response.success == 'yes') {

        schedule_string_sm = response.schedule;
        const timezone = response.timezone;

        // 전역으로 사용할 타임존 대입
        timezone_cs = response.timezone;

        // 현재 시간대 텍스트에 timezone 세팅
        setUtc(timezone);

        // 시간대에 맞게 날짜 세팅
        getDate_sm("header_s_sm", timezone) // 일단은 timezone 받아오는거 수정될 때까지 9로 하드코딩

        // 날짜에 맞게 checkbox에 value 세팅
        setDate_Value_sm("header_s_sm", "_sm");

        // checkbox에 일정 표시
        // "_l"/"_m_l" : 웹페이지의 label id인지 모달창의 label id인지
        // ""/"_m" : 웹페이지의 checkbox input id인지, 모달창의 id인지    
        setschedule_sm("_sm_l", "_sm", schedule_string_sm);

        // 이번주일 경우 이전 버튼 비활성화 되게 처리
        checkBeforebtn_cs(beforeDate_btn_cs, timezone_cs);
    }

    // 다음버튼 활성화 여부 체크

}

function getDate_sm(header_date, timezone) {

    // 전역 time_sm 초기화
    time_sm = 0;

    let header_s = document.getElementById(header_date);

    // 세팅하기 전에 일단 초기화
    while (header_s.firstChild) {
        header_s.removeChild(header_s.firstChild);
    }

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

    // 현재 타임스탬프 전역 변수에 대입
    time_sm = now.getTime();

    time_sm = time_sm - (1000 * 60 * 60 * 24) // 반복문 시작부터 time 더해지므로 디폴트 값으로 미리 한 번 빼놓기

}

// 이전,다음 버튼 누를 때 날짜 세팅하고 check value 재 대입 해주는 함수
function setDate_Value_sm(header_s, for_modal) {

    let header = document.getElementById(header_s);

    let week = new Array('일', '월', '화', '수', '목', '금', '토');

    let num = 0; // 날짜에 따라 value값 대입해주기 위한 임의의 num

    for (let i = 0; i < 8; i++) {

        if (i == 0) {

            let utc_show = document.createElement("div");
            utc_show.innerHTML = [
                '<div class = "flex flex-col w-20">', 
                    '<div class = "mx-auto"></div>', 
                '</div>'].join("");

            header.appendChild(utc_show);

        } else {

            time_sm = time_sm + (1000 * 60 * 60 * 24);     

            let new_Date = new Date(time_sm);

            let date = new_Date.getDate();
            let month = new_Date.getMonth() + 1;

            let day_array = new_Date.getDay();
            let day = week[day_array];

            let date_day = document.createElement("div");
            date_day.innerHTML = [
                '<div class = "flex flex-col w-20">', '<div class = "mx-auto">' + day,
                '</div>',
                '<div class = "mx-auto">' + month + "/" + date + '</div>',
                '</div>'
            ].join("");

            header.appendChild(date_day);

            // 336개의 체크박스 value에 년-월-일-시간을 대입 우선 해당 열의 년/월/일 추출
            const year_s = new_Date.getFullYear();
            const month_s = new_Date.getMonth() + 1;
            const day_s = new_Date.getDate();

            const test_day = year_s + "-" + month_s + "-" + day_s;

            // day.js 써서 타임스탬프로 변환
            let test_dayjs = dayjs(test_day);
            // test_dayjs.format();


            // 00:00 ~ 24:00에 해당하는 48개 체크박스에 해당 타임스탬프+시간대의 조합으로 value값 부여
            for (let j = 1; j <= 48; j++) {

                // 반복문 거칠때마다 우선 위에서 선언한 num 1씩 더하기
                num = num + 1;
                // 해당 체크박스의 id 가져오기 (value 세팅해주기 위해)
                const checkbox = document.getElementById(num + for_modal);                
                // 체크박스 위치에 따라 시간 더해주기                
                let add_dayjs = test_dayjs.add(30*j, "m");
                                          
                // 체크박스의 value에 더한 값의 타임스탬프를 넣어주기
                checkbox.setAttribute("value", add_dayjs.valueOf());

                // console.log(add_dayjs.valueOf());
                               
            }
        }
    }

    // 모든 세팅 끝나면 타임 다시 일주일 전으로 되돌리기
    time_sm = time_sm - 7 * (1000 * 60 * 60 * 24);
}

// 일정 등록에 세팅하는 함수
async function setschedule_sm(type, for_modal, schedule) {                        
    
    // 서버에서 받아온 string 배열로 변환
    let test_array = schedule.split('_');   
    
    // 디폴트로 일단 회색으로 칠해놓기
    let default_label = document.querySelectorAll(".label_sm");
    for (label of default_label) {
        label.style.backgroundColor = '#9CA3AF';
    }
    

    // 일정 체크박스 개수만큼 반복문 돌리기
    for (let i = 1; i <= 336; i++ ) {

        // 체크박스랑 그 value값 가져오기
        let input = document.getElementById(i+for_modal);
        let input_i = input.getAttribute("value");
        let label = document.getElementById(i + type);  
                   
        for (let j = 0; j < test_array.length; j++) {
            
            // 수업 가능한 시간일 경우 파란색으로 표시하고 checkbox 활성화            
            if (input_i == test_array[j]) {    
                                                               
                                
                label.style.backgroundColor = '#2563EB';
                                    
                input.disabled = false;                    
            }      
                     
        }  
        // 현재 시간 이전 날짜일 경우에는 디폴트 색인 회색으로 두고 체크박스 비활성화
        if(checkNow_forSchedule_cs(input_i)) {
        
        label.style.backgroundColor = '#9CA3AF';
        input.disabled = true;
        }        

        // 일정 선택했던 기록 가져와서 일치하는 체크박스를 선택한 색깔로 바꾸고 check 상태로 놓기
        for (let z = 0; z < scheduleReserve_array_sm.length; z++) {
            
            if (input_i == scheduleReserve_array_sm[z]) {

                const label = document.getElementById(i + type);                   
                label.style.backgroundColor = '#1E40AF';

                input.checked = true;

                // 해당 체크박스의 name에 check로 표시
                input.setAttribute("name", "check");
            }
        }        
    }    
  }

   
// 체크박스 클릭 리스너 설정
// 1. 해당 체크박스 클릭 시 체크값 true로 
// 2. true일 경우 색깔 변하게
// 3. false일 경우 색깔 원래대로
function scheduleClick(test) {

    const input = document.getElementById(test.id);
    const label = document.getElementById(test.id+"_l");

    // 수업 횟수 로컬 스토리지에서 가져오기
    const classTimes = localStorage.getItem("class_times");
                                                                                
    // 이전 모달창에서 신청한 수업 횟수가 현재 수업 신청한 갯수보다 많을 경우에만 적용되도록                  
    if (classTimes > scheduleReserve_array_sm.length) {

        if (input.checked == true) {                                 
                                            
            // 해당 input의 value값을 전역 array에 넣기
            scheduleReserve_array_sm.push(input.getAttribute("value"));          
            
            // 색깔 변화
            label.style.backgroundColor = '#1E40AF';

            // 해당 체크박스의 name에 check로 표시
            input.setAttribute("name", "check");
                                        
        }
        else {                                 
        
            // 전역 array에서 해당 input 값이 포함된 인덱스를 제거
            const delete_index = scheduleReserve_array_sm.indexOf(input.getAttribute("value"));                
            scheduleReserve_array_sm.splice(delete_index, 1);
            
            label.style.backgroundColor = '#2563EB';

            // 해당 체크박스의 name에 uncheck로 표시
            input.setAttribute("name", "uncheck");

            console.log(scheduleReserve_array_sm.length);    
            
        }    
    }
    // 만약 신청한 횟수까지 도달했을 경우
    else if (classTimes == scheduleReserve_array_sm.length){

        // 클릭한 체크박스가 이미 선택한 경우일 때 (진한 파랑색일 떄)
        // 1. 해당 값 array에서 없애기
        // 2. 해당 값의 색깔 원래 색깔로 바꾸기 (연한 파랑)
        // 3. 해당 값의 check를 false로 다시 바꾸기
        if (input.getAttribute("name") == "check") {

            console.log("check_pass");
            
            // 1. 전역 array에서 해당 input 값이 포함된 인덱스를 제거
            const delete_index = scheduleReserve_array_sm.indexOf(input.getAttribute("value"));                
            scheduleReserve_array_sm.splice(delete_index, 1);

            // 2. 해당 값의 색깔 원래대로 바꾸기
            label.style.backgroundColor = '#2563EB';

            // 3. 해당 값의 check를 false로 바꾸기
            // input.checked = false;

            // console.log(scheduleReserve_array_sm.length);  
        }
        // 클릭한 체크박스가 선택하지 않은 경우일 때 : 아무 이벤트 필요 없음
        else  {

           //  console.log("uncheck_pass");
        }        
    }

    // 다음 버튼 활성화 여부 체크
    checkNextbtn_cs();

    // 모달창 하단에 현재 선택한 수업 갯수 표시
    showClassnumber();
}

 
// 이전, 다음 버튼 눌렀을 떄 날짜 다시 세팅하고 checkbox value값 다시 세팅
function change_schedule_sm(type, id, l_m, for_modal) {

    let header_s = document.getElementById(id);

    // 세팅하기 전에 일단 초기화
    while(header_s.firstChild)  {
        header_s.removeChild(header_s.firstChild);
    }     

    // 이전 버튼 클릭할 경우
    if (type == 'before') {        
        
        // time_sm 스탬프 값 일주일 빼놓기 
        time_sm = time_sm - (7*(1000 * 60 * 60 * 24));
                        
        // getDate(header_s, timezone, for_modal);
        setDate_Value_sm("header_s_sm", "_sm");

    }
    // 다음 버튼 클릭할 경우
    else {      
        
        // time 스탬프 값 일주일 더해놓기 
        time_sm = time_sm + (7*(1000 * 60 * 60 * 24));
        
        // getDate(header_s, timezone, for_modal);
        setDate_Value_sm("header_s_sm", "_sm");
    }

    // checkbox값 부여된 이후에 저장된 일정 세팅
    setschedule_sm(l_m, for_modal, schedule_string_sm);

    // 이번주일 경우 이전 버튼 비활성화 되게 처리
    checkBeforebtn_cs(beforeDate_btn_cs, timezone_cs);
}

// 현재 시각 이전 날짜는 수업 예약 못하게 처리
function checkNow_forSchedule_cs(value) {

    // 현재 날짜 객체 생성
    const now = new Date();
    
    // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
    const offset = (now.getTimezoneOffset() / 60);
    now.setHours(now.getHours() + offset);    
  
    // 날짜 표시하기 전에 받아온 타임존 적용
    const string_to_int = parseInt(timezone_cs);
    
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

// 다음 버튼 활성화 여부 체크
function checkNextbtn_cs() {
      
    // 수업 횟수 로컬 스토리지에서 가져오기
    const classTimes = localStorage.getItem("class_times");

    // 수업 횟수와 담은 배열이 같을 경우에만 다음 버튼 활성화
    if (classTimes == scheduleReserve_array_sm.length) {
        nextBtn_cs.disabled = false;        
    }
    else {
        nextBtn_cs.disabled = true;        
    }

 
     if (nextBtn_cs.disabled == true) {
        nextBtn_cs.setAttribute(
             "class",
             "nextBtn_ct bg-gray-200 px-3 py-1 rounded text-white"
         );
     } else {
        nextBtn_cs.setAttribute(
             "class",
             "nextBtn_ct bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white"
         );
     }
 }

 // 모달창 하단에 클릭한 수업 횟수 표시 (ex : 1 / 5 회 예약)
 function showClassnumber() {

    // 수업 횟수 로컬 스토리지에서 가져오기
    const classTimes = localStorage.getItem("class_times");    

    for (const name of cl_schedule_b) {

        name.innerHTML = scheduleReserve_array_sm.length+" / "+classTimes+" 회 예약";
        name.setAttribute("class", "cl-schedule text-xs cl-name mx-1 px-3 py-2 bg-gray-200 rounded-2xl text-gray-800 border border-gray-500 border-2")
    }
 }

 // 수업 일정 모달 초기화
 function initScheduleModal() {

    // 전역 array 초기화
    scheduleReserve_array_sm = [];

    // 하단에 표시되는 div 초기화
    for (const name of cl_schedule_b) {

        name.innerHTML = "";
        name.setAttribute("class", "");
    }

 }

 // 이번주에서 이전 날짜 버튼 클릭할 수 없게 처리
 function checkBeforebtn_cs(beforeDate_btn_cs, timezone_cs) {

    // 현재 날짜 객체 생성
    const now = new Date();

    // 현재 날짜의 시/분/초 초기화
    now.setHours(0);
    now.setMinutes(0); 
    now.setSeconds(0);

    console.log(now.getTime());
   
    // UTC 시간과의 차이 계산하고 적용 (UTC 시간으로 만들기 위해)
    const offset = (now.getTimezoneOffset() / 60);
    now.setHours(now.getHours() + offset);

    // 날짜 표시하기 전에 받아온 타임존 적용
    const string_to_int = parseInt(timezone_cs);
    now.setHours(now.getHours() + string_to_int);

    const checkTime = now.getTime();
    const time_sm_check = time_sm + (1000 * 60 * 60 * 24); 

    console.log("checkTime : "+dayjs(checkTime).format('YYYY/MM/DD'));
    console.log("time_sm : "+dayjs(time_sm_check).format('YYYY/MM/DD'));

    // 가공한 날짜가 전역 time_sm과 같을 경우 이전 버튼 비활성화
    if (dayjs(checkTime).format('YYYY/MM/DD') == dayjs(time_sm_check).format('YYYY/MM/DD')) {
       
        beforeDate_btn_cs.setAttribute("class", "disabled: border-2 border-gray-200 bg-gray-200 text-gray-50 px-1 py-1 rounded ml-1 mr-1");
    }
    // 다를 경우 이전 버튼 활성화
    else {
        
        beforeDate_btn_cs.setAttribute("class", "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1");
    }

 }

 // 다음 버튼 클릭했을 때 이벤트
 nextBtn_cs.addEventListener('click', function() {

    // 전역 변수에 선택한 수업 배열 대입
    clSchedule_final = scheduleReserve_array_sm;

    // 수업 목록 모달, 수업 시간 모달, 수업일정, 커뮤니케이션도구 모달 값 가져오기
    const classlistModal = document.querySelector('.reserve-modal-class');
    const classtimeModal = document.querySelector('.reserve-modal-time');
    const scheduleModal = document.querySelector('.reserve-modal-schedule');
    const cmtoolModal = document.querySelector('.reserve-modal-cmtool');

    // 수업 목록, 수업시간, 수업일정 모달 없어지게 처리
    classlistModal.classList.add('hidden');
    classtimeModal.classList.add('hidden');
    scheduleModal.classList.add('hidden');

    // 커뮤니케이션 모달 표시되게 처리
    cmtoolModal.classList.remove('hidden');

 })

// 시간대 세팅
function setUtc(timezone) {

    const utc = document.getElementById("utc_scheduleModal");

    let utc_string;

    if (utc >= 0) {
        utc_string = "(UTC+" + timezone + ":00)";

    } else {
        utc_string = "(UTC" + timezone + ":00)";

    }
    utc.innerHTML = utc_string;
}

const beforeClick_clschedule_cs = () => {    

    // 수업 시간 모달, 수업 일정 모달 값 가져오기    
    const classtimeModal = document.querySelector('.reserve-modal-time');
    const scheduleModal = document.querySelector('.reserve-modal-schedule');

     // 수업 시간 보이고 수업 일정 없어지게 처리
     scheduleModal.classList.add('hidden');
     classtimeModal.classList.remove('hidden');
};

// 이전 버튼 클릭하면 수업 일정 모달창 지우고 수업 시간 모달창 띄우기
beforeArrow_clschedule.addEventListener('click', beforeClick_clschedule_cs);

