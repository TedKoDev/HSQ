<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="/dist/output.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- 쿠기 생성, 가져오기, 삭제 -->        
    <script defer src = "../commenJS/cookie.js"></script>  
    <script defer src = "./myinfo.js"></script>   
    <script>
      
    </script>    
  </head>       
  <body class = "bg-gray-100">      
    <!-- 네비바 -->    
    <?php include '../components/navbar.php' ?>
    <!-- 로그인 블록 -->
    <br>
    <div class = "flex max-w-5xl justify-between mx-auto">
      <!-- 왼쪽 상단에 유저 이미지, 이름등의 정보 블록 -->
      <div class = "flex flex-col w-1/3 bg-gray-50 px-4 py-4 shadow rounded-lg">
        <div class = "mx-auto">                  
          <img class = "w-24 h-24 border border-gray-900 p-2 rounded-full" src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>            
        </div><br>
        <div id = "name" class = "text-lg"></div><br>
        <div class = "text-sm">
          <a id = "age"></a> <a id = "sex"></a><a id = "from_nation"></a><a id = "now_nation"></a>
        </div>        
      </div>
      <!-- 우측의 유저 정보 (자기소개, 국적, 언어 구사수준등등) -->
      <div class = "flex flex-col w-2/3 ml-5">
        <div class = "bg-gray-50 px-6 py-4 shadow rounded-lg">
          <div class = "flex justify-between">
            <span class = " text-xl">프로필</span>
            <a class = "py-1 px-3 bg-gray-300 text-gray-900 hover:bg-gray-400 hover:text-black rounded border border-">프로필 편집</a>          
          </div><br>    
          <div id = "intro" class = "text-sm">
          </div><br><br>
            <a class = "text-xs mb-2">구사 가능 언어 : </a>
            <br>
            <a class = "text-xs mb-2 ">한국어 구사 능력 : </a>              
        </div><br>        
      </div>                        
    </div>
    <!-- 수업 내역 -->
    <div class = "flex max-w-5xl justify-end mx-auto">      
      <div class = "flex flex-col w-1/3">          
      </div>
      <div class = "flex flex-col w-2/3 ml-5">
        <div class = "bg-gray-50 px-6 py-4 shadow rounded-lg">
          <div class = "flex justify-between">
            <span class = " text-xl">수업 내역</span>         
          </div><br>                       
        </div><br>        
      </div>           
    </div>
    <!-- 내 활동 -->
    <div class = "flex max-w-5xl justify-end mx-auto">      
      <div class = "flex flex-col w-1/3">          
      </div>
      <div class = "flex flex-col w-2/3 ml-5">
        <div class = "bg-gray-50 px-6 py-4 shadow rounded-lg">
          <div class = "flex justify-between">
            <span class = " text-xl">내 활동</span>         
          </div><br>                       
        </div><br>        
      </div>           
    </div>        
    </body><br><br><br><br><br><br>
</html>