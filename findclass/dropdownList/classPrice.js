import { $, $_all } from "/utils/querySelector.js";
import { changeJson } from "../classfilter.js";
import { getClassinfo } from "../findclass.js";
import { addFilterItem } from "../classfilter.js";

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
        max_range.value = 50;
        min_price.innerHTML = 0;
        max_price.innerHTML = 50;
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

    // 필터 아이템 화면에 표시
    addFilterItem(filterItem_div, filterValue, text, "filter_class_price", "classPrice_item");
  
    // json 값 변경
    changeJson('filter_class_price', filterValue, 'update');
}
