// 수업 시간 클릭하는 아이템 초기화
const class_30_1 = document.getElementById("item_30_1");
const class_30_5 = document.getElementById("item_30_5");
const class_60_1 = document.getElementById("item_60_1");
const class_60_5 = document.getElementById("item_60_5");

// 30분, 60분에 해당하는 가격 대입하는 div 초기화
const price30_1 = document.querySelector(".price30_1");
const price30_5 = document.querySelector(".price30_5");
const price60_1 = document.querySelector(".price60_1");
const price60_5 = document.querySelector(".price60_5");

// 수업 시간에서 다음 버튼 초기화
let nextBtn_ct = document.querySelector(".nextBtn_ct");

// 모달창 하단에 수업시간 표시하는 뷰 초기화
let cl_time_b = document.querySelectorAll(".cl-time");

// 모달창 하단에 가격 표시하는 뷰 초기화
let cl_price_b = document.querySelectorAll(".cl-price");

// 수업 시간에서 이전 버튼 초기화
let beforeArrow_cltime = document.querySelector(".beforeArrow_cltime");

// 최종적으로 선택할 수업 시간 변수 
let clTime_final;

// 최종적으로 선택할 수업의 가격 변수
let clPrice_final;

// 만약 수업 상세에서 예약 클릭한 경우이면 이전 버튼 안보이게 처리
if (checkStartpoint == "class") {
    beforeArrow_cltime.style.visibility = 'hidden';
}
else {
    beforeArrow_cltime.style.visibility = 'visible';
}

