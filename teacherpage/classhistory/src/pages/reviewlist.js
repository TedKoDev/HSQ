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

const showReviewList = ($container) => {

  $container.innerHTML = "";
}

export default reviewlist;