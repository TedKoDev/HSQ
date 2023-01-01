// 가져올 정보
// - 강사 Id
// - 강사 프로필 이미지
// - 강사 이름
// - 강사 자격
// - 강사의 구사 가능 언어 및 구사 수준
// - 강사 소개
// - 수업료 (등록한 수업중 가장 저렴한 가격)

// 쿠기 값(토큰) 가져오기
let tokenValue = getCookie(cookieName);   
// 토큰 서버에 전송

sendToken();

// 화면 모두 로드되면 토큰 보내서 유저 정보 받아오기
async function sendToken() {     
       
  // 서버에 토큰값 전달
  postToken(tokenValue);
 
}

// 토큰값을 서버로 전달한 뒤 유저 정보 받아오기
async function postToken(tokenValue) {

  const value = tokenValue;     

  const body = {
    
    token : value,
  };
 
  const res = await fetch('./findteacherProcess.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;'
    },
    body: JSON.stringify(body)
  });  

  // 받아온 json 파싱하고 array 추출
  const response = await res.json();  
  
  console.log(response);
  // array에 있는 데이터 세팅
  setData(response);
  
  // 더보기 버튼 보이게 처리
  const see_more = document.getElementById("see_more");
  see_more.style.display = 'block';
}

function setData(response) {

    let res_array = response.data;  

    let teacher_list = document.getElementById("teacher_list");

  // array 개수만큼 반복문 돌려서 태그 생성한다음 대입
  for (let i = 0; i < res_array.length; i++) {

    let User_Id = res_array[i].user_id;
    let U_D_Img = res_array[i].user_img;
    let U_Name = res_array[i].user_name;
    let U_T_Special = res_array[i].teacher_special;
    let U_D_Language = res_array[i].user_language;
    let U_T_Intro = res_array[i].teacher_intro;
    let Price = res_array[i].class_price;
    let class_id = res_array[i].class_id;

    console.log(U_T_Special);

    if (U_T_Special == 'default') {
        U_T_Special = "커뮤니티 튜터";
    }
    else {
        U_T_Special = "전문 강사";
    }

    if (U_D_Img == 'default' || U_D_Img == null) {
        U_D_Img = "../images_forHS/userImage_default.png"
    }
    else {
        U_D_Img = s3_url+"Profile_Image/"+U_D_Img;
    }

    // 태그 생성하고 id에 해당 유저의 id 대입
    const div = document.createElement("div");
    div.setAttribute("id", User_Id);
    // div.setAttribute("href", "../teacherdetail/teacherdetail.php");

    div.innerHTML = [
      '<a class = "" href = "../teacherdetail/">',
        '<div class = "flex mb-2 bg-gray-50 rounded-lg border border-gray-400">',
            '<div class = "flex flex-col w-1/6 py-2">',
                '<img id = "profile_image" class = "mx-auto w-20 h-20 border-3 border-gray-900 rounded-full "', 
                        'src = '+U_D_Img+'>',
                '</img>',
                '<div class= "mx-auto">평점</div>',
                '<div class= "mx-auto">수업 횟수</div>',
                '</div>',                
                '<div class = "flex flex-col w-5/6 mx-auto px-4 py-2">',
                    '<div class = "font-semibold">'+U_Name+'</div>',
                    '<div class = "text-gray-500">'+U_T_Special+'</div>',
                    '<div id = "'+User_Id+'_l'+'" class = "flex">',
                        '<div>Speaks : </div>',
                    '</div>',                                      
                    '<div class = "mt-2">'+U_T_Intro+'</div>',
                    '<div class = "ml-auto">$ '+Price+'</div>',
                '</div>',
            '</div>',
      '</a>',
    ].join("");    

    teacher_list.appendChild(div);

    // 구사 가능 언어 파싱해서 넣기
    if ((U_D_Language != 'default') && (U_D_Language != null)) {  
        
        let l_parse = JSON.parse(U_D_Language);
       
        let l_list = document.getElementById(User_Id+'_l');
        
        for (let key_l in l_parse) {

          let language_list = document.createElement('span');          
          language_list.innerHTML = ['<span class = "mr-1 ml-1">'+key_l+'</span>'].join("");
          // l_list.appendChild(language_list);     
          l_list.appendChild(language_list);              
        }                 
                             
      }       
      else {
        // key.innerText = "";
      }

      // 생성한 div 클릭 시 강사 상세 화면으로 이동하면서 유저 id 전달
      move_teacher_detail(div, User_Id);
  } 
}

function move_teacher_detail(div, user_id) {

  // 유저 id localstorage로 전달
  const user_info = {

    id : user_id,
  }
  
  div.addEventListener('click', () => {
   
   localStorage.setItem("user_id", JSON.stringify(user_info));
  });
}

// 더보기 클릭
// 처음 화면 출력할 때는 0으로 세팅
let more_num = 0;
async function see_more() {

  // 클릭할 때마다 1씩 증가
  more_num = more_num + 1;

  const value = tokenValue;     

  const body = {
    
    token : value,
    plus : more_num,
  };
 
  const res = await fetch('./findteacherProcess.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;'
    },
    body: JSON.stringify(body)
  });  

  // 받아온 json 파싱하고 array 추출
  const response = await res.json();  

  // array에 있는 데이터 세팅
  setData(response);

}


