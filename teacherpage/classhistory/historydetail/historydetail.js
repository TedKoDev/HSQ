import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";

// 수업 id랑 수업 신청한 유저 id 가져오기
const {id} = JSON.parse(localStorage.getItem("classId"));
let class_id = id;

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
    
    console.log(response);

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
    }
    else {
        console.log("통신 실패")
    }

    
}

async function getUserInfo() {


}

