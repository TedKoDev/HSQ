
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

  const res = await fetch('./regiscallProcess.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;'
    },
    body: JSON.stringify(body)
  });  

  // 받아온 json 파싱
  const response = await res.json();
        
  console.log(response);
  const userinfo_json = JSON.stringify(response);     
  const userinfo_parse = JSON.parse(userinfo_json);

  const user_id = userinfo_parse.user_id;
  const user_name = userinfo_parse.user_name;
  const user_email = userinfo_parse.user_email; 
  const user_p_img = userinfo_parse.user_img; 
  const user_bday = userinfo_parse.user_birthday; 
  const user_sex = userinfo_parse.user_sex; 
  const user_contact = userinfo_parse.user_contact; 
  const user_country = userinfo_parse.user_country; 
  const user_residence = userinfo_parse.user_residence; 
  const user_point = userinfo_parse.user_point; 
  const user_language = userinfo_parse.user_language; 
  // const user_korean = userinfo_parse.user_korean; 
  // const user_teacher = userinfo_parse.teacher_regis_check; 
  // const user_intro = userinfo_parse.teacher_intro; 
  
  // console.log("source : "+user_p_img);
  // 프로필 이미지, 이름, 나이, 성별, 출신국가, 거주국가 대입, 구사 가능 언어, 한국어 구사 수준 대입
  let p_img = document.getElementById("profile_image");
  let name = document.getElementById("name"); 
  let bday = document.getElementById("bday"); 
  let sex = document.getElementById("sex"); 
  let country = document.getElementById("country"); 
  let residence = document.getElementById("residence"); 
  let intro_t = document.getElementById("intro_t");
  let language = document.getElementById("language");  

  // 이름, 자기소개는 그냥 출력하고 나이, 성별, 출신/거주 국가는 값이 있을 때만 출력
  name.innerText = user_name;    
  setInfo(p_img, user_p_img, "image");
  setInfo(bday, user_bday, "");
  setInfo(sex, user_sex, "");
  setInfo(country, user_country, "");
  setInfo(residence, user_residence, "");
  // setInfo(intro_t, user_intro, "");
  // setInfo(korean, user_korean, "")
  // intro.innerText = user_intro;      
  setLanguage(language, user_language);

  // 값이 있을 경우에만 브라우저에 출력
  function setInfo(key, value, text) {

    if ((value != 'default') && (value != null)) {        
      
      // 프로필 이미지일 경우
      if (text == 'image') {
        
        key.src = s3_url+"Profile_Image/"+value;;
      }

      else {
        key.innerText = value+text;
      }     
              
    }
    else {
      key.innerText = "";
    }
  }

  // 구사 가능 언어 출력 용 함수
  function setLanguage(key, value) {
      
    
    // 값이 있을 경우에만 등록한 구사 가능 언어 수만큼 화면에 출력
    if ((value != 'default') && (value != null)) {  
      
      let json_parse = JSON.parse(value);
      // // 처음에는 key 값 초기화 (리턴 클릭했을 경우 기존 값들 없애줘야 함)
      // while (key.hasChildNodes())
      // {
      //   key.removeChild(key.firstChild);       
      // }
      
      for (let key_l in json_parse) {

        let language_list = document.createElement('span');          
        language_list.innerHTML = ['<span class = "mr-2">'+key_l+' : '+json_parse[key_l]+'</span>'].join("");
        key.appendChild(language_list);

        // console.log(key_l, value[key_l]);          
      }                 
                           
    }       
    else {
      key.innerText = "";
    }
  }

  // 토큰 input창에 토큰 값 넣기
  let token_input = document.getElementById("token_value");
  token_input.value = tokenValue; 

}

  
// 전문강사 인증 파일 첨부용
let fileNo = 0;
let filesArr = new Array();

/* 첨부파일 추가 */
function addFile(obj){

    // 버튼 클릭 시 기존에 표시되는 파일명 초기화
    // let parent = document.getElementById('file-list');

    // while(parent.firstChild)  {
    //     parent.firstChild.remove();
    // }

    let maxFileCnt = 5;   // 첨부파일 최대 개수
    let attFileCnt = document.querySelectorAll('.filebox').length;    // 기존 추가된 첨부파일 개수
    let remainFileCnt = maxFileCnt - attFileCnt;    // 추가로 첨부가능한 개수
    let curFileCnt = obj.files.length;  // 현재 선택된 첨부파일 개수

    // 첨부파일 개수 확인
    if (curFileCnt > remainFileCnt) {
        alert("첨부파일은 최대 " + maxFileCnt + "개 까지 첨부 가능합니다.");
    }

    for (let i = 0; i < Math.min(curFileCnt, remainFileCnt); i++) {

        const file = obj.files[i];

        // 첨부파일 검증
        if (validation(file)) {
            // 파일 배열에 담기
            let reader = new FileReader();
            reader.onload = function () {
                filesArr.push(file);
            };
            reader.readAsDataURL(file)
            
            let test_div = document.createElement('div');
            
            test_div.innerHTML = [   
                '<div id="file' + fileNo + '">',
                '<p class = "text-gray-600">'+file.name+'</p>',
                '</div>'].join(""); 

            let file_list = document.getElementById('file-list');
            file_list.style.display = 'block';
            file_list.append(test_div);
            fileNo++;    
        } else {
            continue;
        }
    }
    // 초기화
    document.querySelector("input[type=file]").value = "";
}



/* 첨부파일 검증 */
function validation(obj){
    const fileTypes = ['application/pdf', 'image/gif', 'image/jpeg', 'image/png', 'image/bmp', 'image/tif', 'application/haansofthwp', 'application/x-hwp'];
    if (obj.name.length > 100) {
        alert("파일명이 100자 이상인 파일은 제외되었습니다.");
        return false;
    } else if (obj.size > (100 * 1024 * 1024)) {
        alert("최대 파일 용량인 100MB를 초과한 파일은 제외되었습니다.");
        return false;
    } else if (obj.name.lastIndexOf('.') == -1) {
        alert("확장자가 없는 파일은 제외되었습니다.");
        return false;
    } else if (!fileTypes.includes(obj.type)) {
        alert("첨부가 불가능한 파일은 제외되었습니다.");
        return false;
    } else {
        return true;
    }
}

function submitForm() {

  let formData = new FormData();
  formData.append('token', document.getElementById('token_value').value);
  formData.append('teacher_intro', document.getElementById('intro_t').value);
  formData.append('teacher_certification', document.getElementById('certi').value);
  // formData.append('img', document.getElementById('file_upload').files[0]);

    for (var i = 0; i < filesArr.length; i++) {
      // 삭제되지 않은 파일만 폼데이터에 담기
      if (!filesArr[i].is_delete) {
          formData.append("img", filesArr[i]);
      }
  }

  // 같은 사이트에서 한번 새로고침
  fetch('#',{
    method:'POST',
    body : formData
  })
  .then(
    alert("강사 등록되었습니다."),
    location.replace('../teacherpage/t_myclass.php')    
  );
}




