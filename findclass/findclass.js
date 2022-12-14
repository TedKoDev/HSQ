import {$} from '/utils/querySelector.js';
import { getMyUtc } from '../utils/getMyUtc.js';
import { classfilter } from './classfilter.js';

// 로컬스토리지 가져와서 값이 있을 경우 request_to_server에 대입해주기
const filter_json = localStorage.getItem("filter_json");

if (filter_json != null) {

  request_to_server = JSON.parse(filter_json);
}

// 서버 전송 용도의 json에 timezone 넣기
const user_timezone = await getMyUtc(getCookie(cookieName));
request_to_server.user_timezone = user_timezone;

// 더보기 버튼
const see_more_btn = $('#see_more');

// 수업 정보 가져오기
getClassinfo(request_to_server);

// 모든 수업 목록 가져오기 
export async function getClassinfo(json) {    
   
    // 기존 수업 목록 초기화
    const class_list = document.getElementById("class_list");    
    while(class_list.firstChild) {
      class_list.removeChild(class_list.firstChild);  
    }

    // 더보기 버튼 안 보이게 처리    
    see_more_btn.style.display = 'none';
     
      const res = await fetch('../restapi/classinfo.php', {
        method: 'POST',   
        headers: {
            'Content-Type': 'application/json;'
          },
        body: JSON.stringify(json)          
      });  
    
      // 받아온 json 파싱하고 array 추출
      const response = await res.json();  

      // 요청 성공했을 때만 수업 목록 화면에 표시
      if (response.success == "yes") {
       
        setClassinfo(response);
        
        if (response.result.length != 0) {

          // 더보기 버튼 보이게 처리    
          see_more_btn.style.display = 'block';
        }
        
      }
      else {
        console.log("서버 통신 오류");
      }

    

}

// 더보기 클릭
// 처음 화면 출력할 때는 0으로 세팅
let more_num = 0;

see_more_btn.addEventListener('click', see_more);


async function see_more() {

    // 클릭할 때마다 1씩 증가
    more_num = more_num + 1;
        
    console.log(more_num);
    const body = {
      kind: 'clist',
      plus : more_num,
    };
   
    const res = await fetch('../restapi/classinfo.php', {
        method: 'POST',   
        headers: {
            'Content-Type': 'application/json;'
          },
        body: JSON.stringify(body)    
    });  
  
    // 받아온 json 파싱하고 array 추출
    const response = await res.json();  

    
  
    // array에 있는 데이터 세팅
    setClassinfo(response);
}

// 서버에서 받아온 수업 목록 표시;

function setClassinfo(response) {
  
    const class_list = document.getElementById("class_list");        

    let res_array = response.result;    

    // 수업 개수만큼 반복문 돌린 후 태그 생성하여 화면에 표시
    for (let i = 0; i < res_array.length; i++) {

        let class_id = res_array[i].class_id;
        let teacher_id = res_array[i].user_id_teacher;
        let clname = res_array[i].class_name;
        let cldisc = res_array[i].class_description;
        let cltype = res_array[i].class_type;
        let cllevel = res_array[i].class_level;
        let user_name = res_array[i].user_name;
        let user_img = res_array[i].user_img;
        let price_30 = res_array[i].tp[0].class_price;

        // 유저 이미지 값이 없으면 디폴트 이미지로 표시 표시
        if (user_img == 'default' || user_img == null) {
            user_img = "../images_forHS/userImage_default.png"
        }
        else {
            user_img = s3_url+"Profile_Image/"+user_img;
        }
        
        // 태그 생성하고 id에 해당 유저의 id 대입
        const div = document.createElement("div");
        div.setAttribute("id", class_id);

        div.innerHTML = [
            '<a href = "../classdetail/" class = "hover:bg-gray-200">',            
                '<div class = "hover:shadow-lg-gray-200 flex flex-col bg-gray-50 border border-gray-400 rounded-lg py-2 px-4 mb-2">',
                    '<div class = "mb-3">'+clname+
                    '</div>',
                    '<p class = "text-xs text-gray-700 mb-3 line_clamp_2">'
                        +cldisc+'</p>',
                    '<div id = '+class_id+'_t_l'+' class = "items-center">',                                              
                    '</div>',
                    '<div class = "mr-auto mt-3 w-full">',                        
                        '<div class = "flex items-center justify-between">',
                            '<div class = "flex items-center">',
                              '<img id = "profile_image" class = "w-9 h-9 border-3 border-gray-900 rounded-full "', 
                                  'src = '+user_img+'>',
                              '</img>',
                              '<div class = "text-xs text-gray-700 ml-3"><span>'+user_name+'</span>님의 수업</div>',
                            '</div>',
                            '<div>',
                              '<span class = "text-base ">$ '+price_30+' USD</span>',
                            '</div>',
                        '</div>',                    
                    '</div>',
                '</div>', 
            '</a>',
          ].join(""); 
    
        class_list.appendChild(div);

        // 수업 레벨 넣기
        if ((cllevel != 'default') && (cllevel != null)) {  
            
            const level_div = document.getElementById(class_id+"_t_l"); 
            const level_span = document.createElement('span');
            
            const level = cllevel.replace('_', ' - ');

            level_span.innerHTML = ['<span class = " text-xs mr-2">'+level+'<span/>'].join("");

            level_div.appendChild(level_span);
        } 

        // 수업 유형 파싱해서 넣기
        if ((cltype != 'default') && (cltype != null)) {  
            
            let type_div = document.getElementById(class_id+"_t_l"); 

            let type_string = cltype;            
        
            let type_array = type_string.split(',');
           
            for (let j = 0; j < type_array.length; j++) {

                let type_list = document.createElement('span');          
                type_list.innerHTML = ['<span class = "text-xs ml-1 bg-gray-300 text-gray-800 mr-2 rounded-lg px-2">'+type_array[j]+'</span>'].join("");
                type_div.appendChild(type_list);  
            }                                
                         
        } 

        // 클릭하면 수업 id랑 강사 id 전달
        moveClassdetail(div, class_id, teacher_id)
    }
}

// 수업 상세 화면으로 이동하면서 수업 id 전달
function moveClassdetail(div, class_id, teacher_id) {

    // 수업 id, 강사 id localstorage로 전달
    const c_and_t_info = {
  
      class_id : class_id,
      teacher_id : teacher_id,
    }
    
    div.addEventListener('click', () => {
     
     localStorage.setItem("c_and_t_id", JSON.stringify(c_and_t_info));     
    });
  }

// 필터와 관련된 코드 가져오기
classfilter();







