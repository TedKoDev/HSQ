import { navigate } from "./navigate.js";
import { $, $_all } from "/utils/querySelector.js";
import { BASE_URL } from "./constants/routeInfo.js";
import Router from "./router.js";

function classList($container) {
  this.$container = $container;
  
  const init = () => {
    $(".navbar").addEventListener("click", (e) => {
      const target = e.target.closest("a");
      if (!(target instanceof HTMLAnchorElement)) return;

      e.preventDefault();
      
      const targetURL = e.target.href.replace(BASE_URL, "");      
      navigate(targetURL);

      changeSelectBtnStyle(target);
    });            
    
    new Router($container);
  };

  init();
  
}

const changeSelectBtnStyle = (target) => {

  const classType = $_all(".classType");
  for (let i = 0; i < classType.length; i++) {
    classType[i].setAttribute("class", "classType mx-2 py-5 font-normal text-sm border-0");
  }
  target.setAttribute("class", "classType mx-2 py-5 font-semibold text-sm border-b-4 border-blue-400 text-gray-800")
};

export default classList;