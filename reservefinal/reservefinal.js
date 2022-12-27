// 로컬 스토리지에서 예약 관련 정보 가져오기
const {clId, clName, clTime, clSchedule, clTool, clPrice, tusid} = JSON.parse(localStorage.getItem("reserveInfoAll"));


// 내 id 가져와서 대입
let my_id;
getMyId();
async function getMyId() {

    const body = {
       
        token : getCookie("user_info")
    };
    const res = await fetch('/utils/utc.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  
    
    my_id = response.user_id;
}

// 강사 이름, 강사 이미지 받아오기
getReserveinfo();

// 화면에 넣어주어야 할 요소들 초기화 (수업 날짜는 동적으로 추가해야 하므로 나중에 반복문에서 초기화)
const t_img = document.getElementById("timg");
const t_name = document.getElementById("tname");
const cl_name = document.getElementById("clname");
const cl_tool = document.getElementById("cltool");
const cl_time = document.getElementById("cltime");
const cl_number = document.getElementById("clnumber");
const cl_price = document.getElementById("clprice");

// 강사에게 하고 싶은 말 가져오기
const request_forTeacher = document.getElementById("memo");

// 예약 요청 위해 보내야 할 값들 전역으로 선언
let classid = clId;
let tp;
let plan = clSchedule;
let cmethod;
let memo;

async function getReserveinfo() {

    const body = {
       
        user_timezone: 9, // 임의의 수 넣기
        user_id_teacher: tusid,
        teacher_img: 1,
        teacher_name: 1,
    };
    const res = await fetch('../restapi/teacherinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();
    
    console.log(response);

    const result = response.result[0];
    const tName = result.user_name;
    const tImg = result.user_img;

    // 강사 이미지,이름, 수업 이름, 수업 도구, 수업가격 세팅
    t_img.src = s3_url+"Profile_Image/"+tImg;
    t_name.innerHTML = tName;
    cl_name.innerHTML = clName;
    cl_tool.innerHTML = clTool;
    cl_price.innerHTML = clPrice;

    // 수업 시간 및 횟수 표시
    const cl_time_array = clTime.split(' - ');
    cl_time.innerHTML = cl_time_array[0];
    cl_number.innerHTML = cl_time_array[1];

    // 전역 tp, cmethod 대입
    tp = cl_time_array[0].replace("분", "");

    // 스카이프일경우 1
    if(cl_tool == 'Skype') {
        cmethod = 1;
    }
    // 한글스퀘어 메타버스일 경우 0
    else {
        cmethod = 0;
    }

    // 수업 날짜 표시
    setSchedule(clSchedule);
    
    
}

// 수업 일정 화면에 표시
function setSchedule(clSchedule) {

    // 받아온 일정 배열로 변환
    const schedule_array = clSchedule.split("_");

    // 요일 표시용 배열 선언
    let week = new Array('일', '월', '화', '수', '목', '금', '토');

    // 요일 붙일 div 선언
    const schedule = document.getElementById("clschedule");

    // 배열 갯수만큼 세팅
    for(let i = 0; i < schedule_array.length; i++) {

        const timestamp = schedule_array[i];

        // string int형으로 변환
        const theDay = parseInt(timestamp);

        const day_forParse = dayjs(theDay);

        // 요일,월,일, 시작시간, 끝시간 추출
        const day = week[day_forParse.get("day")];
        const month = day_forParse.get("month")+1;
        const date = day_forParse.get("date");
        const startTime = day_forParse.subtract(30, "minute").format("HH:mm");
        const endTime = day_forParse.format("HH:mm");

        // 요일 표시할 div 생성
        const div = document.createElement("div");

        // 요일 대입
        div.innerHTML = [
            '<span id = "day" class = "text-xs">'+day+'</span>,', 
            '<span id = "month" class = "ml-1 text-xs">'+month+'월</span>', 
            '<span id = "date" class = "ml-1 text-xs">'+date+'일,</span>', 
            '<span id = "start_time" class = "ml-1 text-xs">'+startTime+' - </span>',
            '<span id = "end_time" class = "text-xs">'+endTime+'</span>'
        ].join("");

        schedule.appendChild(div);

    }
}


// 예약 버튼 클릭 이벤트
async function reserveDone() {
    
    const tokenvalue = getCookie("user_info");

    const memo = request_forTeacher.value;  
  
    // 수업 예약 등록하기
    const body = {

        token: tokenvalue,
        class_id: classid,
        tp: tp,
        schedule_list: plan,
        class_register_method: cmethod,
        class_register_memo: memo,
    };
    const res = await fetch('./reservefinalProcess.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });

    const response = await res.json();   
    
    console.log(response);

    if (response.success == 'yes') {

        alert("예약 완료되었습니다.");
        socket.emit('request_class', my_id, tusid, clId, response.class_register_id);

        location.replace("../myinfo/");
    }        
}
