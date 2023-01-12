import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import { goClassDetail } from "../classhistory/src/pages/classlist.js";
import { settingPaging, btnCheck } from "../classhistory/src/pages/feedbacklist.js";

// 해당 유저 정보 가져오기
getUserInfo();
async function getUserInfo() {

    const body = {
        
        kind: "udetail",
        user_id: user_id
    };
    const res = await fetch('/restapi/userinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(body)
    });
    
    const response = await res.json();  
    
    console.log(response);   
    
    const result = response.result[0];
            
    const user_name = result.user_name;
    const user_language = result.user_language;
    const user_korean = result.user_korean;
    const user_residence = result.user_residence;
    const user_img = result.user_img;
    const student_timezone = result.user_timezone;

    $('.user_name').innerText = user_name;
    $('.user_residence').innerText = user_residence;
    $('.user_korean').innerText = user_korean;
    $('.user_img').src = s3_url + "Profile_Image/" + user_img;
    $('.student_utc').innerText = student_timezone+":00";
    setUserLanguage(user_language, $('.user_language'));
}

function setUserLanguage(value, $user_language) {

    value = JSON.parse(value);        
               
        for (let key in value) {

          let language_list = document.createElement('span');          
          language_list.innerHTML = ['<span class = "mr-2 text-xs text-gray-500">'+key+' : '+value[key]+'</span>'].join("");
          $user_language.appendChild(language_list);              
        }               
}


// 수업 목록 가져오기
const body = {
    
    token: getCookie(cookieName),       
    user_id_student: user_id,
  };

const res = await fetch('/restapi/studentinfo.php', {
method: 'POST',
headers: {
    'Content-Type': 'application/json;charset=utf-8'
},
body: JSON.stringify(body)
});  

const response = await res.json();  


if (response.success == 'yes') {

    console.log(response);
    const result = response.result;  
    const totalLength = response.length; 

    $('.class_count').innerHTML = result.length;
    
    for (let i = 0; i < result.length; i++) {

        const class_register_id = result[i].class_register_id;
        const class_name = result[i].class_name;
        const class_date = result[i].schedule_list;
        const class_time = result[i].class_time;
        const student_review = result[i].student_review;
        const student_review_date= result[i].student_review_date;
        const student_review_star = result[i].student_review_star;
        const teacher_review = result[i].teacher_review;
        const teacher_review_date = result[i].teacher_review_date;

        const start_time = dayjs(parseInt(class_date));
        const end_time = dayjs(parseInt(class_date)).add(parseInt(class_time), "minute");

        const date = dayjs(parseInt(class_date)).format('YYYY년 MM월 DD일')+" "+start_time.format('HH:mm')+" - "+end_time.format('HH:mm');

        const div = document.createElement('div');
        div.innerHTML = `
                <div class = "flex flex-col border-b-2 pt-2 pb-4">
                    <button class = "btn_${i} hover:bg-gray-300 rounded-lg mb-3 py-2 px-1">
                        <div class = "flex text-xs">
                            <span>${class_name} </span><span class = "mx-1">|</span><span class = "text-gray-600">${date}</span>
                        </div>   
                    </button>                 
                    <span class="text-xs text-gray-800 px-1">강의 피드백</span>                       
                    <div id = feedback_${i} class = "flex flex-col text-xs bg-gray-200 rounded-lg mt-1 px-2 py-2 mb-2">
                        
                    </div>           
                    <div class = "flex flex-col mt-2">
                        <span class="text-xs text-gray-800 px-1">수업 후기</span>   
                        <div id = review_${i} class="flex flex-col bg-gray-200 rounded-lg px-2 mt-1">   
                            
                        </div>                     
                    </div>
                </div>`;
        
            $('.classList').appendChild(div);  
        
        if (student_review == null) {
            $('#review_'+i).innerHTML = `            
            <span class = "mx-auto text-xs text-gray-700 py-3">등록된 후기가 없습니다</span>                                         
            `;
        }
        else {
            $('#review_'+i).innerHTML = `
            <div class = "flex flex-col mt-1 mb-2">      
                <span class="relative text-gray-400 text-xl">
                    ★★★★★
                    <span class = "addStar_${i} text-xl w-0 absolute left-0 text-orange-500 overflow-hidden pointer-events-none">★★★★★</span>
                    <input class = "addStar_value_${i} w-full h-full absolute left-0 opacity-0 cursor-pointer" type="range" value=${student_review_star} step="1" min="0" max="10">
                </span>
                <span class = "text-xs text-gray-800">${student_review}</span>
                <span class = "date text-xs mt-1 text-gray-600">${dayjs(parseInt(student_review_date)).format('YYYY년 MM월 DD일 HH:mm')}</span>
            </div>                     
            `;

            $('.addStar_'+i).style.width = `${$('.addStar_value_'+i).value * 10}%`;
        }
        if (teacher_review == null) {
            $('#feedback_'+i).innerHTML = `            
            <span class = "mx-auto text-xs text-gray-700 hover:bg-blue-600 py-3">등록된 피드백이 없습니다</span>                                         
            `;
        }
        else {
            $('#feedback_'+i).innerHTML = `
            <span>${teacher_review}</span>
            <span class = "date text-xs mt-1 text-gray-600">${dayjs(parseInt(teacher_review_date)).format('YYYY년 MM월 DD일 HH:mm')}</span>`;
        } 

        $('.btn_'+i).addEventListener('click', () => {

            goClassDetail(class_register_id, user_id, '/teacherpage/classhistory/historydetail/');
        })
    }

    // 페이징 버튼 세팅
    settingPaging($('.classList'));

    // 이전/다음 버튼 클릭 시 이벤트
    $('.prevBtn').addEventListener('click', () => {

    page = page - 1;
    paging('page', page, '/teacherpage/studentdetail/', user_id);

    })
    $('.nextBtn').addEventListener('click', () => {

    page = page + 1;
    paging('page', page, '/teacherpage/studentdetail/', user_id);

    })
        
    btnCheck(page, $('.prevBtn'), $('.nextBtn'), parseInt(totalLength), result);
    
}
else {
    console.log('통신 오류');
}

function paging(key, value, url, user_id) {

  const form = document.createElement('form');
  form.setAttribute('method', 'get');    
  form.setAttribute('action', url);

  const hiddenField_page = document.createElement('input');
  hiddenField_page.setAttribute('type', 'hidden');
  hiddenField_page.setAttribute('name', key);
  hiddenField_page.setAttribute('value', value);  
  form.appendChild(hiddenField_page); 

  const hiddenField_user = document.createElement('input');
  hiddenField_user.setAttribute('type', 'hidden');
  hiddenField_user.setAttribute('name', 'user_id');
  hiddenField_user.setAttribute('value', user_id);  
  form.appendChild(hiddenField_user); 

  document.body.appendChild(form);

  form.submit();   
}
