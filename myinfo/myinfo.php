<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="/dist/output.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>  
  <script src = "./login.js"></script>  
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include '../components/navbar.php' ?>
    <!-- 로그인 블록 -->
    <br>
    <div class = "flex max-w-5xl mx-auto">
      <!-- 왼쪽 상단에 유저 이미지, 이름등의 정보 블록 -->
      <div class = "flex flex-col max-w-md bg-gray-50 px-4 py-4 shadow rounded-lg">
        <div class = "mx-auto">                  
          <img class = "w-24 h-24 border border-gray-900 p-2 rounded-full" src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>            
        </div><br>
        <div class = "text-lg">ahnhaein</div><br>
        <div class = "text-sm">
          <a>25</a>, <a>남성</a>, <a>대한민국 출신</a>, <a>대한민국 거주</a>
        </div>        
      </div>
      <!-- 우측의 유저 정보 (자기소개, 국적, 언어 구사수준등등) -->
      <div class = "flex bg-gray-50 px-4 py-4 shadow rounded-lg">
        <div class = "text-2xl">프로필ddddddd</div>
      </div>                   
    </div>    
    </body><br><br><br><br><br><br>
</html>