import { routes } from "./constants/routeInfo.js";
import { notfound } from "./pages.js";


function Router($container) {
  this.$container = $container;
  let currentPage = undefined; 

  
  const findMatchedRoute = () =>
    routes.find((route) => route.path.test(location.pathname));    
    
  const route = () => {
    currentPage = null;    

    console.log("location.pathname : "+location.pathname);
    
    const TargetPage = findMatchedRoute()?.element || notfound;
    currentPage = new TargetPage(this.$container);    
  };

  const init = () => {
    window.addEventListener("historychange", ({ detail }) => {
      const { to, isReplace } = detail;

      if (isReplace || to === location.pathname)
        history.replaceState(null, "", to);
      else history.pushState(null, "", to);

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