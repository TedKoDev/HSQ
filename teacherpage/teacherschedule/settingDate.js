import { $, $_all } from "/utils/querySelector.js";
import { timezone } from "./teacherschedule.js";


// 1. 접속한 유저의 시간대 기준으로 오늘 날짜의 00:00:00 추출

export function calendarInit(scheduleInfo) {

    // 서버에서 받아온 스케줄 array 파싱
    const allScheduleList = scheduleInfo.result;
    
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
    
    // 달력에서 표기하는 날짜 객체  
    let thisMonth = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    
    let currentYear = thisMonth.getFullYear(); // 달력에서 표기하는 연
    let currentMonth = thisMonth.getMonth(); // 달력에서 표기하는 월
    let currentDate = thisMonth.getDate(); // 달력에서 표기하는 일

        
    
    renderCalender(now);


    async function renderCalender(thisMonth) {

        // 해당 array의 class_start_time 타임스탬프의 월을 가져온 뒤 currentMonth와 일치하는 array만 추출해서 새로운 array 만들기
        let monthSchedule = new Array();
        

        for (const schedule of allScheduleList) {            

            console.log("left : "+dayjs(parseInt(schedule.schedule_list)).get('month'));
            console.log("right : "+dayjs(thisMonth).get('month'));

            if (dayjs(parseInt(schedule.schedule_list)).get('month') == dayjs(thisMonth).get('month')) {
                console.log("pas");
                monthSchedule.push(schedule);
            }
        } 
        // schedule_list을 기준으로 가장 이른 수업부터 먼저 배치되도록 정렬 순서 변경
        monthSchedule.sort(function (a,b) {
            return parseInt(a.schedule_list) - parseInt(b.schedule_list);
        })        
        
    
        currentYear = thisMonth.getFullYear();
        currentMonth = thisMonth.getMonth();
        currentDate = thisMonth.getDate();
            
        // 2. 현재 달(캘린더에 표시되는 달) 기준 이전 달의 마지막날짜와 그 요일 구하기
        let startDay = new Date(currentYear, currentMonth, 0);    
        let prevDate = startDay.getDate();
        let prevDay = startDay.getDay();
    
        // 3. 현재 달(캘린더에 표시되는 달) 기준 이번 달의 마지막날 날짜와 요일 구하기
        let endDay = new Date(currentYear, currentMonth + 1, 0);
        let nextDate = endDay.getDate();
        let nextDay = endDay.getDay();
        
    
        // 현재 월 표기
        $('.currentMonth').innerHTML = (currentYear + '년 ' + (currentMonth + 1)+'월'); 
        

        // 4. 지난달/이번달/다음달 for문 안에서 날짜를 세팅해주기

        // 우선 기존에 있는 값들 모두 초기화
        for (const date of ($_all('.schedule_date'))) {

            date.innerText = "";
        }
        for (const date_block of ($_all('.schedule_block'))) {  

            date_block.classList.remove("bg-blue-200");
           
        }
        for (const schedule_list of ($_all('.schedule_list'))) {

            while(schedule_list.firstChild)  {
                schedule_list.removeChild(schedule_list.firstChild);
            }
        }
        

        let num = 0;    
        // 지난달
        for (var i = prevDate - prevDay + 1; i <= prevDate; i++) {
            // calendar.innerHTML = calendar.innerHTML + '<div class="day prev disable">' + i + '</div>'
            num = num + 1;
            let date = document.getElementById(num+"_date");
            date.setAttribute("class", "schedule_date text-sm text-gray-400")
            date.innerText = i;
            
        }
        // 이번달
        for (var i = 1; i <= nextDate; i++) {
            // calendar.innerHTML = calendar.innerHTML + '<div class="day current">' + i + '</div>'
            num = num + 1;
            let date = document.getElementById(num+"_date");
            date.setAttribute("class", "schedule_date text-sm")
            date.innerText = i;

            // 이번달의 경우 schedule_block의 value값에 날짜 세팅 (ex : 2022-12-05)
            let date_block = document.getElementById(num+"_block");
            date_block.value = currentYear+"-"+(currentMonth+1)+"-"+('00'+i).slice(-2);

            // 스케줄 리스트 넣을 div 선언
            let schedule_list_div = document.getElementById(num+"_list");
            

            // 오늘날짜는 색깔 다르게 처리
            if ((parseInt(now.getMonth()) == currentMonth) && (parseInt(now.getDate()) == i)) {
                date.setAttribute("class", "schedule_date text-sm text-blue-700 border-b")
                let date_block = document.getElementById(num+"_block");
                date_block.classList.add("bg-blue-200");                
            }
           


            // 해당 날짜에 스케줄 있을 경우 스케줄 넣기
            for (const schedule of monthSchedule) {

                if (dayjs(parseInt(schedule.schedule_list)).format('YYYY-MM-DD') == date_block.value) {
                  
                    const classId = schedule.class_register_id;                    
                    const teacherNmae = schedule.user_name;
                    const classTime = schedule.class_time;
                    const startTime = dayjs(parseInt(schedule.schedule_list)).subtract(parseInt(classTime), 'minute').format('hh:mm');
                    const endTime = dayjs(parseInt(schedule.schedule_list)).format('hh:mm');
                    const time = startTime+" - "+endTime;
                    const button = document.createElement("button");                                        
                    button.innerHTML = `<div class = "flex flex-col px-2 mt-1 rounded-lg py-1" id = ${classId}_schedule>
                                        <span class = "text-xs mb-1 text-white text-left">${time}</span>
                                        <span class = "text-xs text-white text-left">${teacherNmae}</span>
                                    </div>`                    
                    
                    schedule_list_div.appendChild(button);                   
                   
                    // 수업 상태에 따라 수업의 색깔 다르게 처리
                    let status = schedule.class_register_status;
                    let schedule_item = document.getElementById(classId+"_schedule");
                    // 아직 승인 안됬을 경우
                    if (status == 0) {
                        schedule_item.classList.add('bg-sky-600');                        
                    }
                    // 승인은 완료됬고 수업 대기중일 경우
                    else if (status == 1) {
                        schedule_item.classList.add('bg-violet-600');      
                    }
                    // 취소된 수업일 경우
                    else if (status == 2) {
                        schedule_item.classList.add('bg-gray-400');
                    }
                    // 완료된 수업일 경우
                    else if (status == 3) {
                        schedule_item.classList.add('bg-violet-600');
                    }

                    // 해당 수업 클릭 시 수업 id post로 전송하고 수업 상세 화면으로 이동
                    button.addEventListener('click', () => {

                        goClassDetail(classId, '/myclass/');
                    })
                }                
            }


            
        }
        // 다음달
        for (var i = 1; i <= (7 - nextDay == 7 ? 0 : 7 - nextDay); i++) {
            
            num = num + 1;
            let date = document.getElementById(num+"_date");
            date.setAttribute("class", "schedule_date text-sm text-gray-400")
            date.innerText = i;
        }      
            
    }

    function goClassDetail(class_id, url) {
        
        const form = document.createElement('form');
        form.setAttribute('method', 'get');
        // form.setAttribute('target', '_blank');
        form.setAttribute('action', url);

        const hiddenField = document.createElement('input');
        hiddenField.setAttribute('type', 'hidden');
        hiddenField.setAttribute('name', 'class_id');
        hiddenField.setAttribute('value', class_id);
        form.appendChild(hiddenField);

        document.body.appendChild(form);

        form.submit();
        
        // location.assign(url+"?class_id="+class_id);
    }

    // 이전/다음 버튼 눌러서 캘린더 날짜 변경할 때 다시 재 렌더링하는 함수
    async function changeMonth(number) {

        thisMonth = new Date(currentYear, currentMonth + number, 1);
                
        renderCalender(thisMonth);
    }

    // 이전달로 이동
    $('.prev_btn').addEventListener('click', () =>{
        changeMonth(-1);
    });

    // // 다음달로 이동
    $('.next_btn').addEventListener('click', () =>{
        changeMonth(1);
    });
}
