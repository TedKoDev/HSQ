

// 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력
let header_s = document.getElementById("header_s");

let now = new Date();
let time = now.getTime();
let todayDate = now.getDate();

let week = new Array('일', '월', '화', '수', '목', '금', '토');

time = time - (1000 * 60 * 60 * 24)
for (let i = 0; i < 7; i++) {

    time = time + (1000 * 60 * 60 * 24);

    let new_Date = new Date(time);

    let date = new_Date.getDate();

    let day_array = new_Date.getDay();
    let day = week[day_array];
    console.log(date);
    console.log(day);

    let date_day = document.createElement("div");
    date_day.innerHTML = ['<div class = "flex flex-col">', '<div>'+day+'</div>', '<div>'+date+'</div>', '</div>'].join(
        ""
    );

    header_s.appendChild(date_day);
}