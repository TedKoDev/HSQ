import {$, $_all} from '/utils/querySelector.js';


export function classfilter() {

    // 선택한 필터가 표시되는 div
    const filterItem_div = $('.filterItemList');

    // 모달창 안에 있는 뷰들
    // 수업 유형 담겨있는 div
    const classType_div = $('.classTypeList');

    // 수업 유형 클릭하면 그 value값에 해당하는 버튼을 생성
    classType_div.addEventListener("click", (e) => {
        
        const target = e.target.closest("button");
        if (!(target instanceof HTMLButtonElement)) return;


        const filterValue = target.value;

        // 클릭 시 새로운 버튼 생성
        const new_btn = document.createElement('div');
        new_btn.innerHTML = `
            <div value = ${filterValue} class = "flex items-center text-xs px-1 py-2 text-center  bg-gray-300 hover:bg-gray-400 rounded-2xl mx-1">
                <span class = "mr-1">${filterValue}</span>
                <button value = ${filterValue} class="text-gray-800 font-medium inline-flex items-center" type="button">
                    <svg name = "deleteIcon" class= "deleteIcon w-4 h-4 bg-gray-500 rounded-full text-white border-white" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/></svg>
                </button>                
            </div>
            `;              
                          
        filterItem_div.append(new_btn);
    });  

    
    // filterItem_div X 아이콘 클릭 시 발생하는 이벤트
    filterItem_div.addEventListener('click', (e) => {

        const target = e.target.closest("button");
        if ((target instanceof HTMLButtonElement)) {
            
            console.log("삭제");
        } 
           
    })

}
