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

      
    });    
    
    $_all(".classType")    
    
    new Router($container);
  };

  init();
  
}

const changeSelectBtnStyle = (target) => {

  // $_all(".classType")
};

export default classList;