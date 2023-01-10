import { navigate } from "./navigate.js";
import { $, $_all } from "/utils/querySelector.js";
import { BASE_URL } from "./constants/routeInfo.js";
import {Router} from "./router.js";


export function selectHistoryType($container) {
  this.$container = $container;  
    
  const init = () => {
    
    $(".selectHistoryType").addEventListener("click", (e) => {
      const target = e.target.closest("a");
      if (!(target instanceof HTMLAnchorElement)) return;

      e.preventDefault();
      
      const targetURL = e.target.href.replace(BASE_URL, "");      
      // console.log(targetURL);
      navigate(targetURL);          
            
    });            
    
    new Router($container);
  };

  init();
  
}
