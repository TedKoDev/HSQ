import { changeSelectBtnStyle, getFilterInit} from "./pages.js";
import { $, $_all } from "/utils/querySelector.js";

export function reviewlist($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
    
      // 수업 목록의 필터 부분 초기화
      getFilterInit($('.filter'));

      changeSelectBtnStyle($('#reviewList'), $_all(".historyType"));

      showReviewList($container);
    };
  
    this.render();
}

async function showReviewList($container) {

  $container.innerHTML = "";
  $container.setAttribute("class", "bg-gray-50 rounded-lg");

  const reviewList = await getreviewlist();
}

async function getreviewlist() { 
        
  let body = {

      token: getCookie(cookieName),
      kind: 'review_teacher',        
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

export default reviewlist;