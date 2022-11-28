// 오늘부터 7일후까지 요일, 날짜 가져와서 일정에 출력

getDate("header_s");

function getDate(header_date) {

    let header_s = document.getElementById(header_date);

    let now = new Date();
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

setschedule("_l");
// 일정 등록에 세팅
function setschedule(type) {

    let test_string = "54_62_88";

    let test_array = test_string.split('_');

    // 일정 체크박스 개수만큼 반복문 돌리기
    for (let i = 1; i <= 336; i++ ) {

        // 변환한 array의 개수만큼 반복문 돌리기
        for (let j = 0; j < test_array.length; j++) {
            
            if (i == test_array[j]) {

                let label = document.getElementById(i + type);
                // 모달창에 있는 값들은 check로 표시해놓기 (메인 화면은 그냥 보여주는 용도이므로 굳이 check로 표시할 필요 없음)
                let input = document.getElementById(i+"_m");

                input.checked = true;
                label.style.backgroundColor = 'red';
            }
           
        }
    }

}
