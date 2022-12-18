<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  </head>    
 
  <script src = "../commenJS/cookie.js"></script> 
  <script src = "./registeacher.js"></script>  
  
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include '../components/navbar.php' ?>     
    <?php include './regisuploadProcess.php' ?>   
    <br>
    <!-- 강사등록 블록   -->    
    
    <textarea id = "token_value" name="token" value="" class = "invisible"></textarea>        
        <div class = "flex flex-col justify-center max-w-3xl mx-auto bg-gray-50 shadow rounded-lg  "><br>
            <div class = "mx-auto font-bold text-2xl mb-3">강사 신청</div>
            <div class = "py-4 mx-auto">                  
            <img id = "profile_image" class = "w-24 h-24 border-3 border-gray-900 rounded-full" src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>            
            </div>   
            <div id = "test" class = "flex flex-col ">            
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
                    </div>                
                    <div>
                        <textarea placeholder = "경력, 강의 스타일등" name = "tintro" rows = "5" id = "intro_t" class = "w-96 text-sm px-1 py-1 
                        rounded border-2 border-gray-300 mb-3" required 
                    ></textarea>
                    </div>
                </div>
                <div class = "flex my-2 mx-auto">                
                    <div class = "w-48 text-sm">전문강사 인증 (선택)</div>                   
                    <div class = "flex flex-col w-96">    
                        <div class="flex">
                            <label for = "file_upload" class="px-3 py-1 mx-auto font-semibold bg-gray-400 text-white hover:bg-gray-600
                            rounded border" >파일 선택</label>
                            <input type="file" onchange = "addFile(this);" id = "file_upload" class="w-3/4 invisible" name="img[]" multiple>                            
                        </div>                           
                        <div id = "file-list" class="mb-2 hidden px-1 py-1 bg-white w-90 border-2 border-gray-300 rounded-lg"></div><br>  
                        <div class = "text-sm w-96 text-gray-600 border-2 rounded-lg px-2 py-2">
                            전문강사 인증을 위한 항목은 <br><br>
                            1. 교원 자격증<br>2. 경력증명서<br><br> 위 두 가지이며 교원 자격증 2급 이상, 혹은 교원 자격증 3급이상이면서 경력 5년이상일 경우 전문강사 인증이 승인됩니다.
                        </div>                
                    </div>               
                </div>             
                <div class = "flex my-2 mx-auto">                
                    <div class = "w-48 text-sm">제출 서류 설명 (선택)</div>                   
                        <div class = "flex flex-col">
                            <div>
                                <textarea placeholder = "첨부한 파일에 대한 설명을 입력해주세요" name = "certi" rows = "5" id = "certi" class = "w-96 text-sm px-1 py-1 rounded border-2 border-gray-300 mb-3"
                                ></textarea>
                            </div>                                              
                        </div>                   
                    </div>                                
                </div>    
                <button type = "button" class = " mx-auto py-2 px-4 border-2 rounded-lg bg-blue-500  hover:bg-blue-700 text-white" onclick = "submitForm()">등록</button>
                <!-- <div class=" mx-auto py-2 px-4 border-2 rounded-lg bg-blue-500  hover:bg-blue-700">
                    <input type="submit" class="font-semibold text-white" value="등록">
                </div>     -->
                <br><br>            
            </div> 
        </div>        
    </body><br><br><br><br><br>     
</html>