// 해당 수업의 가격 화면에 출력하는 함수
async function getclassPrice_tm() {

    // 로컬스토리지에 저장된 classid 가져오기
    const classid = localStorage.getItem("classid");

    const body = {

        kind: 'cdetail',
        class_id: C_id,          
        class_price: 1
    };
    const res = await fetch('../restapi/classinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });   

    const response = await res.json();
    const result = response.result[0];
    const price30 = result.tp[0];
    const price60 = result.tp[1];

    console.log(result);

    // 가격 대입
    price30_1.innerHTML = price30+" $";
    price30_5.innerHTML = price30*5+" $";
    price60_1.innerHTML = price60+" $";
    price60_5.innerHTML = price60*5+" $";

     // 다음버튼 활성화 여부 체크
     checkNextbtn_ct();
}

// 수업 시간 선택 버튼 클릭 리스터 함수
classtimeClick(class_30_1, price30_1);
classtimeClick(class_30_5, price30_5);
classtimeClick(class_60_1, price60_1);
classtimeClick(class_60_5, price60_5);


// 원하는 시간 및 횟수 입력했을 때 이벤트
// 1. 모든 뷰의 색깔을 원래 형태대로 초기화
// 2. 모든 뷰의 value값을 원래값인 0으로 세팅
// 3. 클릭한 뷰의 색깔을 다르게 표시
// 4. 클릭한 뷰의 value값을 1로 세팅
// 5. 모달창 하단에 수업시간 및 횟수 출력
function classtimeClick(price_and_number, price) {

    price_and_number.addEventListener('click', function() {

         // 1. 모든 뷰의 색깔을 원래 형태대로 초기화
        class_30_1.classList.add("bg-gray-50");
        class_30_1.classList.remove("bg-blue-400");
        class_30_5.classList.add("bg-gray-50");
        class_30_5.classList.remove("bg-blue-400");
        class_60_1.classList.add("bg-gray-50");
        class_60_1.classList.remove("bg-blue-400");
        class_60_5.classList.add("bg-gray-50");
        class_60_5.classList.remove("bg-blue-400");

        // 2. 모든 뷰의 value값을 0으로 세팅
        class_30_1.setAttribute("value", 0);
        class_30_5.setAttribute("value", 0);
        class_60_1.setAttribute("value", 0);
        class_60_5.setAttribute("value", 0);

        // 3. 클릭한 뷰의 색깔 다르게
        price_and_number.classList.add("bg-blue-400");
        price_and_number.classList.remove("bg-gray-50");

        // 4. 클릭한 뷰의 value값 1로 세팅
        price_and_number.setAttribute("value", 1);

        // 5. 모달창 하단에 해당 수업 시간 및 횟수 출력 (모든 모달창에 세팅해 주어야 함)    
        let string;

        for (const name of cl_time_b) {            
            
            if (price_and_number.getAttribute("name") == "30_1") {
                string = "30분 - 1회";      
                localStorage.setItem("class_times", 1);          
            }
            else if (price_and_number.getAttribute("name") == "30_5") {
                string = "30분 - 5회";    
                localStorage.setItem("class_times", 5);      
            }
            else if (price_and_number.getAttribute("name") == "60_1") {
                string = "60분 - 1회";    
                localStorage.setItem("class_times", 1);      
            }
            else if (price_and_number.getAttribute("name") == "60_5") {
                string = "60분 - 5회"; 
                localStorage.setItem("class_times", 5);        
            }

            name.innerHTML = string;
            name.setAttribute("class", "cl-time text-xs cl-name mx-1 px-3 py-2 bg-gray-200 rounded-2xl text-gray-800 border border-gray-500 border-2")
        }

        // 다음버튼 활성화 여부 체크
        checkNextbtn_ct();

        // 모달창 하단에 해당 가격 표시
        showPrice(price);

        // 전역 변수에 수업 시간 대입 
        clTime_final = string;

        // 전역 변수에 수업 가격 대입
        clPrice_final = price.innerText.replace(' $', '');
    })  
}

// 다음 버튼 활성화 여부 체크
function checkNextbtn_ct() {

   // 모든 아이템
    const time_item = document.querySelectorAll(".time-item");

    for (const label of time_item) {
        
        // 하나라도 value가 1인게 있으면 (유저가 수업을 선택했으면) 다음 버튼 활성화 하고 반복문 넘어가기
        if (label.getAttribute("value") == 1) {
            nextBtn_ct.disabled = false;
            break;
        }
        else {
            nextBtn_ct.disabled = true;
        }
    }

    if (nextBtn_ct.disabled == true) {
        nextBtn_ct.setAttribute(
            "class",
            "nextBtn_ct bg-gray-200 px-3 py-1 rounded text-white"
        );
    } else {
        nextBtn_ct.setAttribute(
            "class",
            "nextBtn_ct bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white"
        );
    }
}

// 수업 클릭할 때 모달창 하단에 해당 가격 표시
function showPrice(price) {
    
    const string = price.innerText;
    
    for (const text of cl_price_b) {
        
        text.innerHTML = string;
        
    }
}

// 수업 시간 화면 원래대로 초기화(어떤 모달창에서든 x버튼 눌렀을 때 해당 함수 필요함)
// 1. 수업 시간 색깔 원래 색으로
// 2. 모든 수업시간의 value값 0으로
// 3. 다음 버튼 비활성화
// 4. 모달창 하단에 클릭했던 수업 표시되는거 초기화
function initTimeModal() {
   
    // 수업 시간 클릭하는 아이템 가져오기
    const class_30_1 = document.getElementById("item_30_1");
    const class_30_5 = document.getElementById("item_30_5");
    const class_60_1 = document.getElementById("item_60_1");
    const class_60_5 = document.getElementById("item_60_5");

    // 1. 수업 시간 색깔 원래 색으로 초기화
    class_30_1.classList.add("bg-gray-50");
    class_30_1.classList.remove("bg-blue-400");
    class_30_5.classList.add("bg-gray-50");
    class_30_5.classList.remove("bg-blue-400");
    class_60_1.classList.add("bg-gray-50");
    class_60_1.classList.remove("bg-blue-400");
    class_60_5.classList.add("bg-gray-50");
    class_60_5.classList.remove("bg-blue-400");

    // 2. 모든 수업 시간 value값 0으로
    class_30_1.setAttribute("value", 0);
    class_30_5.setAttribute("value", 0);
    class_60_1.setAttribute("value", 0);
    class_60_5.setAttribute("value", 0);

    // 3. 다음 버튼 비활성화
    nextBtn_ct.setAttribute(
        "class",
        "nextBtn_ct bg-gray-200 px-3 py-1 rounded text-white disabled"
    );
   
    // 4. 모달창 하단에 클릭했던 수업시간 표시되는거 초기화
    for (const label of cl_time_b) {
        label.innerHTML = "";
        label.setAttribute("class", "");
    }    
}


// 활성화된 다음버튼 클릭하면 수업 일정 선택하는 모달창 띄우고 이전 모달창들 없애기
nextBtn_ct.addEventListener('click', function() {

    // 수업 시간 모달, 수업일정 모달 값 가져오기    
    const classtimeModal = document.querySelector('.reserve-modal-time');
    const classscheduleModal = document.querySelector('.reserve-modal-schedule');

    // 수업시간 모달 없어지게 처리    
    classtimeModal.classList.add('hidden');
    // 수업 일정 모달 표시되게 처리
    classscheduleModal.classList.remove('hidden');
    
    // 수업 일정 출력하는 함수
    getclassSchedule_sm();
    
})

const beforeClick_cltime = () => {

    // 수업 목록 모달, 수업 시간 모달, 수업일정 모달 값 가져오기
    const classlistModal = document.querySelector('.reserve-modal-class');
    const classtimeModal = document.querySelector('.reserve-modal-time');

     // 수업 목록 보이고 수업 시간 없어지게 처리
     classlistModal.classList.remove('hidden');
     classtimeModal.classList.add('hidden');
};

// 이전 버튼 클릭하면 수업 목록 모달창 띄우고 수업 시간 모달창 지우기
beforeArrow_cltime.addEventListener('click', beforeClick_cltime);

