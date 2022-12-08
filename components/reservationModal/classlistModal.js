// 해당 강사의 수업 목록 가져와서 표시 수업 목록 div 초기화
let class_list = document.querySelector(".class-list");
// 수업 목록에서 다음 버튼 초기화
let nextBtn_cl = document.querySelector(".nextBtn_cl");

// 모달창 하단에 수업 이름 표시하는 뷰 초기화
let cl_name_b = document.querySelectorAll(".cl-name");

// 최종적으로 선택할 수업 이름 변수 
let clName_final;
// 최종적으로 선택할 수업 ID 변수 
let clId_final;

//

// 수업 목록 화면에 출력하는 함수
async function getclassList_cm(tusid) {

    const body = {

        kind: 'tclist',
        tusid: tusid,
        clname: 1,
        cltype: 1,
        cllevel: 1,
        clprice: 1
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
    const classList = result.class;
   
    // 세팅하기 전에 일단 초기화
    while (class_list.firstChild) {
        class_list.removeChild(class_list.firstChild);
    }

    for (let i = 0; i < classList.length; i++) {

        const clid = classList[i].class_id;
        const clname = classList[i].clname;
        const cllevel = classList[i].cllevel;
        const cltype = classList[i].cltype;
        const price30 = classList[i].tp[0];
        const price60 = classList[i].tp[1];

        // 받아온 수업 목록 세팅
        setClasslist_cm(clid, clname, cllevel, cltype, price30, price60);

    }

}

function setClasslist_cm(clid, clname, cllevel, cltype, price30, price60) {

    const class_div = document.createElement('div');
    // 해당 div의 id로 클래스의 id 매칭하고 스타일 부여
    class_div.setAttribute("id", "class_" + clid);
    class_div.setAttribute(
        "class",
        "class-div ml-4 mr-4 bg-gray-50 justify-between rounded-lg my-2 border-2 hover:" +
                "shadow"
    );
    // 디폴트 value값으로 0 세팅
    class_div.setAttribute("value", 0);

    const div = document.createElement('div');
    div.setAttribute("id", "click_" + clid);
    // console.log("pass");
    div.innerHTML = [
        '<div class = "flex justify-between">', '<div class = "flex flex-col px-4">', '<div class = "text-base font-normal mb-3 mt-1">' +
                clname + '</div>',
        '<div id = type_cm' + clid + ' class = "flex mb-2 text-sm">',
        '</div>',
        '</div>',
        '<div class = "flex flex-col my-auto px-4">',
        '<div>30분 : <a>' + price30 + ' $</a></div>',
        '<div>60분 : <a>' + price60 + ' $</a></div>',
        '</div>',
        '</div>'
    ].join("");

    class_div.appendChild(div);
    class_list.appendChild(class_div);

    // 수업레벨, 수업 유형 덧붙이기 위해 div id 가져오기
    const type_div = document.getElementById("type_cm" + clid);

    // 수업 레벨 가져온 다음 배열로 바꾸어서 대입
    const level_array = cllevel.split("_");
    const level_string = level_array[0] + " - " + level_array[1];

    const level_a = document.createElement("a");
    level_a.setAttribute("class", "text-gray-700 mr-2");
    level_a.innerHTML = level_string;

    type_div.appendChild(level_a);

    // 수업 유형 배열로 전환
    const type_array = cltype.split(",");

    //   배열 개수만큼 반복문 돌려서 태그 생성 후 대입
    for (let j = 0; j < type_array.length; j++) {

        // console.log(type_array[j]);
        const type = document.createElement("a");
        type.setAttribute("class", "bg-gray-500 text-gray-800 mr-2 rounded-lg px-2")
        type.innerHTML = type_array[j];

        // console.log(type_div.value);
        type_div.appendChild(type);
    }

    // 해당 수업 클릭했을 때 이벤트
    // 1. 그 수업 외에는 색깔 bg-gray-50으로 변하게
    // 2. 그 수업 외의 class_div의 value 값을 0으로 설정
    // 3. 그 수업의 색깔 진한 회색으로 변하게
    // 4. 그 수업 class_div의 value값을 1로 설정

    class_div.addEventListener('click', function () {

        // 모달창 하단에 해당 수업 이름 표기 (모든 모달창의 수업 이름에 세팅해 주어야 함)        
        for (const name of cl_name_b) {
            name.innerHTML = clname;
        }

        // 모든 수업목록 div 가져오기
        const all_class_div = document.querySelectorAll('.class-div');

        for (const label of all_class_div) {

            // 일단 모든 수업 색깔 bg-gray-50으로
            label.setAttribute(
                "class",
                "class-div ml-4 mr-4 bg-gray-50 justify-between rounded-lg my-2 border-2 hover:" +
                        "shadow"
            );
            // 모든 수업 value값 0으로
            label.setAttribute("value", '0');

            // console.log(label.name);
        }

        // 선택한 수업의 색깔 진회색으로 변하게
        class_div.setAttribute(
            "class",
            "class-div ml-4 mr-4 bg-gray-200 justify-between rounded-lg my-2 border-2 hover" +
                    ":shadow"
        );
        // 선택한 수업의 value의 값을 1로 설정
        class_div.setAttribute("value", '1');
            
        // 다음 버튼 활성화
        checkNextbtn_cl(all_class_div);

        // 해당 classid를 로컬 스토리지에 저장
        localStorage.setItem("classid", clid);

        // 전역변수에 이름 대입
        clName_final = clname;
        // 전역변수에 id 대입
        clId_final = clid;
    })
}

// 다음 버튼 활성화 여부
function checkNextbtn_cl() {

    // 모든 수업목록 div 가져오기
    const all_class_div = document.querySelectorAll('.class-div');

    for (const label of all_class_div) {

        // 하나라도 value가 1인게 있으면 (유저가 수업을 선택했으면) 다음 버튼 활성화 하고 반복문 넘어가기
        if (label.getAttribute("value") == 1) {
            nextBtn_cl.disabled = false;
            break;
        }
    }

    if (nextBtn_cl.disabled == true) {
        nextBtn_cl.setAttribute(
            "class",
            "nextBtn_cl bg-gray-200 px-3 py-1 rounded text-white"
        );
    } else {
        nextBtn_cl.setAttribute(
            "class",
            "nextBtn_cl bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white"
        );
    }
}

// 수업 목록 화면 원래대로 초기화(어떤 모달창에서든 x버튼 눌렀을 때 해당 함수 필요함)
// 1. 수업 목록 색깔 원래 색으로
// 2. 모든 수업의 value값 0으로
// 3. 다음 버튼 비활성화
// 4. 모달창 하단에 클릭했던 수업 표시되는거 초기화
function initClassModal() {

    // 모든 수업목록 div 가져오기
    const all_class_div = document.querySelectorAll('.class-div');

    for (const label of all_class_div) {

        // 1. 수업 목록 색깔 원래 색으로
        label.setAttribute(
            "class",
            "class-div ml-4 mr-4 bg-gray-50 justify-between rounded-lg my-2 border-2 hover:" +
                    "shadow"
        );

        // 2. 모든 수업의 value값 0으로
        label.setAttribute("value", '0');
    }

    // 3. 다음 버튼 비활성화
    nextBtn_cl.setAttribute(
        "class",
        "nextBtn_cl bg-gray-200 px-3 py-1 rounded text-white disabled"
    );

    // 4. 모달창 하단에 클릭했던 수업 표시되는거 초기화
    for (const label of cl_name_b) {
        label.innerHTML = "";
    }  
}

// 활성화된 다음버튼 클릭하면 수업 시간 선택하는 모달창 띄우고 이전 모달창 없애기
nextBtn_cl.addEventListener('click', function() {

    // 수업 목록 모달, 수업 시간 모달 값 가져오기
    const classlistModal = document.querySelector('.reserve-modal-class');
    const classtimeModal = document.querySelector('.reserve-modal-time');

    // 수업 목록 모달 없어지게 처리
    classlistModal.classList.add('hidden');
    // 수업 시간 모달 표시되게 처리
    classtimeModal.classList.remove('hidden');

    // 해당 수업의 가격 출력
    getclassPrice_tm();
  
})