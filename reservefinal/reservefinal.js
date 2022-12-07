// 로컬 스토리지에서 예약 관련 정보 가져오기
const {clName, clTime, clSchedule, clTool, clPrice, tusid} = JSON.parse(localStorage.getItem("reserveInfoAll"));

// 강사 이름, 강사 이미지 받아오기
getReserveinfo();

console.log("test :"+dayjs(1669829400000).format('YYYY-MM-DD'));

// 화면에 넣어주어야 할 요소들 초기화 (수업 날짜는 동적으로 추가해야 하므로 나중에 반복문에서 초기화)
const t_img = document.getElementById("timg");
const t_name = document.getElementById("tname");
const cl_name = document.getElementById("clname");
const cl_tool = document.getElementById("cltool");
const cl_time = document.getElementById("cltime");
const cl_number = document.getElementById("clnumber");
const cl_price = document.getElementById("clprice");

async function getReserveinfo() {

    const body = {
       
        utc: 9, // 임의의 수 넣기
        tusid: tusid,
        timg: 1,
        tname: 1,
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
    const tName = result.U_Name;
    const tImg = result.U_D_Img;

    // 강사 이미지,이름, 수업 이름, 수업 도구, 수업가격 세팅
    t_img.src = "../editprofile/image/"+tImg;
    t_name.innerHTML = tName;
    cl_name.innerHTML = clName;
    cl_tool.innerHTML = clTool;
    cl_price.innerHTML = clPrice;

    // 수업 시간 및 횟수 표시
    const cl_time_array = clTime.split(' - ');
    cl_time.innerHTML = cl_time_array[0];
    cl_number.innerHTML = cl_time_array[1];

    // 수업 날짜 표시

    // 받아온 일정 배열로 변환
    const schedule_array = clSchedule.split("_");

    // 배열 갯수만큼 세팅
    for(let i = 0; i < schedule_array.length; i++) {

        const timestamp = schedule_array[i];

        const theDay = dayjs(timestamp).format('YYYY-MM-DD');

        console.log(timestamp);

    }

}


