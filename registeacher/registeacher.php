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
  <script defer src = "./registeacher.js"></script>  
  <script>  
  </script>
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include '../components/navbar.php' ?>
    <br>
    <!-- 강사등록 블록   -->
    <div class = "flex flex-col justify-center max-w-3xl mx-auto bg-gray-50 shadow rounded-lg  ">
        <div class = "py-4 mx-auto">                  
          <img id = "profile_image" class = "w-24 h-24 border-3 border-gray-900 rounded-full" src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>            
        </div>    
        <div class = "flex flex-col ">
            <div class = "flex my-2 mx-auto">
                <div class = "w-48 text-sm">이름</div><div id = "name" class = "w-96 text-sm text-gray-600"></div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48 text-sm">생년월일</div><div id = "bday" class = "w-96 text-sm text-gray-600"></div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48 text-sm">성별</div><div id = "sex" class = "w-96 text-sm text-gray-600"></div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48 text-sm">국적</div><div id = "country" class = "w-96 text-sm text-gray-600"></div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div class = "w-48 text-sm">거주 국가</div><div id = "residence" class = "w-96 text-sm text-gray-600"></div>
            </div>            
            <div class = "flex my-2 mx-auto">
                <div class = "w-48 text-sm">구사 가능 언어</div><div id = "language" class = "w-96 text-sm text-gray-600"></div>
            </div>
            <div class = "flex my-2 mx-auto">
                <div>
                    <div class = "w-48 text-sm mb-1">강사 소개</div>
                    <div class = "w-48 text-sm">(경력, 강의 스타일등)</div>
                </div>                
                <div>
                    <textarea rows = "5" id = "intro_t" class = "w-96 text-sm px-1 py-1 rounded border-2 border-gray-300 mb-3"
                ></textarea>
                </div>
            </div>
            <div class = "flex my-2 mx-auto">                
                <div class = "w-48 text-sm">전문 강사 인증</div>                   
                <div class = "flex flex-col">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="">
                            <div class="">
                                <input type="submit" class="btn btn-primary" value="Upload">
                            </div>
                            <div class="">
                                <input type="file" class="" name="img[]" multiple>
                                <label class="" >Choose File</label>
                            </div>
                        </div>
                    </form>                  
                </div>                                
            </div> 
            <div class = "flex my-2 mx-auto">                
                <div class = "w-48 text-sm">제출 서류 설명</div>                   
                <div class = "flex flex-col">
                    <div>
                        <textarea rows = "5" id = "intro_t" class = "w-96 text-sm px-1 py-1 rounded border-2 border-gray-300 mb-3"
                        ></textarea>
                    </div>
                    <div class = "text-sm w-96 text-gray-600">
                        전문강사 인증을 위한 항목은 <br><br>
                        1. 교원 자격증<br>2. 경력증명서<br><br> 위 두 가지이며 교원 자격증 2급 이상, 혹은 교원 자격증 3급이상이면서 경력 5년이상일 경우 전문강사 인증이 승인됩니다.
                    </div>
                
                    </div>                   
                </div>                                
            </div>                  
        </div>
        
    </div>
    
    </body><br><br><br><br><br>     
</html>