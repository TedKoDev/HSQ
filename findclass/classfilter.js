import {$, $_all} from '/utils/querySelector.js';


export function classfilter() {

    // 선택한 필터가 표시되는 div
    const filterItem_div = $('.filterItemList');

    // 모달창 안에 있는 뷰들
    // checkbox 형태    
    const classType_div = $('.classTypeList');
    const teacherCountry_div = $('.teacherCountryList');
    const teacherLanguage_div = $('.teacherLanguageList');
    const classTime_div = $('#classTime');
    
    // 모달창 안에 있는 checkbox 클릭 시 필터 추가/삭제 이벤트
    clickFilter_in_Modal(classType_div);
    clickFilter_in_Modal(teacherCountry_div);
    clickFilter_in_Modal(teacherLanguage_div);
    clickFilter_in_Modal(classTime_div);

    // radio 형태
    

    
    async function clickFilter_in_Modal(type_div) {

        type_div.addEventListener("click", (e) => {                

            const target = e.target.closest("input");
            if (!(target instanceof HTMLInputElement)) return;
    
            const filterValue = target.value;       
            
            // false->true일 경우 새로운 버튼 생성
            if (e.target.checked == true) {
    
                const new_btn = document.createElement('div');
                new_btn.innerHTML = `
                    <div id = "${filterValue}_div" value = ${filterValue} class = "flex items-center text-xs px-1 py-2 text-center  bg-gray-300 hover:bg-gray-400 rounded-2xl mx-1">
                        <span class = "mr-1">${filterValue}</span>
                        <button value = "${filterValue}" class="text-gray-800 font-medium inline-flex items-center" type="button">
                            <svg name = "deleteIcon" class= "deleteIcon w-4 h-4 bg-gray-500 rounded-full text-white border-white" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/></svg>
                        </button>                
                    </div>
                    `;              
                                  
                filterItem_div.append(new_btn);
            }
            // true -> false일 경우 해당 버튼 삭제
            else {
                const delete_div = document.getElementById(filterValue+"_div");
                delete_div.remove();
            }
            
        });
    }
    
    // filterItem_div X 아이콘 클릭 시 발생하는 이벤트
    filterItem_div.addEventListener('click', (e) => {

        const target = e.target.closest("button");
        if ((target instanceof HTMLButtonElement)) {
                          
            const delete_div = document.getElementById(target.value+"_div");
            delete_div.remove();
        } 
           
    })

    // 체크박스 클릭 시 색상 변화 함수
    function clickCheckbox(e) {

        // 해당 체크박스의 라벨 가져오기
        const label = document.getElementById(e.target.value+"_l");


        if (e.target.checked == true) {
            
            label.classList.remove('bg-gray-300');
            label.classList.remove('hover:bg-gray-400');
            label.classList.remove('text-gray-800');
            label.classList.add('bg-gray-700');
            label.classList.add('text-white');
        }
        else {

            label.classList.remove('bg-gray-700');
            label.classList.remove('text-white');
            label.classList.add('bg-gray-300');
            label.classList.add('hover:bg-gray-400');
            label.classList.add('text-gray-800');
            
        }
    }

    const checkboxes = $_all('.filter_checkbox');
    for (const box of checkboxes) {

        box.addEventListener('click', (e) => {

            clickCheckbox(e);
        })
    }

   
}

let test = {

    kind: "clist",
    clReserveCheck: null,
    filter_check: "ok",
    filter_search: null,
    filter_date : [],
    filter_hour_check: "ok",
    filter_class_price_min : null,
    filter_class_price_max : null,
    filter_teacher_special : null,
    filter_date : [],
    filter_class_type : [],
    filter_teacher_sex : null,
    filter_teacher_country : [],
    filter_teacher_language : []
  }
