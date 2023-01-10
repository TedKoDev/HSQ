import { routes } from "./constants/routeInfo.js";
import { notfound } from "./pages/notfound.js";

export function Router($container) {
  this.$container = $container;
  let currentPage = undefined;  
    
  const findMatchedRoute = () =>
    routes.find((route) => route.path.test(location.pathname));    


  const route = () => {
    currentPage = null;    
    
    const TargetPage = findMatchedRoute()?.element || notfound;    
    currentPage = new TargetPage(this.$container);      
    console.log(currentPage); 
  };

  const init = () => {
    window.addEventListener("classtypeChange", ({ detail }) => {

      const { to, isReplace } = detail;
      
      history.pushState(null, "", to);   
      
      // console.log("to : "+to)
      // console.log("location.pathname : "+location.pathname);

      route();
    });

    window.addEventListener("popstate", () => {
      route();
    });
  };

  init();
  route();
}

