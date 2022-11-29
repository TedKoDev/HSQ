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

  // array에 있는 데이터 세팅
  setData(response);
  
}

function setData(response) {

    let res_array = response.data;  

    let teacher_list = document.getElementById("teacher_list");

  // array 개수만큼 반복문 돌려서 태그 생성한다음 대입
  for (let i = 0; i < res_array.length; i++) {

    let User_Id = res_array[i].User_Id;
    let U_D_Img = res_array[i].U_D_Img;
    let U_Name = res_array[i].U_Name;
    let U_T_Special = res_array[i].U_T_Special;
    let U_D_Language = res_array[i].U_D_Language;
    let U_T_Intro = res_array[i].U_T_Intro;
    let Price = res_array[i].Price;
    let class_id = res_array[i].class_id;

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
        U_D_Img = "../editprofile/image/"+U_D_Img;
    }

    // 태그 생성하고 id에 해당 유저의 id 대입
    const div = document.createElement("div");
    div.setAttribute("id", User_Id);
    // div.setAttribute("href", "../teacherdetail/teacherdetail.php");

    div.innerHTML = [
      '<a href = "../teacherdetail/teacherdetail.php">',
        '<div class = "flex border-2">',
            '<div class = "flex flex-col border-2 w-1/6 py-2">',
                '<img id = "profile_image" class = "mx-auto w-20 h-20 border-3 border-gray-900 rounded-full "', 
                        'src = '+U_D_Img+'>',
                '</img>',
                '<div class= "mx-auto">평점</div>',
                '<div class= "mx-auto">수업 횟수</div>',
                '</div>',                
                '<div class = "flex flex-col border-2 w-5/6 mx-auto px-4 py-2">',
                    '<div class = "font-semibold">'+U_Name+'</div>',
                    '<div class = "text-gray-500">'+U_T_Special+'</div>',
                    '<div id = "'+User_Id+'_l'+'" class = "flex">',
                        '<div>Speaks : </div>',
                    '</div>',                                      
                    '<div class = "mt-2">'+U_T_Intro+'</div>',
                    '<div class = "ml-auto border-2">$ '+Price+'</div>',
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

    console.log("test");
   localStorage.setItem("user_id", JSON.stringify(user_info));
  });
}

