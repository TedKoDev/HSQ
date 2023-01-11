import { $, $_all } from "/utils/querySelector.js";
import {s3_url} from "/commenJS/cookie_modules.js"; 

// 수업 리뷰 컴포넌트
export function setFeedback($div, name, img, feedback_text, feedback_date) {

    $div.innerHTML = `
    <div class="flex w-40 rounded-lg py-2">
        <div class="flex items-center pl-2">
            <img
                class="tool_image w-5 h-5 rounded-full"
                src="${s3_url}Profile_Image/${img}"></img>
            <div class="flex flex-col ml-2">
                <span class="user_name text-xs text-gray-800">${name}</span>
                <span class="review_date text-xs text-gray-500">${dayjs(feedback_date).format('YYYY년 MM월 DD일')}</span>
                <div></div>
                <div class="flex flex-col"></div>
            </div>
            <hr class="bg-gray-300 border border-1">
            </div>                        
        </div>
    <div class="flex flex-col ml-2 px-1 w-4/5">                            
        <span class="text-xs bg-gray-300 rounded-lg px-2 py-2 my-2">${feedback_text}</span>
    </div>`;       
}

export function setNonFeedback($div, check) {

    $div.innerHTML = `
        <div class="flex flex-col justify-center w-full bg-gray-100 rounded-lg py-2 mx-auto">
            <span class = "mx-auto text-sm text-gray-800 mb-1">등록된 피드백이 없습니다</span>  
            <span class = "desc mx-auto text-xs text-gray-800 mb-1"></span>                             
        </div>`;
    
    if (check == 'teacher') {
        $('.desc').innerHTML = '완료된 수업만 피드백 등록이 가능합니다.';
    }
    else {
        $('.desc').remove();
    }
}