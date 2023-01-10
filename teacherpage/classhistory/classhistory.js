// import { $, $_all } from "/utils/querySelector.js";
// import { cookieName, getCookie } from "/commenJS/cookie_modules.js";
// import {selectHistoryType} from "./src/selectHistoryType.js";

// // 수업 목록 가져오기
// getClasslist();

// async function getClasslist() {
    
//     const classType = $('.classType');
//     const className = $('.className');
//     const userName = $('.userName');
//     const classStart = $('.classStart');
//     const classEnd = $('.classEnd');

    
//     let filterObject = {

//         token: getCookie(cookieName),
//         kind: "tclist",
//         class_reserve_check: "all", 
//     };
    
    
//     if (key_class_type != "") {
//         filterObject.filter_class_status_check = key_class_type;    
//         classType.value = key_class_type;
//     }
//     if (key_user_name != "") {
//         filterObject.filter_user_name = key_user_name;    
//         userName.value = key_user_name;
//         console.log(className);
//     }
//     if (key_class_name != "") {
//         filterObject.filter_class_name = key_class_name;
//         className.value = key_class_name;
//     }
//     if (key_time_from != "") {

//        filterObject.filter_class_resister_time_from = dayjs(key_time_from).valueOf();
//        classStart.value = key_time_from;
//     }
    
//     if (key_time_to != "") {
//         filterObject.filter_class_resister_time_to = dayjs(key_time_to).valueOf();
//         classEnd.value = key_time_to;
//     }

//     console.log(filterObject);

//     const res = await fetch('/restapi/classinfo.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json;charset=utf-8'
//         },
//         body: JSON.stringify(filterObject)
//     });    
    
//     classList_json = await res.json();    
    
//     new selectHistoryType($('#List'));
    
// }





 