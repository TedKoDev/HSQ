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

const showFeedbackList = ($container) => {

  $container.innerHTML = "";
}


export default feedbacklist;