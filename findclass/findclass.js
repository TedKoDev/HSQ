

// 첫 화면에서는 모든 수업 정보 가져오기
getClassinfo_all();

// 모든 수업 목록 가져오기 
async function getClassinfo_all() {

    const body = {
        kind: 'clist'

      };
     
      const res = await fetch('../restapi/classinfo.php', {
        method: 'POST',   
        headers: {
            'Content-Type': 'application/json;'
          },
        body: JSON.stringify(body)          
      });  

      console.log("ss");
    
      // 받아온 json 파싱하고 array 추출
      const response = await res.json();  
      
      console.log(response);

      // 요청 성공했을 때만 수업 목록 화면에 표시
      if (response.success == "yes") {

        setClassinfo(response);
      }
      else {
        console.log("서버 통신 오류");
      }

    // 더보기 버튼 보이게 처리
    const see_more = document.getElementById("see_more");
    see_more.style.display = 'block';

}

// 더보기 클릭
// 처음 화면 출력할 때는 0으로 세팅
let more_num = 0;
async function see_more() {

    // 클릭할 때마다 1씩 증가
    more_num = more_num + 1;
        
    const body = {

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

    let res_array = response.result;

    console.log(res_array);
    let class_list = document.getElementById("class_list");

    // 수업 개수만큼 반복문 돌린 후 태그 생성하여 화면에 표시
    for (let i = 0; i < res_array.length; i++) {

        let class_id = res_array[i].class_id;
        let teacher_id = res_array[i].tusid;
        let clname = res_array[i].clname;
        let cldisc = res_array[i].cldisc;
        let cltype = res_array[i].cltype;
        let cllevel = res_array[i].cllevel;
        let user_name = res_array[i].U_Name;
        let user_img = res_array[i].U_D_Img;

        // 유저 이미지 값이 없으면 디폴트 이미지로 표시 표시
        if (user_img == 'default' || user_img == null) {
            user_img = "../images_forHS/userImage_default.png"
        }
        else {
            user_img = "../editprofile/image/"+user_img;
        }
        
        // 태그 생성하고 id에 해당 유저의 id 대입
        const div = document.createElement("div");
        div.setAttribute("id", class_id);

        div.innerHTML = [
            '<a href = "../classdetail/classdetail.php" class = "hover:bg-gray-200">',            
                '<div class = "hover:shadow-lg-gray-200 flex flex-col bg-gray-50 border border-gray-400 rounded-lg py-2 px-4 mb-2">',
                    '<div class = "mb-3">'+clname+
                    '</div>',
                    '<p class = "text-xs text-gray-700 mb-3 line_clamp_2">'
                        +cldisc+'</p>',
                    '<div id = '+class_id+'_t_l'+' class = "items-center">',                                              
                    '</div>',
                    '<div class = "mr-auto mt-3">',
                        '<div class = "flex items-center">',
                            '<img id = "profile_image" class = "w-9 h-9 border-3 border-gray-900 rounded-full "', 
                                'src = '+user_img+'>',
                            '</img>',
                            '<div class = "text-xs text-gray-700 ml-3"><span>'+user_name+'</span>님의 수업</div>',
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

