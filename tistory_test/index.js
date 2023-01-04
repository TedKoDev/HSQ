// 체크박스 가져오기
const checkbox = document.getElementById("custom_button");

// 체크박스 클릭시 true/false 여부에 따라 색상 변하는 함수
function clickCheckbox(e) {

    
    // 해당 체크박스의 라벨 가져오기
    const label = document.getElementById(e.target.id+"_label");

    // 체크박스 값이 true일 경우
    if (e.target.checked == true) {
        
        label.classList.replace('checkbox_label', 'checkbox_label_click');       
        
    }
    // false일 경우
    else {        

        label.classList.replace('checkbox_label_click', 'checkbox_label');               
    }
}

// 체크박스 클릭 이벤트
checkbox.addEventListener('click', (e) => {

    clickCheckbox(e);
       
})