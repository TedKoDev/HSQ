import { $} from "/utils/querySelector.js";
import {selectHistoryType} from "../src/selectHistoryType.js";

window.addEventListener("DOMContentLoaded", (e) => {

    new selectHistoryType($('#List'));   
  });
