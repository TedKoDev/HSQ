// hs 메타버스, skype 버튼 초기화 (나중에 강사가 툴 등록할 때는 db에서 받아온 값 바탕으로 동적으로 초기화 필요)
const hsMeta = document.getElementById("hs_meta");
const skype = document.getElementById("skype");

// 모든 커뮤니케이션 버튼 초기화 (나중에 동적으로 받아올 때 필요)
const toolBtn = document.querySelectorAll(".toolBtn");

// 수업 시간에서 다음 버튼 초기화
let nextBtn_cct = document.querySelector(".nextBtn_cct");

// 최종적으로 선택할 커뮤니케이션 도구 변수 
let ctTool_final;

// 하단에 커뮤니케이션 도구 이름 표시
let cl_tool_b = document.querySelectorAll(".cl-communication");

// 다음 버튼 활성화 여부
checkNextbtn_cct();

// 커뮤니케이션 도구 클릭했을 때 이벤트 
// (일단은 메타버스, 스카이프 각각 이벤트 리스너 넣어주고 나중에 동적으로 추가할 때 반복문 돌리는 식으로 코드 변경해주기)
function toolClick(toolType) {

    // 클릭한 도구의 id값 가져오기
    const toolId = document.getElementById(toolType);

    // 모든 도구들의 값 기본으로 세팅
    for (const tool of toolBtn) {

        tool.setAttribute("class", "toolBtn flex w-5/12 text-sm items-center justify-center mx-auto px-2 py-2 border border-gray-300 rounded hover:shadow");
        tool.setAttribute("value", 0);
    }

    // 클릭한 도구의 색상 변경
    toolId.classList.add("bg-gray-200");
    toolId.classList.remove("bg-gray-50");

    // 클릭한 도구의 value 1로 설정
    toolId.setAttribute("value", 1);

    // 클릭한 도구의 이름을 전역변수에 대입
    ctTool_final = toolId.getAttribute("name");

    // 다음 버튼 활성화 여부
    checkNextbtn_cct();

    // 모달창 하단에 해당 도구명 표기        
    for (const name of cl_tool_b) {
        name.innerHTML = ctTool_final;
    }
}

// 다음 버튼 활성화 여부
function checkNextbtn_cct() {
    
    // 하나라도 value가 1인게 있으면 다음 버튼 활성화 하고 반복문 넘어가기
    for (const tool of toolBtn) {
        
        if (tool.getAttribute("value") == 1) {
            nextBtn_cct.disabled = false;
            
            break;
        }
        else {
            nextBtn_cct.disabled = true;
        }
    }
    

    if (nextBtn_cct.disabled == true) {
        nextBtn_cct.setAttribute(
            "class",
            "nextBtn_cl bg-gray-200 px-3 py-1 rounded text-white"
        );
    } else {
        nextBtn_cct.setAttribute(
            "class",
            "nextBtn_cl bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white"
        );
    }
}

// 모든 값들 다시 초기화
function initCmtoolModal() {

     // 모든 도구들의 값 기본으로 세팅
     for (const tool of toolBtn) {

        tool.setAttribute("class", "toolBtn flex w-5/12 text-sm items-center justify-center mx-auto px-2 py-2 border border-gray-300 rounded hover:shadow");
        tool.setAttribute("value", 0);        
    }

    // 다음 버튼 원래대로 되돌리기
    nextBtn_cct.setAttribute("class", "nextBtn_cl bg-gray-200 px-3 py-1 rounded text-white");
    nextBtn_cct.disabled = true;

    // 하단에 표시되는 값 초기화
    // 모달창 하단에 해당 도구명 표기        
    for (const name of cl_tool_b) {
        name.innerHTML = "";
    }
}

// 다음 버튼 클릭
// 1. 수업 이름, 수업 시간 및 횟수, 수업 일정, 커뮤니케이션 도구 로컬스토리지에 저장
// 2. 예약한 정보 확인 및 강사에게 하고 싶은 말 적는 페이지로 이동
nextBtn_cct.addEventListener('click', function() {

    // 예약 관련 정보들 json 형태로 담아 로컬 스토리지에 저장

    // 일정은 string 형태로 전환
    const schedule_list = clSchedule_final.join("_");
    const reserveInfoAll = {

        clName : clName_final,
        clTime : clTime_final,
        clSchedule : schedule_list,
        clTool : ctTool_final,
        clPrice : clPrice_final,
        tusid: U_id,
    }       
    
    localStorage.setItem("reserveInfoAll", JSON.stringify(reserveInfoAll));

    // 커뮤니케이션 도구 선택 모달 없애기
    const cmtoolModal = document.querySelector('.reserve-modal-cmtool');   
    cmtoolModal.classList.add('hidden');
 
    
    // 최종 수업 예약 화면으로 이동
    location.assign("../reservefinal/reservefinal.php");     

})





