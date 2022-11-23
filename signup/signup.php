<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  </head>    
  <!-- 회원가입 관련 js -->
  <script defer src = "../commenJS/cookie.js"></script> 
  <script src = "./signup2.js"></script>
  
  <script>
  
  </script>
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include '../components/navbar.php' ?>
    <!-- 회원가입 블록 -->
    <br>
    <div class = "max-w-3xl mx-auto">
      <div class = "flex justify-center">
        <div class = "max-w-md mr-8">                  
            <img class = "w-100 h-100 rounded-lg" src = "<?php echo $hs_url; ?>images_forHS/광장.PNG"></img>            
        </div>
        <div class = "flex flex-col max-w-lg bg-gray-50 px-4 py-4 shadow rounded-lg">
          <div>
            <h1 class = "font-bold text-2xl">한글스퀘어 시작하기</h1>
          </div><br>
          <div class = "text-sm">
            기존에 사용하는 계정으로 간단하게 회원가입
          </div>
          <div class = "flex max-w-lg justify-around">
            <button class = " bg-gray-50 hover:bg-gray-200 text-gray-700 py-2 px-2 mt-3 rounded border border-gray-500">
            <a class = "flex items-center">                
                <svg class="w-6 h-6 mr-1 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-5 h-5"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 
                0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                Facebook
            </a>
            </button>
            <button class = " bg-gray-50 hover:bg-gray-200 text-gray-700 py-2 px-2 mt-3 rounded border border-gray-500">
              <a class = "flex items-center">             
                <svg class="w-6 h-6 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="w-5 h-5"><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 
                12.7 3.9 24.9 3.9 41.4z"/></svg>  
                Google
              </a>
            </button>                                   
          </div><br><br>
          <div class = "text-sm">이메일 주소로 회원가입 </div><br>
          <form class="" action="../login/login.php" method="post">
            <div class="mb-1">
              <label class="block text-gray-700 text-sm font-bold mb-1" for="name">
                  이름
              </label>
              <input id = "name" onkeyup = 'printName()' class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="">
              <div id = "nameCheck" class = "invisible text-[12px] font-semibold text-red-400 mb-1">
                  3~20자 이내로 입력하세요.
              </div>            
            <div class="mb-1">
              <label id = "email_input" class="block text-gray-700 text-sm font-bold mb-1" for="email">
                  이메일
              </label>
              <input id = "email" onkeyup='printEmail()' class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="">
              <div id = "emailCheck" class = "invisible text-[12px] font-semibold text-red-400 mb-1">
              유효한 이메일 주소를 입력하세요.</div>            
            <!-- <p id = "email_warning" class = "invisible text-xs text-red-500 mb-1">
              이미 등록된 이메일 주소입니다.</p> -->
            <div class="mb-2">
              <label class="block text-gray-700 text-sm font-bold mb-1" for="password">
                  비밀번호
              </label>
              <input id = "pw" onkeyup = 'printPw()' class="border border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="">
              <div id = "pwCheck" class = "invisible text-[12px] font-semibold text-red-400 mb-1">
              8~20자 이내로 입력하세요.</div>
            </div>
            <div class="flex items-center justify-between">
              <button id = "signup_btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded 
              focus:outline-none focus:shadow-outline disabled:opacity-50 disabled:pointer-events-none" disabled 
              type="button" onclick = "postData()">
                  회원가입
              </button>
              <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                  비밀번호를 잊으셨나요?
              </a>
            </div><br>
            <div class = "text-sm">계정을 만들면 <a href = "" class = "text-blue-500 hover:text-blue-800">이용 약관</a> 및 
            <a href = "" class = "text-blue-500 hover:text-blue-800">개인정보 보호정책</a>에 동의하시게 됩니다.</div>
          </form>        
        </div>              
      </div>    
    </body>        
</html>