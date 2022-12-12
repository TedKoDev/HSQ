
// 수업 유형 클릭할 때마다 하단에 파란줄 위치 변경
const allCl = document.getElementById("allCl");
const notApprovedCl = document.getElementById("notApprovedCl");
const waitingCl = document.getElementById("waitingCl");
const doneCl = document.getElementById("doneCl");
const cancelCL = document.getElementById("cancelCl");

// 버튼 선택
function selectClasstype(type) {  
    
    if (type == 'all') {
      changeSelectBtnStyle(allCl, notApprovedCl, waitingCl, doneCl, cancelCL);  
    }    
    else if (type == 'notApproved') {
      changeSelectBtnStyle(notApprovedCl, allCl, waitingCl, doneCl, cancelCL);      
    }  
    else if (type == 'waiting') {
      changeSelectBtnStyle(waitingCl, allCl, notApprovedCl, doneCl, cancelCL);      
    } 
    else if (type == 'done') {
      changeSelectBtnStyle(doneCl, allCl, notApprovedCl, waitingCl, cancelCL);      
    } 
    else if (type == 'cancel') {
      changeSelectBtnStyle(cancelCL, allCl, notApprovedCl, waitingCl, doneCl);      
    }
}

// 버튼 선택에 따른 스타일 변경
function changeSelectBtnStyle (change, reset1, reset2, reset3, reset4) {

  change.setAttribute("class", "mx-2 py-5 font-semibold text-sm border-b-4 border-blue-400 text-gray-800");
  reset1.setAttribute("class", "mx-2 py-5 font-normal text-sm border-0");
  reset2.setAttribute("class", "mx-2 py-5 font-normal text-sm border-0");
  reset3.setAttribute("class", "mx-2 py-5 font-normal text-sm border-0");
  reset4.setAttribute("class", "mx-2 py-5 font-normal text-sm border-0");
}

// innerHTML 테스트
const classList = document.querySelector('.classList');
// classList.innerHTML

