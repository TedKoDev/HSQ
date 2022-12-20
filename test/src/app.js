import { navigate } from "./utils/navigate.js";
import { $ } from "./utils/querySelector.js";
import { BASE_URL } from "./constants/routeInfo.js";
import Router from "./router.js";

function App($container) {
  this.$container = $container;

  console.log("shop_test3 : "+shop_test);

  const init = () => {
    $(".navbar").addEventListener("click", (e) => {
      const target = e.target.closest("a");
      if (!(target instanceof HTMLAnchorElement)) return;

      e.preventDefault();
      
      const targetURL = e.target.href.replace(BASE_URL, "");      
      navigate(targetURL);
    });

    if (shop_test == 'shop') {       
      navigate("/"+shop_test);
      shop_test = "";
    }
    
    new Router($container);
  };

  init();
  
}

export default App;