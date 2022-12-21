import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

export const model = (async function() {            
        
    const tokenValue = getCookie(cookieName);

    // 유저id, 유저의 타임존, 스케줄 리스트 선언
    let user_id;
    let timezone;
    let schedule_list;

    // 현재 날짜 객체
    let thisMonth;
    // 달력에서 표기하는 연,월,일
    let currentYear;
    let currentMonth;
    let currentDate;    


    // 현재 달(캘린더에 표시되는 달) 기준 이전 달의 마지막날짜와 그 요일 구하기
    let startDay;    
    let prevDate;
    let prevDay;

    // 현재 달(캘린더에 표시되는 달) 기준 이번 달의 마지막날 날짜와 요일 구하기
    let endDay;
    let nextDate;
    let nextDay;

    // 토큰 활용해서 해당 유저 id 가져오기
    async function get_utc() {               
        
        const body = {
    
            token: tokenValue,
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
    
          if (success == "yes") {                
            
            // 유저 id, 타임존 대입
            user_id = response.user_id;       
            timezone = response.user_timezone;
            
            // 받아온 타임존으로 현재 날짜 세팅
            initCalendar(timezone);
          }
          else {
            console.log("타임존 못불러옴")
          }          
    }

    // 수업 정보 가져오기
    const getSchedulesList = async function() {

        const body = {

            token: tokenValue,
            kind: "clist",
            class_reserve_check: "all", 
        };
        
        const res = await fetch('../restapi/classinfo.php', {
            method: 'POST',   
            headers: {
                'Content-Type': 'application/json;'
              },
            body: JSON.stringify(body)    
        });  
                
        const response = await res.json();          
        schedule_list = response.result;

        console.log(schedule_list);
    }      

    // 오늘 날짜 기준으로 날짜 세팅
    const initCalendar = function(timezone) {
      
            
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
      thisMonth = new Date(now.getFullYear(), now.getMonth(), now.getDate());
      
      currentYear = thisMonth.getFullYear(); // 달력에서 표기하는 연
      currentMonth = thisMonth.getMonth(); // 달력에서 표기하는 월
      currentDate = thisMonth.getDate(); // 달력에서 표기하는 일

      
      // 날짜 파싱
      parseDate(thisMonth);            

    }

    // 날짜 파싱
    const parseDate = function (thisMonth) {

      currentYear = thisMonth.getFullYear();
      currentMonth = thisMonth.getMonth();
      currentDate = thisMonth.getDate();
          
      // 현재 달(캘린더에 표시되는 달) 기준 이전 달의 마지막날짜와 그 요일 구하기
      startDay = new Date(currentYear, currentMonth, 0);    
      prevDate = startDay.getDate();
      prevDay = startDay.getDay();
  
      // 현재 달(캘린더에 표시되는 달) 기준 이번 달의 마지막날 날짜와 요일 구하기
      endDay = new Date(currentYear, currentMonth + 1, 0);
      nextDate = endDay.getDate();
      nextDay = endDay.getDay();
    }

    return {
      // 유저id, 유저의 타임존, 스케줄 리스트 선언
      user_id: user_id,
      timezone: timezone,
      schedule_list: schedule_list,

      // 현재 날짜 객체
      thisMonth: thisMonth,
      // 달력에서 표기하는 연,월,일
      currentYear: currentYear,
      currentMonth: currentMonth,
      currentDate: currentDate,

      // 현재 달(캘린더에 표시되는 달) 기준 이전 달의 마지막날짜와 그 요일 구하기
      startDay: startDay,  
      prevDate: prevDate,
      prevDay: prevDay,

      // 현재 달(캘린더에 표시되는 달) 기준 이번 달의 마지막날 날짜와 요일 구하기
      endDay: endDay,
      nextDate: nextDate,
      nextDay: nextDay,

      get_utc: get_utc,
      getSchedulesList: getSchedulesList,
      parseDate: parseDate,
    };
    
    // 해당 유저의 id 대입
    // get_utc();
    // // 스케줄 가져와서 대입
    // getSchedulesList();

    // var list = [];
    
    // var Item = function(content) {
    //     this.content = content;
    // };
    // Item.prototype.finished = false;
    
    // var addItem = function(content) {
    //     var item = new Item(content);
    //     list.push(item);
    // }
    
    // var removeItem = function(item_index) {
    //     list.splice(item_index, 1);
    // }
    
    // var checkItem = function(item_index) {
    //     var current_item = list[item_index];
    //     current_item.finished = !current_item.finished;
    // }
    
    // return {
    //     list: list,
    //     Item: Item,
    //     addItem: addItem,
    //     removeItem: removeItem,
    //     checkItem: checkItem
    // };
});

