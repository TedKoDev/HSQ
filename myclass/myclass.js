import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import {getMyId} from "/utils/getMyid.js"

let class_register_id;

const addReviewBtn = $('.review_btn');
const ReviewModal = $('.addReviewModal');
const closeBtn = $_all('.reviewModalCloseBtn');
const sendBtn = $('.sendReviewBtn');
const reviewText = $('.review_text');

const addStar_span = document.querySelector('.addStar_modal');
const addStar_value = document.querySelector('.addStar_modal_value');



const body = {

    token: getCookie(cookieName),
    kind: "cdetail",
    class_reserve_check: "detail", 
    class_register_id: class_id,
};

const res = await fetch('/restapi/classinfo.php', {
    method: 'POST',   
    headers: {
        'Content-Type': 'application/json;'
      },
    body: JSON.stringify(body)    
}); 

// 받아온 json 파싱하고 array 추출
const response = await res.json();  

// 서버에서 가져온 데이터 화면에 표시
const result = response[0];

console.log(response);
// 강사 id 대입

if (response.length != 0) {

    U_id = result.user_id_teacher;
    class_register_id = result.class_register_id;
    const class_name = result.class_name;
    const class_price = result.class_price;
    const class_date = result.class_start_time;
    const class_time = result.class_time;
    const class_description = result.class_description;
    const class_status = result.class_register_status;
    const class_type = result.class_type;
    
    const teacher_name = result.teacher_name;
    const teacher_img = result.teacher_img;
    const teacher_special = result.teacher_special;
    // 후기/피드백 관련 변수
    const reviewCheck_teacher = result.class_register_review;
    const reviewCheck_student = result.class_register_review_student;
    const reviewText_student = result.student_review;
    const reviewDate_student = result.student_review_date;
    const reviewStar_student = result.student_review_star;
    const reviewText_teacher = result.teacher_review;
    const reviewDate_teacher = result.teacher_review_date;

    // 내 이름이랑 이미지 가져오기 (리뷰 작성용)
    let my_name;
    let my_img;
    const my_id = await getMyId(getCookie(cookieName));
    getmyInfo();
    async function getmyInfo() {

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
        
        console.log(response);
        
        const result = response.result[0];
        my_name = result.user_name;    
        my_img = result.user_img;

        // 수업 후기 있을 경우 리뷰 표시
        const review_div = $('.review_div');
        if (reviewCheck_student == 1) {            
            setReview(review_div, my_name, my_img, reviewText_student, reviewStar_student, reviewDate_student);        
        }
        // 없을 경우 등록된 리뷰가 없을 때 뷰 표시
        else {
            setNonReview(review_div);
        }
    }   

    // 수업 정보 세팅
    let week = new Array('일', '월', '화', '수', '목', '금', '토');
    const date = dayjs(parseInt(class_date));
    const day = week[date.day()];          

    const class_time_between = dayjs(parseInt(class_date)).subtract(parseInt(class_time), "minute").format('hh:mm')+" / "+dayjs(parseInt(class_date)).format('hh:mm');

    $('.class_name').innerText = class_name;
    $('.class_time').innerText = class_time;
    $('.class_desc').innerText = class_description;
    $('.class_price').innerText = class_price;
    $('.class_date').innerText = dayjs(parseInt(class_date)).format('YYYY년 MM월 DD일 ('+day+')');
    $('.class_time_between').innerText = class_time_between;     
    $('.class_status').innerText = status(class_status);
    $('.teacher_name').innerText = teacher_name;
    $('.teacher_image').src = s3_url+"Profile_Image/"+teacher_img;
    $('.teacher_special').innerText = checkSpecial(teacher_special);
    $('.class_type').innerText = class_type.replace(/,/gi, ' ');  


    // 완료된 수업이면서 학생의 수업 후기가 없을 경우에만 수업후기 등록버튼 보이게 처리
    if (class_status == 3 && reviewCheck_student == 0) {

        addReviewBtn.classList.remove('hidden');
    }
}




function status(class_status) {

    let status_string;
    if (class_status == "0") {
        status_string = "승인 대기중";
    }
    else if (class_status == "1") {
        status_string = "수업 예정";
    }
    else if (class_status == "2") {
        status_string = "취소됨";
    }
    else if (class_status == "3") {
        status_string = "완료됨";
    }

    console.log(status_string);

    return status_string;
}

function checkSpecial(teacher_special) {

    let special_string;
    if (teacher_special == "default") {
        special_string = '커뮤니티 튜터'
    }
    else {
        special_string = '전문 강사';
    }

    return special_string;
}



function showModal() {

    // 수업 확정 모달창 띄우기
    ReviewModal.classList.remove('hidden');
}

// 취소 버튼 클릭할 때 모달창 내리기
const closeModel = () => {

    ReviewModal.classList.add('hidden');
}
for (const cancel of closeBtn) {

    cancel.addEventListener('click', closeModel)
}

// 리뷰 전송 함수 (서버에 등록 완료되면 화면에 표시되는 것까지)

async function sendReview() {

    const body = {

        token: getCookie(cookieName),
        kind: "student",
        class_register_id: class_register_id, 
        teacher_review : null,
        student_review : reviewText.value,
        student_review_star : addStar_value.value
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

        alert("후기가 등록되었습니다.");

        // 모달창 내리기
        ReviewModal.classList.add('hidden');

        // 수업 후기 표시

        review_text = response.student_review;
        review_star = response.student_review_star;
        review_date = response.student_review_date;       

        const review_div = $('.review_div');
        setReview(review_div, my_name, my_img, review_text, review_star, review_date);


    }
    
}
sendBtn.addEventListener('click', () => {
    
    sendReview()
})


// 모달창 띄우기
addReviewBtn.addEventListener('click', () => {
    showModal();
})

// 수업 리뷰 컴포넌트
function setReview($div, name, img, review_text, review_star, review_date) {

    $div.innerHTML = `
    <div class="flex w-full bg-gray-100 rounded-lg py-2">
        <div class="flex items-center pl-2">
            <img class="tool_image w-5 h-5 rounded-full" src="${s3_url}Profile_Image/${img}"></img>
            <div class="flex flex-col ml-2">
                <span class="user_name text-xs text-gray-800">${name}</span>
                <span class="review_date text-xs text-gray-500">${dayjs(review_date).format('YYYY년 MM월 DD일')}</span>
                <div></div>
                <div class="flex flex-col"></div>
            </div>
            <hr class="bg-gray-300 border border-1">
        </div>
        <div class="flex flex-col ml-4 px-1">   
            <div class = "">      
                <span class="relative text-gray-400 text-xl">
                    ★★★★★
                    <span class = "addStar text-xl w-0 absolute left-0 text-orange-500 overflow-hidden pointer-events-none">★★★★★</span>
                    <input class = "addStar_value w-full h-full absolute left-0 opacity-0 cursor-pointer" type="range" value="${review_star}" step="1" min="0" max="10">
                </span>
            </div>                     
            <span class = "text-xs">${review_text}</span>
        </div>
    </div>`;

    $('.addStar').style.width = `${$('.addStar_value').value * 10}%`;
    
}

function setNonReview($div) {

    $div.innerHTML = `
        <div class="flex flex-col justify-center w-full bg-gray-100 rounded-lg py-2 mx-auto">
            <span class = "mx-auto text-sm text-gray-800 mb-1">등록된 후기가 없습니다</span>   
            <span class = "mx-auto text-xs text-gray-700">수강이 완료된 강의만 후기 작성이 가능합니다.</span>                 
        </div>`;
}


// 수업 리뷰 없을 때 컴포넌트