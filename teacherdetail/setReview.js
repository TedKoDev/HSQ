import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import {$, $_all} from "/utils/querySelector.js";

let page_review = 0;
let reviewList = await getReviewList(page_review);
let totalLength;

showReviewList(reviewList);

async function showReviewList(reviewList) {

    const result = reviewList.result;
    totalLength = reviewList.length;
    
    if (totalLength == 0 ) {

        $('.see_more').classList.add('hidden');
        $('.reviewList').classList.remove('shadow');
        $('.reviewList').classList.remove('bg-gray-50');
        $('.reviewList').innerHTML = `
            <div class = "flex flex-col bg-gray-200 px-2 py-2 rounded-lg mx-1 w-full">
                <span class = "mx-auto text-sm text-gray-800 py-1">등록된 후기가 없습니다</span>
            </div>`;
    } 
    for (let i = 0; i < result.length; i++) {

        const user_name = result[i].user_name;
        const user_img = result[i].user_img;
        const student_review = result[i].student_review;
        const student_review_date = result[i].student_review_date;
        const student_review_star = result[i].student_review_star;
        const review_id = result[i].class_student_review_id;

        let src;
        if (user_img == null || user_img == 'default') {
            src = 'https://www.hangeulsquare.com/images_forHS/userImage_default.png'; 
        }
        else {
            src = s3_url + "Profile_Image/" + user_img;
        }
        
        const div = document.createElement("div");
        div.setAttribute("class", "w-1/2 py-2 px-1");
        div.innerHTML = `            
            <div class = "flex flex-col bg-gray-200 px-2 py-2 rounded-lg mx-1">
                <div class = "flex items-center">
                    <img
                        id="profile_image"
                        class="w-8 h-8 border border-gray-700 rounded-full "
                        src=${src}>
                    </img>                        
                    <span class = "text-sm text-gray-700 ml-2">${user_name}</span>                          
                </div>            
                <span class="relative text-gray-400 text-xl">
                    ★★★★★
                    <span class = "addStar_${review_id} text-xl w-0 absolute left-0 text-orange-500 overflow-hidden pointer-events-none">★★★★★</span>
                    <input class = "addStar_value_${review_id} w-full h-full absolute left-0 opacity-0 cursor-pointer" type="range" value=${student_review_star} step="1" min="0" max="10">
                </span>
                <span class = "text-xs text-gray-700 mt-1">${student_review}</span>   
                <span class = "small_text text-xs text-gray-600 mt-1">${dayjs(student_review_date).format('YYYY년 MM월 DD일 HH:mm')}</span>  
            </div>                 
            `;

        $('.reviewList').appendChild(div);

        $('.addStar_'+review_id).style.width = `${$('.addStar_value_'+review_id).value * 10}%`;
    }

}
async function getReviewList(page_review) {
    
    console.log(page_review);
    const body = {

        token: getCookie(cookieName),
        kind: 'review_teacher',      
        plus: page_review,
        row: 6,
    };   
    
    const res = await fetch('/restapi/review.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });    
    
    const response = await res.json();  

    return response;
}

// 더보기 클릭 시 페이징
async function see_more(page_review) {
      
    let reviewList = await getReviewList(page_review);

    showReviewList(reviewList);   

    if (parseInt(totalLength / 6) == page_review) {

        $('.see_more').classList.add('hidden');
    }
}
$('.see_more').addEventListener('click', () => {

    page_review = page_review + 1;

    see_more(page_review);
})