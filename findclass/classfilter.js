import {$, $_all} from '/utils/querySelector.js';
import { cookieName, getCookie} from "/commenJS/cookie_modules.js";
import { getClassinfo } from './findclass.js';

export async function classfilter() {    

    // 선택한 필터가 표시되는 div
    const filterItem_div = $('.filterItemList');
    // 화면 켜지면서 렌더링 될 때 request_to_server에서 필터에 해당하는 값이 있을 경우에는 필터 아이템 리스트에 해당 아이템 추가
    setFilterItem(filterItem_div, request_to_server);

    // checkbox 형태가 들어가 있는 필터 버튼 (수업 유형, 구사 가능 언어, 출신지)
    const classTypeModalBtn = $('#classType_btn');
    const teacherLanguageModalBtn = $('#teacherLanguage_btn');
    const teacherCountryModalBtn = $('#teacherCountry_btn');

    // checkbox 있는 모달 클릭했을때 json에 존재하는 array만 체크표시하고 색상 변하게 처리해놓기 (나머지는 디폴트로)
    clickBtn_checkbox(classTypeModalBtn, "filter_class_type");
    clickBtn_checkbox(teacherLanguageModalBtn, "filter_teacher_language");
    clickBtn_checkbox(teacherCountryModalBtn, "filter_teacher_country");

    function clickBtn_checkbox(btn, type) {

        btn.addEventListener('click', () =>{

            const checkboxes = document.getElementsByName(type);
                      
            for (const box of checkboxes) {
                
                box.checked = false;
                const label = document.getElementById(box.value+"_l");
                label.classList.remove('bg-gray-700');
                label.classList.remove('text-white');
                label.classList.add('bg-gray-300');
                label.classList.add('hover:bg-gray-400');
                label.classList.add('text-gray-800'); 
            }
                   
            for (const box of checkboxes) {

                for (const check of request_to_server[type]) {

                    if (box.value == check) {

                        box.checked = true;
                        const label = document.getElementById(box.value+"_l");
                        label.classList.remove('bg-gray-300');
                        label.classList.remove('hover:bg-gray-400');
                        label.classList.remove('text-gray-800');
                        label.classList.add('bg-gray-700');
                        label.classList.add('text-white');
                    }                    
                }                
            }            
        })
    }

    // radio 형태가 들어가 있는 필터 버튼 (강사 유형, 강사 성별)
    const teacherTypeModalBtn = $('#teacherType_btn');
    const teacherSexModalBtn = $('#teacherSex_btn');

    // radio 있는 모달 클릭했을 때 json에 null 이면 디폴트로 false 처리해놓고 request_to_server에 있는 값만 true로 체크해놓기
    clickBtn_radio(teacherTypeModalBtn, 'filter_teacher_special');
    clickBtn_radio(teacherSexModalBtn, 'filter_teacher_sex');

    function clickBtn_radio(btn, type) {

        btn.addEventListener('click', () =>{

            const allRadioBtn = document.getElementsByName(type);

            for (const radioBtn of allRadioBtn) {

                radioBtn.checked = false;
            }            

            for (const radioBtn of allRadioBtn) {

                if (radioBtn == request_to_server[type]) {

                    radioBtn == true;
                }                              
            }       

        })
    }    
       
    // 모달창 안에 있는 뷰들
    // checkbox 형태    
    const classType_div = $('.classTypeList');
    const teacherCountry_div = $('.teacherCountryList');
    const teacherLanguage_div = $('.teacherLanguageList');
    const classTime_div = $('.classTimeList');

    // 검색창 및 검색 버튼
    const search_input = $('.search_input');
    const search_btn = $('.search_btn');

       
    // 모달창 안에 있는 checkbox 클릭 시 필터 추가/삭제 이벤트
    clickFilter_in_Modal_checkbox(classType_div);
    clickFilter_in_Modal_checkbox(teacherCountry_div);
    clickFilter_in_Modal_checkbox(teacherLanguage_div);
    clickFilter_in_Modal_checkbox(classTime_div);

    // radio 형태의 버튼들
    const teacherSex_div = $('.teacherSexList');
    const teacherType_div = $('.teacherTypeList');

    // 모달창 안에 있는 radio 클릭 시 필터 추가/삭제 이벤트
    clickFilter_in_Modal_radio(teacherSex_div, "sex_item");
    clickFilter_in_Modal_radio(teacherType_div, "teacherType_item");


    // 체크박스로 구성된 모달에서 클릭 시 이벤트
    async function clickFilter_in_Modal_checkbox(type_div) {

        type_div.addEventListener("click", (e) => {                

            const target = e.target.closest("input");
            if (!(target instanceof HTMLInputElement)) return;
    
            const filterValue = target.value;       
            
            // false->true일 경우 새로운 버튼 생성
            if (e.target.checked == true) {

                let text;
                // 수업 시간 선택일 경우
                if (e.target.name == "filter_time") {
                    
                    text = ('00' + filterValue).slice(-2)+":00 - "+('00' + (parseInt(filterValue)+1)).slice(-2)+":00";
                                  
                }
                // 그 이외일 경우
                else {
                    text = filterValue;
                    
                }

                // 필터 아이템 화면에 표시
                addFilterItem(filterItem_div, filterValue, text, target.name, "");         

                // json 값 추가              
                changeJson(target.name, filterValue, 'add');
            }
            // true -> false일 경우 해당 버튼 삭제
            else {
                const delete_div = document.getElementById(filterValue+"_div");
                delete_div.remove();

                // json 값 삭제
                changeJson(target.name, filterValue, 'delete');
            }
                        
            clickCheckbox(e);
            
        });
    }
    
    // radio 버튼으로 구성된 모달에서 클릭 이벤트
    async function clickFilter_in_Modal_radio(type_div, type_item) {

        const class_name = type_item;

        type_div.addEventListener("click", (e) => {

            const target = e.target.closest("input");
            if (!(target instanceof HTMLInputElement)) return;
    
            // 필터 아이템 리스트에서 해당 필터 종류 모두 초기화
            const date_div_list = $_all('.'+class_name);    
            for (const date_item of date_div_list) {

                date_item.remove();
            }   

            const filterValue = target.value;    

            let text;
            // 강사 유형 선택일 경우
            if (class_name == "teacherType_item") {
                
                if (filterValue == 'default') {

                    text = '커뮤니티 튜터';
                } 
                else {

                    text = '전문 강사';
                }                                
            }
            // 그 이외일 경우
            else {
                text = filterValue;                
            }            
            
            // 필터 아이템 화면에 표시
            addFilterItem(filterItem_div, filterValue, text, target.name, class_name);

            // json 값 변경
            changeJson(target.name, filterValue, 'update');
        })
    }

    
    // filterItem_div X 아이콘 클릭 시 발생하는 이벤트
    filterItem_div.addEventListener('click', (e) => {

        const target = e.target.closest("button");
        if ((target instanceof HTMLButtonElement)) {
                          
            const delete_div = document.getElementById(target.value+"_div");
            delete_div.remove();

            // 만약 삭제한게 search일 경우 검색창 값 초기화
            if (target.id == 'search_item_btn') {

                search_input.value = "";
            }

            // json 값 삭제
            changeJson(target.name, target.value, 'delete');            
        }            
    })

    // 체크박스 클릭 시 색상 변화 함수
    function clickCheckbox(e) {

        // 해당 체크박스의 라벨 가져오기
        const label = document.getElementById(e.target.value+"_l");

        // 강의 시간 모달에서 클릭한 경우
        if (e.target.name == "filter_time") {

            if (e.target.checked == true) {

                label.classList.remove('hover:bg-gray-300');
                label.classList.remove('text-gray-800');
                label.classList.add('bg-gray-700');
                label.classList.add('text-white');
                
            }
            else {
            
                label.classList.add('hover:bg-gray-300');
                label.classList.add('text-gray-800');
                label.classList.add('bg-white');
                label.classList.remove('bg-gray-700');
                label.classList.remove('text-white');            
            }
        }

        // 그 이외일 경우
        else {

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
    }     
    
    function clickInputBtn(search_input, e) {

        // 필터 아이템 리스트에서 해당 필터 종류 모두 초기화
        const search_div_list = $_all('.search_item');    
        for (const search_item of search_div_list) {

            search_item.remove();
        } 

        const filterValue = search_input.value;

        // 필터 아이템 화면에 표시
        addFilterItem(filterItem_div, filterValue, filterValue, "filter_search", "search_item");       

        // json 값 변경        
        changeJson("filter_search", filterValue, 'update');
    }
    // 검색 버튼 클릭할 때 이벤트
    search_btn.addEventListener('click', (e) => {

        clickInputBtn(search_input, e);
    })
}

// 필터 선택 시 아이템 추가하는 함수
export function addFilterItem($filterItem_div, filterValue, text, button_name, class_name) {

    const new_btn = document.createElement('div');
    new_btn.innerHTML = `
        <div id = "${filterValue}_div" value = ${filterValue} class = "${class_name} flex items-center text-xs px-1 py-2 text-center  bg-gray-300 hover:bg-gray-400 rounded-2xl mx-1">
            <span class = "mr-1">${text}</span>
            <button value = "${filterValue}" name = ${button_name} id = "search_item_btn" class="text-gray-800 font-medium inline-flex items-center" type="button">
                <svg name = "deleteIcon" class= "deleteIcon w-4 h-4 bg-gray-500 rounded-full text-white border-white" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/></svg>
            </button>                
        </div>
        `;              
                        
    $filterItem_div.append(new_btn);
}

// 화면 켜지면서 렌더링 될 때 (수업찾기 메뉴 클릭 or 새로고침) request_to_server에서 필터에 해당하는 값이 있을 경우 필터 아이템 리스트에 해당 값 추가
function setFilterItem($filterItem_div, json) {

    // 검색
    if (json.filter_search != null) {

        addFilterItem($filterItem_div, json.filter_search, json.filter_search, "filter_search", "search_item");       
    }
    // 강사 유형 (전문강사, 커뮤니티 튜터)
    if (json.filter_teacher_special != null) {

        let text;

        if (json.filter_teacher_special == "default") {
            text = '커뮤니티 튜터';
        }
        else if (json.filter_teacher_special == "nondefault"){
            text = '전문 강사';
        }

        addFilterItem($filterItem_div, json.filter_teacher_special, text, "filter_teacher_special", "teacherType_item");
    }
    if (json.filter_date != null) {

        const text = dayjs(parseInt(json.filter_date)).format('MM월 DD일');

        addFilterItem($filterItem_div, filterValue, text, "filter_date", "date_item");
    }
    if (json.filter_teacher_sex != null) {

        addFilterItem($filterItem_div, json.filter_teacher_sex, json.filter_teacher_sex, "filter_teacher_sex", "sex_item");
    }
    if (json.filter_class_price_min != null || json.filter_class_price_max != null) {

        let price_min = json.filter_class_price_min;
        let price_max = json.filter_class_price_max;

        if (json.filter_class_price_min == null) {

            price_min = 0;
        }  
        if (json.filter_class_price_max == null) {

            price_max = 1000;
        }         

        const filterValue = price_min+" - "+price_max;
        const text = "$ "+price_min+" USD - $ "+price_max+" USD";

        addFilterItem($filterItem_div, filterValue, text, "filter_class_price", "classPrice_item");
    }
    if (json.filter_time.length != 0) {

        const array = json.filter_time;
        for (const item of array) {

            const text = ('00' + item).slice(-2)+":00 - "+('00' + (parseInt(item)+1)).slice(-2)+":00";

            addFilterItem($filterItem_div, item, text, "filter_time", "");
        }
    }
    if (json.filter_class_type.length != 0) {

        const array = json.filter_class_type;
        for (const item of array) {
           
            addFilterItem($filterItem_div, item, item, "filter_class_type", "");
        }
    }
    if (json.filter_teacher_country.length != 0) {

        const array = json.filter_teacher_country;
        for (const item of array) {
           
            addFilterItem($filterItem_div, item, item, "filter_teacher_country", "");
        }
    }
    if (json.filter_teacher_language.length != 0) {

        const array = json.filter_teacher_language;
        for (const item of array) {
           
            addFilterItem($filterItem_div, item, item, "filter_teacher_language", "");
        }
    }

}

// 이벤트에 따라 서버에 보낼 json 변경
export function changeJson(key, value, type) {

    // type : add / update / delete (추가, 변경, 삭제인지 판별)
    // var / array : var이면 변경/삭제, array면 추가/삭제

    if (key == 'filter_search') {
        
        checkType(key, value, type, 'var');     
    }
    else if (key == 'filter_class_price') {

        checkClassPrice(value, type);
    }
    else if (key == 'filter_teacher_special') {
        
        checkType(key, value, type, 'var');
    }
    else if (key == 'filter_date') {
        
        checkType(key, value, type, 'var');
    }
    else if (key == 'filter_time') {
        
        checkType(key, value, type, 'array');
    }
    else if (key == 'filter_class_type') {
        
        checkType(key, value, type, 'array');
    }
    else if (key == 'filter_teacher_sex') {
        
        checkType(key, value, type, 'var');
    }
    else if (key == 'filter_teacher_country') {
        
        checkType(key, value, type, 'array');
    }
    else if (key == 'filter_teacher_language') {
        
        checkType(key, value, type, 'array');
    }    

    function checkType(key, value, type, var_array) {
       
        const check = var_array;

        if (type == 'add') {            

            request_to_server[key].push(value);
        }
        else if (type == 'update') {

            request_to_server[key] = value;
        }
        else if (type == 'delete') {

            if (check == 'var') {

                request_to_server[key] = null;
            }
            else if (check == 'array') {

                for(let i = 0; i < request_to_server[key].length; i++) {
                    if(request_to_server[key][i] === value)  {
                        request_to_server[key].splice(i, 1);
                      i--;
                    }
                }
            }            
        }
    }

    // 수강료 관련 필터일 경우 (최소/최고 가격 때문에 별도의 함수로 처리)
    function checkClassPrice(value, type) {
        
        const min_max_array = value.split(' - ');

        const min_price = min_max_array[0];
        const max_price = min_max_array[1];

        if (type == 'update') {

            request_to_server.filter_class_price_min = min_price;
            request_to_server.filter_class_price_max = max_price;
        }
        else if (type == 'delete') {

            request_to_server.filter_class_price_min = null;
            request_to_server.filter_class_price_max = null;
        }
    }    

    // 변경된 json 로컬 스토리지에 저장
    saveFilterJson(request_to_server);
}

// 변경된 json 로컬 스토리지에 저장
export function saveFilterJson(json) {

    // filter_json이라는 이름으로 로컬 스토리지에 저장
    localStorage.setItem("filter_json", JSON.stringify(json));

    // 서버에 json 보내서 재 렌더링
    getClassinfo(json);
}