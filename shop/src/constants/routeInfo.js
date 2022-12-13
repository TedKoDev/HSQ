import Main from "../pages/main.js";
import Post from "../pages/post.js";
import Shop from "../pages/shop.js";

export const BASE_URL = "http://localhost:3000";

export const routes = [
  { path: /^\/$/, element: Main },
  { path: /^\/post\/[\w]+$/, element: Post },
  { path: /^\/shop\/$/, element: Shop },
];