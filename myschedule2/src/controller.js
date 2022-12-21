import { $, $_all } from "/utils/querySelector.js";


//controller
export const controller = (async function(model, view){
        
    const addItem = function(e) {

        console.log("addItem");

        e.preventDefault();

        var add_value = add_input.value;

        Data.addItem(add_value);

        UI.showList(Data.list);

        form.reset();
    };
    
    const searchItem = function() {

        console.log("searchItem");
        

        const search_value = search_input.value;

        const filter_list = Data.list.filter(function(item) {
            return item.content.indexOf(search_value) > -1;
        }); 
        
        UI.showList(filter_list);
    }

    const removeItem = function(e) {

        console.log("removeItem");

        if(e.target.tagName !== 'I') return;

        var item_id = e.target.parentNode.parentNode.id;
        var item_index = item_id.split('-')[1];

        Data.removeItem(item_index);

        UI.showList(Data.list);
    }

    const checkItem = function(e) {

        console.log("checkItem");
        
        if(e.target.tagName !== 'INPUT') return;

        const item_id = e.target.parentNode.parentNode.id;
        const item_index = item_id.split('-')[1];
        
        Data.checkItem(item_index);

        UI.showList(Data.list);
    }

    // 이전, 다음 버튼 클릭 시 캘린더 재 렌더링 되는 함수
    const reRendarCalendar = function(e) {

        const target = e.target.id;        

        if (target == "prev_btn") {

            console.log("이전");
        }
        else {
            console.log("다음");
        }
    }

    // 이전, 다음 버튼 선언
    const prev_btn = $('.prev_btn');
    const next_btn = $('.next_btn');

    // 수업 버튼 선언
    const class_btn = $_all('.schedule_list');
    
    // 이전, 다음 버튼 이벤트 리스너 선언
    prev_btn.addEventListener('click', reRendarCalendar);
    next_btn.addEventListener('click', reRendarCalendar);

    // 수업 버튼 이벤트 리스너 선언
    class_btn.forEach( (btn) => {
        btn.addEventListener('click', (e) =>{

            // 스케줄 블록안에 있는 버튼 중 클릭한 위치에서 가장 가까운 버튼 선택
            const target = e.target.closest("button");
            if (!(target instanceof HTMLButtonElement)) return;

        });
    })

    

    // const form = document.forms['list-form'];
    // const add_input = form['add-item__input'];
    // const search_input = form['search-item__input'];
    
    // const section = document.querySelector('section');
    
    // form.addEventListener('submit', addItem);
    
    // search_input.addEventListener('input', searchItem);

    // section.addEventListener('click', removeItem);
    // section.addEventListener('change', checkItem);
});

