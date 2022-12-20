import  {all, notapproved, approved, done, canceled} from "../pages.js";


export const BASE_URL = "http://localhost";

export const routes = [
  { path: /^\/myclasses\/all\/$/, element: all },
  // { path: /^\/notapproved\/$/, element: notapproved },
  { path: /^\/myclasses\/notapproved\/$/, element: notapproved },
  { path: /^\/myclasses\/approved\/$/, element: approved },
  { path: /^\/myclasses\/done\/$/, element: done },
  { path: /^\/myclasses\/canceled\/$/, element: canceled },
];