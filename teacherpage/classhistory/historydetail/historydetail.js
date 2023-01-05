import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import {classAccept, classCancel, sendPaymentLink} from "./clickbtnevent.js";
import { getMyId} from "../../../utils/getMyid.js";
import {setReview, setNonReview} from "/components/reviewAndFeedback/review.js";
import { setFeedback, setNonFeedback } from "../../../components/reviewAndFeedback/feedback.js";


// 수업 id랑 수업 신청한 유저 id 가져오기
// let {class_id, user_id} = JSON.parse(localStorage.getItem("classId"));

// 소켓 연결
export const socket = io.connect("ws://3.39.249.46:8080/webChatting");
socket.on("connect", () => {
    socket.emit('enter_web_chat', getCookie(cookieName));
 });

socket.on('receive_text_msg', (res) => {
  
});

// clickbtnevent에서 사용하기 위해 수업id, 수업등록id, 학생id, 강사id, 강사이름(내이름) 결제링크 array export
export let classId;
export let class_register_id = class_id;
export const student_id = user_id;
export const teacher_id = await getMyId(getCookie(cookieName));
export let teacher_name;
export let payment_array = new Array();


// 후기/피드백 관련 변수
let student_name;
let student_img;
let my_name;
let my_img;
let reviewCheck_teacher;
let reviewCheck_student;
let reviewText_student;
let reviewDate_student;
let reviewStar_student;
let reviewDate_teacher;
let reviewText_teacher;

// 수업 신청한 학생과 관련된 데이터 가져와서 대입
getUserInfo();

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
    
    console.log(response);   
    
    const result = response.result[0];

    student_name = result.user_name;
    student_img = result.user_img;    

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

    // 내 정보 가져오기
    const my_id = await getMyId(getCookie(cookieName));
    getMyInfo(my_id);
}

function setUserLanguage(value, $user_language) {

    value = JSON.parse(value);        
               
        for (let key in value) {

          let language_list = document.createElement('span');          
          language_list.innerHTML = ['<span class = "mr-2 text-xs text-gray-500">'+key+' : '+value[key]+'</span>'].join("");
          $user_language.appendChild(language_list);              
        }               
}

async function getMyInfo(my_id) {

    const body = {
        
        kind: "udetail",
        user_id: my_id
    };
    const res = await fetch('/restapi/userinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  
      
    const result = response.result[0];
    my_name = result.user_name;
    my_img = result.user_img;       

    // 수업과 관련된 데이터 가져와서 대입
    getClassDetail();
}

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

    console.log(response);

    
    if (response.success == "yes") {

        
        const result = response.result[0];

        classId = result.class_id;
        teacher_name = response.user_name;
        payment_array = result.payment_link;
        class_register_id = result.class_register_id;

        const class_name = result.class_name;
        const class_price = result.class_price;
        const class_register_method = result.class_register_method;
        const class_time = result.class_time;
        const class_date = result.teacher_schedule_list;
        const student_timezone = result.student_timezone;
        const teacher_timezone = result.teacher_timezone;
        const class_status = result.class_register_status;
        const class_review = result.class_register_review;
        const class_register_memo = result.class_register_memo;

        $('.class_name').innerText = class_name;
        $('.class_price').innerText = class_price;        
        $('.utc_difference').innerText = teacher_timezone - student_timezone;
        $('.student_utc').innerText = student_timezone+":00";
        $('.class_memo').innerText = class_register_memo;
        setClassRegisterMethod(class_register_method);
        setClassTimeAndDate(class_time, class_date);
        setClassRegisterStatus(class_status);
        

        // 후기/피드백 관련 변수
        reviewCheck_teacher = result.class_register_review;
        reviewCheck_student = result.class_register_review_student;
        reviewText_student = result.student_review;
        reviewDate_student = result.student_review_date;
        reviewStar_student = result.student_review_star;
        reviewText_teacher = result.teacher_review;
        reviewDate_teacher = result.teacher_review_date;

        // 학생의 수업 리뷰가 있을 경우에만 표시
        const review_div = $('.review_div');
        if (reviewCheck_student != 0) {            
            setReview(review_div, student_name, student_img, reviewText_student, reviewStar_student, reviewDate_student);
        }
        else {
            setNonReview(review_div, 'teacher');
        }
        // 강사 피드백이 있을 경우에만 표시
        const feedback_div = $('.feedback_div');
        if (reviewCheck_teacher != 0) {
            setFeedback(feedback_div, my_name, my_img, reviewText_teacher, reviewDate_teacher);
        }
        else {

            setNonFeedback(feedback_div, 'teacher');
        }
        // 강사 후기가 없으면서 완료된 수업일 때만 수업 피드백 버튼 보이게 처리
        if (class_status == 3 && reviewCheck_teacher == 0) {

            $('.feedback_btn').classList.remove('hidden');
        }
    }
    else {
        console.log("통신 실패")
    }    
}

