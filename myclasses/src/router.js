import { routes } from "./constants/routeInfo.js";
import { notfound } from "./pages.js";


function Router($container) {
  this.$container = $container;  
  let currentPage = undefined; 

  
  const findMatchedRoute = () =>
    routes.find((route) => route.path.test(location.pathname));    
    
  const route = () => {
    currentPage = null;    

    const TargetPage = findMatchedRoute()?.element || notfound;
    currentPage = new TargetPage(this.$container);    
  };

  const init = () => {
    window.addEventListener("classtypeChange", ({ detail }) => {

      const { to, isReplace } = detail;
      
      history.replaceState(null, "", to);      

      route();
    });

    window.addEventListener("popstate", () => {
      route();
    });
  };

  init();
  route();
}

export default Router;