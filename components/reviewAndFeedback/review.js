import { $, $_all } from "/utils/querySelector.js";
import {s3_url} from "/commenJS/cookie_modules.js"; 

// 수업 리뷰 컴포넌트
export function setReview($div, name, img, review_text, review_star, review_date) {

    $div.innerHTML = `
    <div class="flex w-full bg-gray-100 rounded-lg py-2">
        <div class="flex items-center pl-2 w-40">
            <img class="tool_image w-5 h-5 rounded-full" src="${s3_url}Profile_Image/${img}"></img>
            <div class="flex flex-col ml-2">
                <span class="user_name text-xs text-gray-800">${name}</span>
                <span class="review_date text-xs text-gray-500">${dayjs(review_date).format('YYYY년 MM월 DD일')}</span>
                <div></div>
                <div class="flex flex-col"></div>
            </div>
            <hr class="bg-gray-300 border border-1">
        </div>
        <div class="flex flex-col ml-2 px-1 w-4/5">   
            <div class = "">      
                <span class="relative text-gray-400 text-xl">
                    ★★★★★
                    <span class = "addStar text-xl w-0 absolute left-0 text-orange-500 overflow-hidden pointer-events-none">★★★★★</span>
                    <input class = "addStar_value w-full h-full absolute left-0 opacity-0 cursor-pointer" type="range" value="${review_star}" step="1" min="0" max="10">
                </span>
            </div>                     
            <span class = "text-xs ml-1">${review_text}</span>
        </div>
    </div>`;

    $('.addStar').style.width = `${$('.addStar_value').value * 10}%`;
    
}

export function setNonReview($div, check) {

    $div.innerHTML = `
        <div class="flex flex-col justify-center w-full bg-gray-100 rounded-lg py-2 mx-auto">
            <span class = "mx-auto text-sm text-gray-800 mb-1">등록된 후기가 없습니다</span>  
            <span class = "desc mx-auto text-xs text-gray-800 mb-1"></span>                             
        </div>`;
    
    if (check == 'student') {
        $('.desc').innerHTML = '완료된 수업만 후기 등록이 가능합니다.';
    }
    else {
        $('.desc').remove();
    }
}