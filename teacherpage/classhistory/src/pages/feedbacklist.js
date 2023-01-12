import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import { changeSelectBtnStyle, getFilterInit } from "./pages.js";
import { $, $_all } from "/utils/querySelector.js";
import { goClassDetail } from "./classlist.js";

export function feedbacklist($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {            

      // 수업 목록의 필터 부분 초기화
      getFilterInit($('.filter'));

      changeSelectBtnStyle($('#myfeedbackList'), $_all(".historyType"));

      showFeedbackList($container);
    };
  
    this.render();
}

async function showFeedbackList($container) {
  
  $container.innerHTML = "";
  $container.setAttribute("class", "bg-gray-50 rounded-lg py-2"); 
  $('.filter').classList.add('hidden');

  // 피드백 목록 가져와서 대입
  const feedbackList = await getfeedbacklist();

  // 값이 있을 경우에만 화면에 뿌려주기
  if (feedbackList.result.length != 0) {
    
    let totalLength = feedbackList.length; // 전체 개수

    const result = feedbackList.result;
    
    for (let i = 0; i < result.length; i++) {

      const class_register_id = result[i].class_register_id;
      const class_name = result[i].class_name;
      const class_time = result[i].class_time;
      const teacher_review = result[i].teacher_review;
      const teacher_review_date = result[i].teacher_review_date;
      const class_schedule_time = result[i].schedule_list;
      const student_id = result[i].user_id;
      const student_name = result[i].user_name;
      const student_img = result[i].user_img; 
      
      const review_date = dayjs(teacher_review_date).format('YYYY/MM/DD HH:mm');
      const ImgLink = s3_url + "Profile_Image/" + student_img;

      const start_time = dayjs(parseInt(class_schedule_time));
      const end_time = start_time.add(parseInt(class_time), "minute");      
      
      const div = document.createElement("div");
      div.innerHTML = `
      <div class="bg-gray-200 rounded-lg shadow px-3 py-2 my-2 mx-2">
        <div class = "flex items-center text-xs text-gray-700">
            <span class = "">To : </span>
            <img id = "profile_image" class = "mx-1 w-6 h-6 border-2 border-gray-900 rounded-full" 
                src = ${ImgLink}></img>
            <span>${student_name}</span>
            <span class = "mx-1"> | </span>
            <span class = "text-gray-500">${review_date}</span>
        </div>
        <div class = "mt-2 text-sm text-gray-700">${teacher_review}</div>
        <button class = "button_${class_register_id} text-xs mt-1 rounded-lg px-2 py-1 bg-gray-100 hover:bg-gray-300 border-0 shadow">
            <span class = "text-gray-700">${class_name}</span><span class = "ml-1 text-gray-500">${start_time.format('HH:mm')} - ${end_time.format('HH:mm')}</span>
        </button>
      </div>`;

      $container.appendChild(div);   

      $('.button_'+class_register_id).addEventListener('click', () => {

        goClassDetail(class_register_id, student_id, '/teacherpage/classhistory/historydetail/');
      })      
    }

    
      // 페이징 뷰 표시하는 로직
      settingPaging($container);

      // 이전/다음 버튼 클릭 시 이벤트
      $('.prevBtn').addEventListener('click', () => {

        page_feedback = parseInt(page_feedback) - 1;
        paging('page', page_feedback, '/teacherpage/classhistory/feedbacklist/');

      })
      $('.nextBtn').addEventListener('click', () => {

        page_feedback = parseInt(page_feedback) + 1;
        paging('page', page_feedback, '/teacherpage/classhistory/feedbacklist/');

      })
            
      btnCheck(page_feedback, $('.prevBtn'), $('.nextBtn'), totalLength, 10);
  }
  else {

  }
}

export function settingPaging($container) {

  const pagingDiv = document.createElement("div");  
      pagingDiv.setAttribute("class", "flex mt-5");      
      pagingDiv.innerHTML = ` <div class = "pagination flex ml-auto pr-2 mb-1">
                                  <span class = "prevBtn px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow mr-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/></svg>
                                  </span>
                                  <ol id = "numbers">
                                      
                                  </ol>
                                  <span class = "nextBtn px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow ml-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg>
                                  </span>
                              </div>`;
          
      $container.appendChild(pagingDiv);
}     


export function paging(type, page, url) {
        
  const form = document.createElement('form');
  form.setAttribute('method', 'get');    
  form.setAttribute('action', url);

  const hiddenField_page = document.createElement('input');
  hiddenField_page.setAttribute('type', 'hidden');
  hiddenField_page.setAttribute('name', type);
  hiddenField_page.setAttribute('value', page);  
  form.appendChild(hiddenField_page); 

  document.body.appendChild(form);

  form.submit();      
  
}

// 이전/다음 버튼 보이는 여부 체크
export function btnCheck(page, $prev_btn, $next_btn, totalLength, row) {

  if (page == '' || page == null) {
    page = 0;

  }  

  if (page == 0) {
    $prev_btn.setAttribute("class", "prevBtn hidden px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow mr-1");
    console.log("prev_x");
  }
  else {
    $prev_btn.setAttribute("class", "prevBtn px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow mr-1");
    console.log("prev_o");
  }
  if ((parseInt(totalLength / row) == parseInt(page))) {
    $next_btn.setAttribute("class", "nextBtn hidden px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow ml-1");
    console.log("next_x");
  }
  else if ((parseInt(totalLength / row) == (parseInt(page)+1)) && (parseInt(totalLength) % row == 0)) {
    $next_btn.setAttribute("class", "nextBtn hidden px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow ml-1");
    console.log("next_x");
  }
  else {
    $next_btn.setAttribute("class", "nextBtn px-2 py-2 bg-gray-200 hover:bg-gray-400 rounded-md shadow ml-1");
    console.log("next_o");
  }
}

async function getfeedbacklist() {   
        
  if (page_feedback == null) {
    page_feedback = 0;
  }
  let body = {

      token: getCookie(cookieName),
      kind: 'feedback_teacher',     
      plus: page_feedback,   
      row: 10,
      
      
  };   
  
  const res = await fetch('/restapi/review.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify(body)
  });    
  
  const response = await res.json();        
  console.log(response);
  return response;  
}


export default feedbacklist;