// 쿠기 값(토큰) 가져오기
let tokenValue = getCookie(cookieName);   
// 토큰 서버에 전송

console.log("token : "+tokenValue);
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
  
  const res = await fetch('./t_myclassProcess.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;'
    },
    body: JSON.stringify(body)
  });  

  // 받아온 json 파싱
  let response = await res.json();  
  let class_json = JSON.stringify(response);  
  let class_parse = JSON.parse(class_json);
  
  let data = class_parse.data;
  // console.log(class_parse.data);

  // 수업 개수 만큼 반복문 돌린 뒤 태그 생성해서 출력
  let class_list = document.getElementById("class_list");
  for (let i = 0; i < data.length; i++) {

    // 대입할 데이터 파싱
    const class_id = data[i].class_id;
    const clname = data[i].clname;
    const cldesc = data[i].cldisc;
    const clpeoeple = data[i].clpeople;
    const cltype = data[i].cltype;
    const tp = data[i].tp;    

    // 가격 파싱
    const price_30 = tp[0].Price;
    const price_60 = tp[1].Price;
    

    // 수업 뷰 출력을 위한 태그 생성
    const class_div = document.createElement('div');
    // 해당 div의 id로 클래스의 id 매칭하고 스타일 부여
    class_div.setAttribute("id", "class_"+class_id);
    class_div.setAttribute("class", "ml-4 mr-4 bg-gray-200 justify-between rounded-lg my-2");

    const div = document.createElement('div');
    console.log("pass");
    div.innerHTML = [
      '<div class = "flex justify-between">',
        '<div class = "flex flex-col px-4">',
          '<div class = "text-base font-normal mb-3 mt-1">'+clname+'</div>',
          '<div class = "text-sm font-normal mb-2" >'+cldesc+'</div>',
          '<div id = type_'+class_id+' class = "flex mb-2 text-sm">',          
                      
          '</div>',
        '</div>',   
        '<div class = "flex flex-col my-auto px-4">',
          '<div>30분 : <a>'+price_30+' $</a></div>',
          '<div>60분 : <a>'+price_60+' $</a></div>',
        '</div>',
      '</div>'
    ].join("");
   
    class_div.appendChild(div);
    class_list.appendChild(class_div);

     // 수업 유형 배열로 전환
     const type_array = cltype.split(",");

     // 배열 개수만큼 반복문 돌려서 태그 생성 후 대입
     for (let j = 0; j < type_array.length; j++) {
       
      // console.log(type_array[j]);
      const type = document.createElement("a");
      type.setAttribute("class", "bg-gray-500 text-gray-800 mr-2 rounded-lg px-2")
      type.innerHTML = type_array[j];

      const type_div = document.getElementById("type_"+class_id);
      console.log(type_div.value);
      type_div.appendChild(type);
     }
  }
}

// 나의 수업 목록 가져오기
