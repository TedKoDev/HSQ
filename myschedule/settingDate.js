import { $, $_all } from "/utils/querySelector.js";
import { timezone } from "./myschedule.js";


// 1. 접속한 유저의 시간대 기준으로 오늘 날짜의 00:00:00 추출

export function calendarInit() {

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


    function renderCalender(thisMonth) {
    
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
            console.log("ss");
            date_block.classList.remove("bg-blue-200");
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

            // 오늘날짜는 색깔 다르게 처리
            if ((parseInt(now.getMonth()) == currentMonth) && (parseInt(now.getDate()) == i)) {
                date.setAttribute("class", "schedule_date text-sm text-blue-700 border-b")
                let date_block = document.getElementById(num+"_block");
                date_block.classList.add("bg-blue-200");
            }
        }
        // 다음달
        for (var i = 1; i <= (7 - nextDay == 7 ? 0 : 7 - nextDay); i++) {
            // calendar.innerHTML = calendar.innerHTML + '<div class="day next disable">' + i + '</div>'
            num = num + 1;
            let date = document.getElementById(num+"_date");
            date.setAttribute("class", "schedule_date text-sm text-gray-400")
            date.innerText = i;
        }        
       
        // 오늘 날짜 표기
        // if (today.getMonth() == currentMonth) {
        //     const todayDate = today.getDate();
        //     var currentMonthDate = document.querySelectorAll('.dates .current');
        //     currentMonthDate[todayDate -1].classList.add('today');
        // }
    }

    // 이전/다음 버튼 눌러서 캘린더 날짜 변경할 때 다시 재 렌더링하는 함수
    function changeMonth(number) {

        thisMonth = new Date(currentYear, currentMonth + number, 1);
        console.log(thisMonth);
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






