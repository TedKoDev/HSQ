import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";
import { getMyUtc } from "../../utils/getMyUtc.js";

// 요일 표시용 array
const week = new Array('일', '월', '화', '수', '목', '금', '토');

// 클릭한 날짜 저장하는 변수 (이전/다음 버튼 눌러서 날짜 변경되었을 때 확인해주는 용도)
let now_click_date;

// 선택한 필터가 표시되는 div
const filterItem_div = $('.filterItemList');

// 강의 시간 버튼
const classTime_btn = $('#classTime_btn');

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
    
    const year = dayjs(now).get("year");
    const month = dayjs(now).get("month")+1;
    const date = dayjs(now).get("date");

    const now_date = year+"-"+month+'-'+date;

    let start_date = dayjs(now_date);
    
    // 최상단에 오늘 날짜 ~ 7일 후 날짜 표시
    $('.date_start').innerText = dayjs(start_date).format('YYYY년 MM월 DD일');
    $('.date_end').innerText = dayjs(start_date).add(7, "day").format('YYYY년 MM월 DD일');
    
    for (let i = 1; i <= 7; i++) {
        
        let date = start_date.get("date");
        
        // 날짜 체크박스에 날짜와 요일 표시
        const day_span = $("#day_"+i);
        day_span.innerText = week[start_date.get("day")];
        const date_span = $("#date_"+i);        
        date_span.innerText = date;

        // 날짜 체크박스에 value값 세팅
        const checkbox = $("#dateBtn_"+i);       
        checkbox.value = dayjs(start_date).valueOf();

        // 해당 체크박스의 label 가져온 뒤 id를 value_l 형태로 대입
        const test = document.querySelector('label[for="dateBtn_'+i+'"]');
        test.setAttribute("id", checkbox.value+"_l");
        
        
        // 날짜 하루 증가
        start_date = dayjs(start_date).add(1, 'day');        
        
    }

    // 7일 중에 날짜 array와 일치하는 value가 있을 경우 색깔 칠하고 체크 해놓기. 아닌건 색깔 원래대로하고 체크 해제
    checkDateClick();
}

// 이전/다음 버튼 클릭 시 이벤트
function changeDate(check) {

    if (check == 'prev') {
        
        now = dayjs(now).subtract(7, "day");
    }
    else {
        now = dayjs(now).add(7, "day");
    }
    setDateAndDay(now);
}

// 강의 시간 버튼 클릭했을 때 클릭한 날짜 체크해서 있을 경우 색깔 칠하고 아닌건 원래대로
classTime_btn.addEventListener('click', () => {

    checkDateClick()
})

// 클릭한 날짜가 있으면 색깔 칠하고 체크, 아닌건 원래대로 체크 해제
function checkDateClick() {
        
    for (let i = 1; i <= 7; i++) {

        const checkbox = $('#dateBtn_'+i);
        const label = document.querySelector('label[for="dateBtn_'+i+'"]');
        
        if ($("#dateBtn_"+i).value == now_click_date) {           
            
            label.classList.remove('hover:bg-gray-300');
            label.classList.remove('text-gray-800');
            label.classList.add('bg-gray-700');
            label.classList.add('text-white');
            checkbox.checked = true;
        }
        else {
            
            label.classList.add('hover:bg-gray-300');
            label.classList.add('text-gray-800');
            label.classList.add('bg-white');
            label.classList.remove('bg-gray-700');
            label.classList.remove('text-white');
            checkbox.checked = false;
        }
    }
}

$('.prev_btn').addEventListener('click', () => {

    changeDate('prev');
})
$('.next_btn').addEventListener('click', () => {

    changeDate('next');
})


// 강의 시간 모달창의 체크박스 클릭 리스너
const checkboxes_date = $_all('.filter_checkbox_date');
for (const box of checkboxes_date) {

    box.addEventListener('click', (e) => {       
                    
        clickInTimeModal(e);
    })
}

// 강의 시간 모달창에서의 함수 (색상 변화)
function clickInTimeModal(e) {

    updateFilterItem(e);
    
    for (const box of checkboxes_date) {
                
        const label = document.querySelector('label[for="'+box.id+'"]');
        
       if (box.checked == true) {

        label.classList.remove('hover:bg-gray-300');
        label.classList.remove('text-gray-800');
        label.classList.add('bg-gray-700');
        label.classList.add('text-white');
        
       }
       else {
        
        label.classList.add('hover:bg-gray-300');
        label.classList.add('text-gray-800');
        label.classList.add('bg-white');
        label.classList.remove('bg-gray-700');
        label.classList.remove('text-white');        
        
       }
       // 색상만 바꾸고 다시 false로 놓기 (이전/다음 버튼 눌렀을 때 체크 표시 여부는 checkDateClick()에서 판단함)
       box.checked = false;
    }  
    
}

// 모달창에서 클릭 시 필터 아이템 리스트 업데이트 
function updateFilterItem(e) {       

    // 필터 아이템 리스트에서 날짜 필터 모두 초기화
    const date_div_list = $_all('.date_item');    
    for (const date_item of date_div_list) {

        date_item.remove();
    }    

    // 날짜 저장하는 변수 초기화
    now_click_date = null;

    const filterValue = e.target.value;
    if (e.target.checked == true) {
       
        const text = dayjs(parseInt(filterValue)).format('MM월 DD일');
        
        const new_btn = document.createElement('div');
        new_btn.innerHTML = `
            <div id = "${filterValue}_div" value = ${filterValue} class = "date_item flex items-center text-xs px-1 py-2 text-center  bg-gray-300 hover:bg-gray-400 rounded-2xl mx-1">
                <span class = "mr-1">${text}</span>
                <button value = "${filterValue}" class="filter_time_btn text-gray-800 font-medium inline-flex items-center" type="button">
                    <svg name = "deleteIcon" class= "deleteIcon w-4 h-4 bg-gray-500 rounded-full text-white border-white" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/></svg>
                </button>                
            </div>
            `;              
                            
        filterItem_div.append(new_btn);  
    
        // 날짜 저장하는 변수에 대입
        now_click_date = filterValue;

        console.log(document.getElementById(filterValue+"_div"));
    }
    else {

        // console.log("filterValue : "+filterValue);
        // console.log("delete_div : "+delete_div);
        // const delete_div = document.getElementById(filterValue+"_div");
        // delete_div.remove();
    }
    
     
}

// x 아이콘 클릭 시 만일 수업 시간일 경우에는 날짜 저장하는 변수 초기화 처리
filterItem_div.addEventListener('click', (e) => {

    const target = e.target.closest("button");
    if ((target instanceof HTMLButtonElement)) {
                      
        if (target.value.length == 13) {
            
            now_click_date = null;
            
        }
    } 
       
})

