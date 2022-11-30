// 유저 id 받아온 후 로컬 스토리지에서 삭제
// const {id} = JSON.parse(localStorage.getItem("user_id"));
// localStorage.removeItem("user_id");

// let U_id = id;
// console.log(U_id);


// 수업 가능 시간 부분에 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력

getDate("header_s");

function getDate(header_date) {

    let header_s = document.getElementById(header_date);

    // 세팅하기 전에 일단 초기화
    while(header_s.firstChild)  {
        header_s.removeChild(header_s.firstChild);
      }

    let now = new Date();

    console.log("now : "+now);
    let time = now.getTime();
    let todayDate = now.getDate();

    let week = new Array('일', '월', '화', '수', '목', '금', '토');

    time = time - (1000 * 60 * 60 * 24)
    for (let i = 0; i < 8; i++) {

        if (i == 0) {

            let utc_show = document.createElement("div");
            utc_show.innerHTML = [
                '<div class = "flex flex-col w-20">', '<div class = "mx-auto"></div>',            
                '</div>'
            ].join("");

            header_s.appendChild(utc_show);

        } else {

            time = time + (1000 * 60 * 60 * 24);

            let new_Date = new Date(time);

            let date = new_Date.getDate();

            let day_array = new_Date.getDay();
            let day = week[day_array];
            // console.log(date);
            // console.log(day);

            let date_day = document.createElement("div");
            date_day.innerHTML = [
                '<div class = "flex flex-col w-20">', '<div class = "mx-auto">' + day +
                        '</div>',
                '<div class = "mx-auto">' + date + '</div>',
                '</div>'
            ].join("");

            header_s.appendChild(date_day);        
        }
    }
}