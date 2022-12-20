import { $ } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url} from "/commenJS/cookie_modules.js";


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