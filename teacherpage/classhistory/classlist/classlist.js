import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import {selectHistoryType} from "../src/selectHistoryType.js";

window.addEventListener("DOMContentLoaded", (e) => {

    new selectHistoryType($('#List'));   
  });

