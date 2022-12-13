import App from "./src/app.js";
import { $ } from "./src/utils/querySelector.js";

console.log("shop_test2 : "+shop_test);

window.addEventListener("DOMContentLoaded", (e) => {
  new App($("#app"));
});