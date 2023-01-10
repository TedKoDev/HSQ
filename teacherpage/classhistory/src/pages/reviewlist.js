import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import { changeSelectBtnStyle, getFilterInit } from "./pages.js";
import { $, $_all } from "/utils/querySelector.js";
import { goClassDetail } from "./classlist.js";

export function reviewlist($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
    
      // 수업 목록의 필터 부분 초기화
      getFilterInit($('.filter'));

      changeSelectBtnStyle($('#reviewList'), $_all(".historyType"));

      showReviewList($container);
    };
  
    this.render();
}

async function showReviewList($container) {

  // $container.innerHTML = "";
  // $container.setAttribute("class", "bg-gray-50 rounded-lg");

  const reviewList = await getreviewlist();

  console.log(reviewList);

  // 값이 있을 경우에만 화면에 뿌려주기
  if (reviewList.length != 0) {
    
    for (let i = 0; i < reviewList.length; i++) {

      const class_register_id = reviewList[i].class_register_id;
      const class_name = reviewList[i].class_name;
      const class_time = reviewList[i].class_time;
      const review = reviewList[i].student_review;
      const review_date = reviewList[i].student_review_date;
      const class_schedule_time = reviewList[i].schedule_list;
      const student_id = reviewList[i].user_id;
      const student_name = reviewList[i].user_name;
      const student_img = reviewList[i].user_img; 
      const student_review_star = reviewList[i].student_review_star;

      const date = dayjs(review_date).format('YYYY/MM/DD HH:mm');
      const ImgLink = s3_url + "Profile_Image/" + student_img;

      const start_time = dayjs(parseInt(class_schedule_time));
      const end_time = start_time.add(parseInt(class_time), "minute");
      
      console.log(student_review_star);
      
      const div = document.createElement("div");
      div.innerHTML = `
                <div class="flex bg-gray-200 rounded-lg shadow px-3 py-2 my-2 mx-2">
                    <div class = "flex mt-2">
                        <img id = "profile_image" class = "mx-1 w-6 h-6 border-2 border-gray-900 rounded-full" 
                            src = ${ImgLink}>
                        </img>
                        <div class = "flex flex-col text-xs">
                            <span class = "text-gray-700">${student_name}</span>
                            <span class = "text-gray-500">${date}</span>   
                        </div>
                    </div>
                    <div class = "flex flex-col ml-4 mr-2">
                        <div>
                            <span class="relative text-gray-400 text-xl">
                            ★★★★★
                                <span class = "star text-xl w-0 absolute left-0 text-orange-500 overflow-hidden pointer-events-none">★★★★★</span>
                                <input class = "star_value w-full h-full absolute left-0 opacity-0 cursor-pointer" type="range" value="${parseInt(student_review_star)}" step="1" min="0" max="10">
                            </span>
                        </div>
                        <span class = "text-sm text-gray-700 my-1">${review}</span>
                        <div>
                        <button class = "button_${class_register_id} text-xs mt-1 rounded-lg px-2 py-1 bg-gray-100 hover:bg-gray-300 border-0 shadow">
                            <span class = "text-gray-700">${class_name}</span><span class = "ml-1 text-gray-500">${start_time.format('HH:mm')} - ${end_time.format('HH:mm')}</span>
                        </button>
                        </div>
                    </div>
                </div>     `;      

      $container.appendChild(div);   

      $('.star').style.width = `${$('.star_value').value * 10}%`;

      $('.button_'+class_register_id).addEventListener('click', () => {

        goClassDetail(class_register_id, student_id, '/teacherpage/classhistory/historydetail/');
      })
      
    }
  }
  else {

  }
}

async function getreviewlist() { 
        
  let body = {

      token: getCookie(cookieName),
      kind: 'review_teacher',        
  };   
  
  const res = await fetch('/restapi/review.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(body)
  });    
  
  const response = await res.json();        
  
  return response.result;  
}

export default reviewlist;