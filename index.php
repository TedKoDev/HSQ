<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./css/tailwind.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>    
  </head>      
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include './components/navbar.php' ?>
    <!-- 한글스퀘어 소개하는 블록 -->
    <br>    
    <div class = "max-w-4xl mx-auto">
      <div class = "flex justify-between">
        <div class = "flex flex-col max-w-lg mr-4 bg-gray-50 px-4 py-4 shadow rounded-lg">
          <div>
          <div class = "font-bold text-3xl">한글스퀘어</div>
          </div><br>
          <div>
            한국어에 관심있는 전세계 모든 사람들이 모이는 메타버스 플랫폼 '한글스퀘어'. <br><br>
            로그인만 하면 당신이 전 세계 어디에 있든 한글스퀘어에서 한국사람을 만나고 한국어로 대화할 수 있습니다. <br><br>
            1:1 온라인 튜더링 서비스를 하기 전 선생님을 찾을 수도 있고, <br>
            한글스퀘어에서 무료로 제공하는 다양한 한국어 교육 컨텐츠를 이용해 보세요. <br><br>
            한글스퀘어에서 함께합시다. 지금 바로 입장해 보세요. <br>
          </div>
        </div>
        <div class = "flex flex-col max-w-md ml-5">
          <div>                  
            <img class = "w-100 h-100 rounded-lg" src = "<?php echo $hs_url; ?>images_forHS/광장.PNG"></img>            
          </div>    
          <button class="w-60 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-3 rounded">
            HangleSquare 입장하기 
          </button>                
        </div>        
      </div>
    </div><br><br><br><br><br><br><br><br><br>         
    <form action="upload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" value="Upload Image" name="submit">
    </form>            
  </body>
</html>