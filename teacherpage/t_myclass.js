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
  const response = await res.json();
  console.log(response);
  
}