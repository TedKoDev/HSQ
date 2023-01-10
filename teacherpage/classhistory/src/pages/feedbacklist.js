import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import { changeSelectBtnStyle, getFilterInit } from "./pages.js";
import { $, $_all } from "/utils/querySelector.js";

export function feedbacklist($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {            

      // 수업 목록의 필터 부분 초기화
      getFilterInit($('.filter'));

      changeSelectBtnStyle($('#myfeedbackList'), $_all(".historyType"));

      showFeedbackList($container);
    };
  
    this.render();
}

async function showFeedbackList($container) {
  
  $container.innerHTML = "";

  // 피드백 목록 가져와서 대입
  const feedbackList = await getfeedbacklist();

  console.log(feedbackList);
}

async function getfeedbacklist() { 
        
  let body = {

      token: getCookie(cookieName),
      kind: 'feedback_teacher',        
  };   
  
  const res = await fetch('/restapi/review.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(body)
  });    
  
  const response = await res.json();        
  
  return response.result;  
}


export default feedbacklist;