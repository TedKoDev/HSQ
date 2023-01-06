// 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력

// 해당 유저의 utc 가져온후 date에 가져온 utc 적용
let checkCookie = getCookie("user_info");
get_utc(checkCookie);

// 서버에서 받아온 타임존 대입할 선언
let timezone;

// 서버에서 요청받은 일정이 담긴 string값 담을 변수 선언
let schedule_string;
// 서버에서 받은 일정의 상태 (승인대기/미완료/완료/취소된 수업)
let schedule_string_status;

// 모달창에서 수정할 때 일정 담긴 string을 배열로 변환하는 변수 선언
let array_for_edit = new Array();

// 모달창에서 정규 일정 등록할 때 체크한 값들 담을 배열 선언
let array_for_upload = new Array();

// 타임스탬프 담을 전역 변수 선언
let time;

// utc api에서 받아온 해당 유저의 id
let user_id;


async function get_utc(tokenValue) {

    const body = {
    
        token: tokenValue
      };
    
      const res = await fetch('/utils/utc.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
      });  

      const response = await res.json();  
      const success = response.success;
      timezone = response.user_timezone;
      user_id = response.user_id;

      if (success == "yes") {

        // 날짜 설정하고 checkbox값에 timestamp 부여
        getDate("header_s", timezone, "");

        // checkbox값 부여된 이후에 저장된 일정 세팅
        setschedule("_l", "");
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
    // const string_to_int = parseInt(timezone);
    // now.setHours(now.getHours() + string_to_int);
    
    // 현재 타임스탬프 전역 변수에 대입
    time = now.getTime();
        
    time = time - (1000 * 60 * 60 * 24) // 반복문 시작부터 time 더해지므로 디폴트 값으로 미리 한 번 빼놓기

    setDate_Value(header_s, for_modal);
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



// DB에 있는 일정 정보 화면에 세팅하는 함수
async function setschedule(type, for_modal) {    

    const body = {

        token: checkCookie,   
        user_timezone: timezone,
        user_id_teacher: user_id,    
    
        };
    const res = await fetch('/restapi/schedule.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });
    
    const response = await res.json();   

    console.log(response);
    const check = response.success; 
    schedule_string = response.teacher_schedule_list;  
    schedule_string_status = response.teacher_schedule_list_status;
      

    // 값이 있을 경우에만 추출해서 대입
    if (check == "yes") {
               
        // 서버에서 받아온 string 배열로 변환
        const classList = schedule_string.split('_');
        const statusList = schedule_string_status.split('_');

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
            
            // 모달창 아닐 때만 서버에서 받아온 값 뿌려주기
            if (for_modal == "") {

                for (let j = 0; j < classList.length; j++) {
                                
                    if (input_i == classList[j]) {                                               
                        
                        let label = document.getElementById(i + type);                    
                        let input = document.getElementById(i+"_m");
    
                        // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
                        input.checked = true;
                        label.style.backgroundColor = '#2563EB';

                         // 예약 불가능한 상태일 경우 색깔 다른색으로 칠하기
                        // 9 : 예약 가능한 상태. 2 : 수업 취소된 상태 -> 9나 2가 아닐 경우 수업 신청 못함
                        if (!(statusList[j] == 9 || statusList[j] == 2)) {
                                                                        
                            label.style.backgroundColor = '#6B7280';                   
                        }
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

                        // 예약 불가능한 상태일 경우 색깔 다른색으로 칠하고 checkbox 비활성화
                        // 9 : 예약 가능한 상태. 2 : 수업 취소된 상태 -> 9나 2가 아닐 경우 수업 신청 못함                    
                        if (!(statusList[z] == 9 || statusList[z] == 2)) {
                                                                            
                            label.style.backgroundColor = '#6B7280';      
                            input.disabled = true;             
                        }
                            }
                                
                }
            }            
        }
    }
}

// 체크여부에 따라 색깔 변환하고 array에 value값 추가,제거
function test_click(event) {

    let label_id = event.target.id;

    let label = document.getElementById(label_id + "_l");
    
    let result = event.target.value;

    // 일정 편집일 경우
    if (event.target.name == "edit") {

        // 체크할 경우 배열에 추가
        if (event.target.checked) {
            // result = event.target.value;
                
            label.style.backgroundColor = '#2563EB';
    
            // 일정 저장을 위한 array에 해당 value 추가
            array_for_edit.push(result);    

            console.log(array_for_edit);
                
        } 
        // 체크 풀를 경우 해당 인덱스 배열에서 제외
        else {        
    
            label.style.backgroundColor = '#9CA3AF';
            
            const delete_index = array_for_edit.indexOf(result)
                
            array_for_edit.splice(delete_index, 1);

            console.log(array_for_edit);
            
        }
    }
    // 정규 일정 등록일 경우
    else if (event.target.name == "upload"){

        if (event.target.checked) {
            // result = event.target.value;
                
            label.style.backgroundColor = '#2563EB';
    
            // 일정 저장을 위한 array에 해당 value 추가
            array_for_upload.push(result);    

            console.log(array_for_upload);
                
        } else {        
    
            label.style.backgroundColor = '#9CA3AF';
            
            const delete_index = array_for_upload.indexOf(result)
                
            array_for_upload.splice(delete_index, 1);

            console.log(array_for_upload);            
        }
    }
    
    
}

// 모달 관련 코드     

// 일정 수정 완료 (서버에 저장)
async function edit_done() {
          
    // 수정 중에 변경된 배열 send_array에 대입
    let send_array = new Array();
    send_array = array_for_edit;

    // 문자열로 변환
    let send_string = send_array.join("_");

    const body = {

        token: checkCookie,
        schedule_list: send_string,  
        user_timezone: timezone

        };
    const res = await fetch('./manageupdateProcess.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(body)
    });    

    // 정상적으로 저장될 경우 수정된 내역 화면에 다시 반영
    const response = await res.json();
    const check = response.success;    

    console.log("check : "+check);
    
    if (check == "yes") {
        
        // setschedule("_l", "_m");
        setschedule("_l", "");
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

// 정규일정 등록 완료 (서버에 저장)
async function upload_done() {

     // 일정등록 배열 send_array에 대입
     let send_array = new Array();
     send_array = array_for_upload;
 
     // 문자열로 변환
     let send_string = send_array.join("_");
 
     const body = {
 
         token: checkCookie,
         repeat: check_value,
         schedule_list: send_string,  
         user_timezone: timezone
 
         };
     const res = await fetch('./manageuploadProcess.php', {
     method: 'POST',
     headers: {
         'Content-Type': 'application/json;charset=utf-8'
     },
     body: JSON.stringify(body)
     });    
      
     // 정상적으로 저장될 경우 수정된 내역 화면에 다시 반영
    const response = await res.json();
    const check = response.success;
    const test_string = response.plan;

    console.log("check : "+check);
    
    if (check == "yes") {
        
        setschedule("_l", "");
    }

    const body2 = document.getElementsByTagName('body')[0];
    const overlay2 = document.querySelector('#overlay_upload')

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

// 4주, 8주, 12주 클릭 이벤트
let check_value = 4; // 체크 값 보내기 위해 재할당하는 변수 선언
function radio_click(event) {

    const week4 = document.getElementById("4week");
    const week8 = document.getElementById("8week");
    const week12 = document.getElementById("12week");

    if (event.target.id == "4week") {
        week4.checked = true;
        week8.checked = false;
        week12.checked = false;
        check_value = 4;
    }
    else if(event.target.id == "8week") {
        week4.checked = false;
        week8.checked = true;
        week12.checked = false;
        check_value = 8;
    }
    else if(event.target.id == "12week") {
        week4.checked = false;
        week8.checked = false;
        week12.checked = true;
        check_value = 12;
    }
}

// 정규 일정 등록할 때 checkbox값에 value 세팅
function setValue_forUpload(for_modal) {

                       
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

    // 타임존 적용한 날짜의 첫째주 월요일로 변환
    const get_day = now.getDay();
    const diff = now.getDate() - get_day + (get_day == 0 ? -6 : 1);
    now.setDate(diff);    

    let time_u = now.getTime();
   
    
    let num = 0; // 날짜에 따라 value값 대입해주기 위한 임의의 num

    for (let i = 1; i < 8; i++) {              

        let new_Date = new Date(time_u);                              

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
            
        }     
        
        time_u = time_u + (1000 * 60 * 60 * 24);
    }       
    
}

// 모달창 보여주기, 모달창 다시 내리기
window.addEventListener('DOMContentLoaded', () => {

    const body = document.getElementsByTagName('body')[0];

    const overlay = document.querySelector('#overlay')
    const overlay_upload = document.querySelector('#overlay_upload')
    const edit_btn = document.getElementById('edit_schedule_btn')
    const upload_btn = document.getElementById('upload_schedule_btn');
    
    const edit_cancel_btn = document.getElementById('edit_cancel_btn');
    const upload_cancel_btn = document.getElementById('upload_cancel_btn');
  
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
        getDate("header_s_m", timezone, "_m");        

        // 일정 있는 곳에만 색깔 변환
        setschedule("_m_l", "_m");


        // 우선 전역으로 선언한 array 초기화
        array_for_edit = [];        
        
        // 전역으로 선언한 array에 스케줄 string을 배열로 전환해서 대입
        if (schedule_string != "") {

            array_for_edit = schedule_string.split('_');
        }        
    }

    const show_modal_upload = () => {
        
        overlay_upload
            .classList
            .toggle('hidden')
        overlay_upload
            .classList
            .toggle('flex')

        body
            .classList
            .add('scrollLock');

        // 배열 값 초기화
        array_for_upload = [];

        // 체크박스에 value값 세팅
        setValue_forUpload("_u")
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
        setschedule("_l", "");

    }          
    
    const cancel_modal_upload = () => {                           

        overlay_upload
            .classList
            .toggle('hidden')
            overlay_upload
            .classList
            .toggle('flex')

        body
            .classList
            .remove('scrollLock');    
            
        // 일정 다시 세팅
        setschedule("_l", "");

    }     
    

    edit_btn.addEventListener('click', show_modal)
    upload_btn.addEventListener('click', show_modal_upload)
    // closeBtn.addEventListener('click', cancel_modal)
    edit_cancel_btn.addEventListener('click', cancel_modal)
    upload_cancel_btn.addEventListener('click', cancel_modal_upload)
})


