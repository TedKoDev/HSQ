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
  <script src = "./registeacher.js"></script>  
  <script>  
  </script>
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include '../components/navbar.php' ?>
    <br>
    <!-- 강사등록 블록   -->
    <div class = "flex flex-col justify-center max-w-3xl mx-auto bg-gray-50 shadow rounded-lg  ">
        <div class = "py-4 mx-auto">                  
          <img class = "w-24 h-24 border border-gray-900 p-2 rounded-full" src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>            
        </div>    
        <div class = "flex flex-col ">
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">이름</div><div id = "name" class = "w-96">안해인</div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">생년월일</div><div id = "name" class = "w-96">1997.1.27</div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">성별</div><div id = "name" class = "w-96">남성</div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">국적</div><div id = "name" class = "w-96">대한민국</div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">거주 국가</div><div id = "name" class = "w-96">태국</div>
            </div>            
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">구사 가능 언어</div><div id = "name" class = "w-96">구사 가능 언어</div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48">강사 소개</div><div id = "name" class = "w-96">강사 소개(경력, 지도스타일 등)</div>
            </div>
        </div>
    </div>

    </body>        
</html>