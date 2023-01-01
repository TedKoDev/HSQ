import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";
import { getMyUtc } from "../../utils/getMyUtc.js";

// 요일 표시용 array
const week = new Array('일', '월', '화', '수', '목', '금', '토');

// 로그인 되어 있는지 여부에 따라 현재 날짜 및 시간 다르게 
let now;
if (getCookie(cookieName) == "") {

    now = dayjs();    
}
else {

    const timezone = await getMyUtc(getCookie(cookieName));
    
    const date = new Date();    
    const utc = -(date.getTimezoneOffset() / 60);

    now = dayjs(date).subtract(utc, 'hour');
    now = dayjs(now).add(timezone, 'hour');
}

// 받아온 날짜 ~ 7일후까지의 날짜 및 요일 세팅 (화면에 표시 + value 값 세팅)
setDateAndDay(now);
function setDateAndDay(now) {
        
    let start_date = dayjs(now).set('hour', 0).set('minute', 0).set('second', 0);    
    
    // 최상단에 오늘 날짜 ~ 7일 후 날짜 표시
    $('.date_start').innerText = dayjs(start_date).format('YYYY년 MM월 DD일');
    $('.date_end').innerText = dayjs(start_date).add(7, "day").format('YYYY년 MM월 DD일');
    
    for (let i = 1; i <= 7; i++) {
        
        let date = start_date.get("date");
        
        // 날짜 체크박스에 날짜와 요일 표시
        const day_span = $("#day_"+i);
        day_span.innerText = week[start_date.get("day")];
        const date_span = $("#date_"+i);
        console.log("date : "+date);
        date_span.innerText = date;

        // 날짜 체크박스에 value값 세팅
        
        start_date = dayjs(start_date).add(1, 'day');        
        
    }
}