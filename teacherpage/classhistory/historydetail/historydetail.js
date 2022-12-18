import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";


// 수업 id랑 수업 신청한 유저 id 가져오기
let {class_id, user_id} = JSON.parse(localStorage.getItem("classId"));

console.log("user_id : "+user_id);

// 수업과 관련된 데이터 가져와서 대입
getClassDetail();
// 수업 신청한 학생과 관련된 데이터 가져와서 대입
getUserInfo();

async function getClassDetail() {

    const body = {

        token: getCookie(cookieName),
        kind: "tcdetail",
        class_register_id: class_id
    };
    const res = await fetch('/restapi/classinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();    
    
    // console.log(response);

    if (response.success == "yes") {

        const result = response.result[0];

        const class_name = result.class_name;
        const class_price = result.class_price;
        const class_register_method = result.class_register_method;
        const class_time = result.class_time;
        const class_date = result.teacher_schedule_list;
        const student_timezone = result.student_timezone;
        const teacher_timezone = result.teacher_timezone;
        const class_status = result.class_register_status;
        const class_review = result.class_register_review;

        $('.class_name').innerText = class_name;
        $('.class_price').innerText = class_price;        
        $('.utc_difference').innerText = teacher_timezone - student_timezone;
        $('.student_utc').innerText = student_timezone+":00";
        setClassRegisterMethod(class_register_method);
        setClassTimeAndDate(class_time, class_date);
        setClassRegisterStatus(class_status);
        setClassReview(class_review);
    }
    else {
        console.log("통신 실패")
    }

    
}


async function getUserInfo() {

    const body = {
        
        kind: "udetail",
        user_id: user_id
    };
    const res = await fetch('/restapi/userinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();    

    console.log(response.result[0]);

    const result = response.result[0];

    const user_name = result.user_name;
    const user_language = result.user_language;
    const user_korean = result.user_korean;
    const user_residence = result.user_residence;
    const user_img = result.user_img;

    $('.user_name').innerText = user_name;
    $('.user_residence').innerText = user_residence;
    $('.user_korean').innerText = user_korean;
    $('.user_img').src = s3_url + "Profile_Image/" + user_img;
    setUserLanguage(user_language, $('.user_language'));
}

function setUserLanguage(value, $user_language) {

    value = JSON.parse(value);        
               
        for (let key in value) {

          let language_list = document.createElement('span');          
          language_list.innerHTML = ['<span class = "mr-2 text-xs text-gray-500">'+key+' : '+value[key]+'</span>'].join("");
          $user_language.appendChild(language_list);              
        }               
}

const week = new Array('일', '월', '화', '수', '목', '금', '토');
function setClassTimeAndDate(class_time, class_date) {

    // 월,일, 요일 표시
    // 수업일 int로 변환
    const dateToint = parseInt(class_date);
    // 수업시간 int로 변환
    const timeToint = parseInt(class_time);
    // 수업일에서 수업시간 빼기
    const date = dayjs(dateToint).subtract(timeToint, "m");
    // 요일 파싱
    const day = week[date.day()];           
    // 월,일, 요일 파싱            
    const date_format = date.format('YYYY년 MM월 DD일 ('+day+')');
    
    $('.class_date').innerText = date_format;

    // 수업 시간 표시  
    const firstDateParsing = date.format('hh:mm');
    const lastDateParsing = dayjs(dateToint).format('hh:mm');
    $('.class_time').innerText = firstDateParsing+" / "+lastDateParsing;
}

function setClassRegisterMethod(class_register_method) {

    if (class_register_method == 0) {
        $('.tool_image').src = "/images_forHS/logo.png";
        $('.tool_text').innerText = "HangulSquare Metaverse"
    }
}

function setClassRegisterStatus(status) {

    if (status == "0") {
        status = "승인 대기"
    } else if (status == "1") {
        status = "미완료"
    } else if (status == "2") {
        status = "취소됨"
    } else if (status == "3") {
        status = "완료됨"
        
        // 예약 승인/취소 버튼 비활성화
        $('.class_approve_btn').setAttribute("class", "class_approve_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        $('.class_cancel_btn').setAttribute("class", "class_cancel_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        $('.class_approve_btn').disabled = true;        
        $('.class_cancel_btn').disabled = true;
    }
    $('.class_status').innerText = status;


}

function setClassReview(class_review) {

}

async function classAccept() {    
        
    console.log("class_id : "+class_id);
    
    const body = {
        
        token: getCookie(cookieName),
        kind: "teacher",
        class_register_id: class_id,
        class_register_status: 1
    };
    const res = await fetch('/restapi/classaccept.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  

    console.log(response);
}


$('.class_approve_btn').addEventListener('click', classAccept)

