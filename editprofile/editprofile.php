<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="/dist/output.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
     <!-- 쿠기 생성, 가져오기, 삭제 -->        
    <script defer src = "../commenJS/cookie.js"></script>  
    <script defer src = "./editprofile.js"></script>   
    <script>
      
    </script>    
  </head>       
  <body class = "bg-gray-100">      
    <!-- 네비바 -->    
    <?php include '../components/navbar.php' ?>
    <!-- 프로필 편집 블록 -->
    <br>
    <div class = "flex flex-col max-w-3xl justify-between mx-auto bg-gray-50 px-6 py-4 shadow rounded-lg">
      
        <!-- 프로필 수정 -->
        <div class = "text-base px-4">프로필 사진</div><br>
        <div class = "w-full px-4 pb-4 flex border-b-2">           
          <img class = "w-32 h-32 border border-gray-900 p-2 rounded-full" 
          src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>
          <button class = " ml-12 max-h-10 px-3 py-1 my-auto bg-gray-300 text-gray-900 hover:bg-gray-400 hover:text-black 
                rounded border">업로드</button>
        </div>          

        <!-- 기본 정보 (이름, 생년월일, 성별, 국적, 거주국가, 자기소개)                       -->
        <div class = "text-base mt-8 px-4">기본 정보</div><br>
        <div class = "flex flex-col w-full px-4 py-4 border-b-2"> 
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">이름</div>            
            <div id = "" class = "w-9/12 justify-between">
              <!-- 이름 수정 클릭 안했을 때 -->
              <div id = "namediv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "name">안해인</div>                                   
                <div><svg id = "name_edit" onclick = "editingName('name', 'namediv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 이름 수정 클릭했을 때 -->
              <div id = "namediv_click_edit" class = "hidden ">
              
              </div>
            </div>            
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">생년월일</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 생년월일 수정 클릭 안했을 때 -->
              <div id = "bdaydiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "bday">1997년 1월 27일</div>                                   
                <div><svg id = "bday_edit" onclick = "editingBday('bday', 'bdaydiv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 생년월일 수정 클릭했을 때 -->
              <div id = "bdaydiv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">성별</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 성별 수정 클릭 안했을 때 -->
              <div id = "sexdiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "sex">남성</div>                                   
                <div><svg id = "sex_edit" onclick = "editingSex('sex', 'sexdiv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 성별 수정 클릭했을 때 -->
              <div id = "sexdiv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">국적</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 국적 수정 클릭 안했을 때 -->
              <div id = "countrydiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "country">대한민국</div>                                   
                <div><svg id = "country_edit" onclick = "editingCountry('country', 'countrydiv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 국적 수정 클릭했을 때 -->
              <div id = "countrydiv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">거주 국가</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 거주 국가 수정 클릭 안했을 때 -->
              <div id = "residencediv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "residence">대한민국</div>                                   
                <div><svg id = "residence_edit" onclick = "editingResidence('residence', 'residencediv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 거주 국가 수정 클릭했을 때 -->
              <div id = "residencediv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div> 
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">자기 소개</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 자기소개 수정 클릭 안했을 때 -->
              <div id = "introdiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "intro">안녕하세요</div>                                   
                <div><svg id = "intro_edit" onclick = "editingIntre('intro', 'introdiv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 자기소개 수정 클릭했을 때 -->
              <div id = "introdiv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div>                 
        </div>   
        
        <!-- 언어 (구사가능 언어, 한국어 수준) -->
        <div class = "text-base mt-8 px-4">언어</div><br>
        <div class = "flex flex-col w-full px-4 py-4 border-b-2"> 
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">구사 가능 언어</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 구사가능 언어 수정 클릭 안했을 때 -->
              <div id = "languagediv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "language">영어 : C2</div>                                   
                <div><svg id = "language_edit" onclick = "editingLanguage('language', 'languagediv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 구사가능 언어 수정 클릭했을 때 -->
              <div id = "languagediv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">한국어 구사 수준</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 한국어 구사 수정 클릭 안했을 때 -->
              <div id = "koreandiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <div id = "korean">B2</div>                                   
                <div><svg id = "korean_edit" onclick = "editingKorean('korean', 'koreandiv_not_edit')" class=" w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </div>
              </div>
              <!-- 한국어 구사 수정 클릭했을 때 -->
              <div id = "namediv_click_edit" class = "hidden ">
              
              </div>
            </div>     
          </div>                          
        </div>   

    </div>       
    </body><br><br><br><br><br><br>
</html>