// 피드백 전송 함수 (서버에 등록 완료되면 화면에 표시되는 것까지)
async function sendFeedback() {

    const body = {

        token: getCookie(cookieName),
        kind: "teacher",
        class_register_id: class_register_id, 
        teacher_review : $('.feedback_text').value,
        student_review : null,
        student_review_star : null
    };
    
    const res = await fetch('/restapi/addreview.php', {
        method: 'POST',   
        headers: {
            'Content-Type': 'application/json;'
          },
        body: JSON.stringify(body)    
    }); 
    
    // 받아온 json 파싱하고 array 추출
    const response = await res.json();  

    if (response.success = 'yes') {

        console.log(response);

        alert("피드백이 등록되었습니다.");

        // 모달창 내리기
        $('.addFedbackModal').classList.add('hidden');

        // 수업 후기 표시
        const review_text = response.teacher_review;        
        const review_date = response.teacher_review_date;             
       
        const feedback_div = $('.feedback_div');
        setFeedback(feedback_div, my_name, my_img, review_text, review_date);

        $('.feedback_btn').classList.add('hidden');
    }
    
}
$('.sendFedbackBtn').addEventListener('click', () => {
    
    sendFeedback()
})

function showModal() {
    // 수업 확정 모달창 띄우기
    $('.addFedbackModal').classList.remove('hidden');
}

// 취소 버튼 클릭할 때 모달창 내리기
const closeModel = () => {

    $('.addFedbackModal').classList.add('hidden');
}
for (const cancel of $_all('.feedbackModalCloseBtn')) {

    cancel.addEventListener('click', closeModel)
    $('.feedback_text').value = '';
}

// 피드백 등록 모달창 띄우기
$('.feedback_btn').addEventListener('click', () => {
    showModal();
})

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

const tool_image = $('.tool_image');
const tool_text = $('.tool_text');
function setClassRegisterMethod(class_register_method) {

    if (class_register_method == 0) {
        tool_image.src = "/images_forHS/logo.png";
        tool_text.innerText = "HangulSquare Metaverse"
    }
}

const class_approve_btn = $('.class_approve_btn');
const class_cancel_btn = $('.class_cancel_btn');
const send_link_btn = $('.send_link_btn');
function setClassRegisterStatus(status) {

    if (status == "0") {
        status = "승인 대기"

    } else if (status == "1") {
        status = "미완료"

        // 예약 승인, 결제 요청 버튼 비활성화
        class_approve_btn.setAttribute("class", "class_approve_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        send_link_btn.setAttribute("class", "send_link_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        class_approve_btn.disabled = true;    
        send_link_btn.disabled = true;

    } else if (status == "2") {
        status = "취소됨"

        // 예약 승인/취소, 결제요청 버튼 비활성화
        class_approve_btn.setAttribute("class", "class_approve_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        class_cancel_btn.setAttribute("class", "class_cancel_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        send_link_btn.setAttribute("class", "send_link_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        class_approve_btn.disabled = true;        
        class_cancel_btn.disabled = true;
        send_link_btn.disabled = true;

    } else if (status == "3") {
        status = "완료됨"
        
        // 예약 승인/취소, 결제요청 버튼 비활성화
        class_approve_btn.setAttribute("class", "class_approve_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        class_cancel_btn.setAttribute("class", "class_cancel_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        send_link_btn.setAttribute("class", "send_link_btn px-2 py-1 bg-gray-100 rounded-lg text-gray-300 mx-2 my-2");
        class_approve_btn.disabled = true;        
        class_cancel_btn.disabled = true;
        send_link_btn.disabled = true;
    }
    $('.class_status').innerText = status;


}


// 예약 승인 버튼 클릭
class_approve_btn.addEventListener('click', classAccept)
// // 예약 취소 버튼 클릭
class_cancel_btn.addEventListener('click', classCancel)
// // 페이팔 링크 전송 버튼 클릭
send_link_btn.addEventListener('click', sendPaymentLink)

