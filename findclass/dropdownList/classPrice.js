import { $, $_all } from "/utils/querySelector.js";
import { changeJson } from "../classfilter.js";

const min_price = $('#range1');
const max_price = $('#range2');
const min_range = $('#slider-1');
const max_range = $('#slider-2');

// 선택한 필터가 표시되는 div
const filterItem_div = $('.filterItemList');

// 수강료 모달;
const classPriceModal = $('#classPrice_btn');

// 모달 클릭했을 때 json에 값 없으면 수강료 range 디폴트값으로 놓기
classPriceModal.addEventListener('click', () => {

    if (request_to_server.filter_class_price_min == null && request_to_server.filter_class_price_max == null) {
        
        min_range.value = 0;
        max_range.value = 1000;
        min_price.innerHTML = 0;
        max_price.innerHTML = 1000;
    }
})

min_range.addEventListener('mouseup', (e) => {
    
    addPriceFileterItem();
})

max_range.addEventListener('mouseup', (e) => {

    addPriceFileterItem();
})

async function addPriceFileterItem() {

    // 필터 아이템 리스트에서 해당 필터 종류 모두 초기화
    const price_div_list = $_all('.classPrice_item');    
    for (const price_item of price_div_list) {

        price_item.remove();
    }  

    const price_min = min_price.innerHTML;
    const price_max = max_price.innerHTML;

    const filterValue = price_min+" - "+price_max;
    const text = "$ "+price_min+" USD - $ "+price_max+" USD";

    const new_btn = document.createElement('div');
    new_btn.innerHTML = `
        <div id = "${filterValue}_div" value = ${filterValue} class = "classPrice_item flex items-center text-xs px-1 py-2 text-center  bg-gray-300 hover:bg-gray-400 rounded-2xl mx-1">
            <span class = "mr-1">${text}</span>
            <button value = "${filterValue}" name = "filter_class_price" class="text-gray-800 font-medium inline-flex items-center" type="button">
                <svg name = "deleteIcon" class= "deleteIcon w-4 h-4 bg-gray-500 rounded-full text-white border-white" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/></svg>
            </button>                
        </div>
        `;              
                        
    filterItem_div.append(new_btn);

    // json 값 변경
    changeJson('filter_class_price', filterValue, 'update');
}
