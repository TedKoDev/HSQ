<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
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
          <button class = "ml-12 max-h-10 px-3 py-1 my-auto font-semibold bg-gray-300 text-gray-900 hover:bg-gray-400 hover:text-black 
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
                <span id = "name"></span>                                   
                <span><svg id = "name_edit" onclick = "editing_name()" class="float-right my-auto w-6 h-6 text-gray-500" 
                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </span>
              </div>              
              <!-- 이름 수정 클릭했을 때 --> 
              <div id = "namediv_click_edit" class = "hidden">
                <div><input id = "input_name" class = "text-sm px-1 py-1 rounded border border-gray-200 mb-3"></input></div>
                <button onclick = "edit_done_name()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_name()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>
              </div>              
            </div>            
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">생년월일</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 생년월일 수정 클릭 안했을 때 -->
              <div id = "bdaydiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "bday"></span>                                   
                <span><svg id = "bday_edit" onclick = "editing_bday()" onclick = "editingBday('bday', 'bdaydiv_not_edit')" class="float-right my-auto w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </span>
              </div>
              <!-- 생년월일 수정 클릭했을 때 -->
              <div id = "bdaydiv_click_edit" class = "hidden ">
                <div class = "flex mb-3">
                  <select id = "select_year" class = "w-28 px-1 py-1 rounded border border-gray-200 mr-2">
                    <?php for ($i = 2021; $i >= 1900; $i = $i - 1) {
                      ?> <option value = "<?php echo $i; ?>"><?php echo $i; ?></option> <?php 
                    } ?>
                  </select>
                  <select id = "select_month" class = "w-28 px-1 py-1 rounded border border-gray-200 mr-2">
                    <?php for ($i = 1; $i <= 12; $i = $i + 1) {
                      ?> <option value = "<?php echo $i; ?>"><?php echo $i; ?></option> <?php 
                    } ?>
                  </select>
                  <select id = "select_day" class = "w-28 px-1 py-1 rounded border border-gray-200 mr-2">
                    <?php for ($i = 1; $i <= 31; $i = $i + 1) {
                      ?> <option value = "<?php echo $i; ?>"><?php echo $i; ?></option> <?php 
                    } ?>
                  </select>                
                </div> 
                <button onclick = "edit_done_bday()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_bday()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">성별</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 성별 수정 클릭 안했을 때 -->
              <div id = "sexdiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "sex"></span>                                   
                <span><svg id = "sex_edit" onclick = "editing_sex()" class="float-right w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </span>
              </div>
              <!-- 성별 수정 클릭했을 때 -->
              <div id = "sexdiv_click_edit" class = "hidden ">
                <select id = "select_sex" class = "w-44 px-1 py-1 rounded border border-gray-200 mb-3">
                  <option value = "남성">남성</option>
                  <option value = "여성">여성</option>  
                </select><br>
                <button onclick = "edit_done_sex()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_sex()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">국적</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 국적 수정 클릭 안했을 때 -->
              <div id = "countrydiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "country"></span>                                   
                <span><svg id = "country_edit" onclick = "editing_country()" class="float-right w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                  </span>
              </div>
              <!-- 국적 수정 클릭했을 때 -->
              <div id = "countrydiv_click_edit" class = "hidden ">
                <select id = "select_country" class = "w-44 px-1 py-1 rounded border border-gray-200 mb-3">
                  <option value = "대한민국">대한민국</option>
                  <option value = "일본">일본</option> 
                  <option value = "미국">미국</option>
                  <option value = "중국">중국</option>
                  <option value = "영국">영국</option>
                  <option value = "프랑스">프랑스</option>
                  <option value = "이탈리아">이탈리아</option>
                  <option value = "스페인">스페인</option>
                  <option value = "독일">독일</option>
                  <option value = "러시아">러시아</option> 
                  </select><br>                  
                <button onclick = "edit_done_country()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_country()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>
              </div>
            </div>     
          </div>
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">거주 국가</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 거주 국가 수정 클릭 안했을 때 -->
              <div id = "residencediv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "residence"></span>                                   
                <span><svg id = "residence_edit" onclick = "editing_residence('residence', 'residencediv_not_edit')" class="float-right w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                  </span>
              </div>
              <!-- 거주 국가 수정 클릭했을 때 -->
              <div id = "residencediv_click_edit" class = "hidden ">                
                <select id = "select_residence" class = "w-44 px-1 py-1 rounded border border-gray-200 mb-3">
                  <option value = "대한민국">대한민국</option>
                  <option value = "일본">일본</option> 
                  <option value = "미국">미국</option>
                  <option value = "중국">중국</option>
                  <option value = "영국">영국</option>
                  <option value = "프랑스">프랑스</option>
                  <option value = "이탈리아">이탈리아</option>
                  <option value = "스페인">스페인</option>
                  <option value = "독일">독일</option>
                  <option value = "러시아">러시아</option> 
                </select><br>                  
                <button onclick = "edit_done_residence()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_residence()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>                
              </div>
            </div>     
          </div> 
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">자기 소개</div>
            <div id = "" class = "flex flex-col w-9/12 justify-between">
              <!-- 자기소개 수정 클릭 안했을 때 -->
              <div id = "introdiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "intro" class = "w-80"></span>                                   
                <span onclick = "editing_intro()" ><svg id = "intro_edit" class="float-right w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </span>
              </div>
              <!-- 자기소개 수정 클릭했을 때 -->
              <div id = "introdiv_click_edit" class = "hidden">
                <div><textarea rows = "5" id = "input_intro" class = "w-80 text-sm px-1 py-1 rounded border border-gray-200 mb-3"
                ></textarea></div>
                <button onclick = "edit_done_intro()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_intro()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>
              </div> 
            </div>     
          </div>                 
        </div>           
        <!-- 구사 가능 언어 -->
        <div class = "text-base mt-8 px-4">언어 
          <span id = "language_return_btn" onclick = "language_return()" class = "hidden px-2 float-right font-semibold bg-gray-500 text-xs text-white
                hover:bg-gray-700 hover:text-white rounded-full border">X
          </span>   
        </div><br>                
        <div class = "flex-col w-full px-4 py-4 border-b-2">             
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">구사 가능 언어</div>                             
            <div id = "" class = "w-9/12 justify-between">                            
              <!-- 구사가능 언어 수정 클릭 안했을 때 -->              
              <div id = "languagediv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "language"></span>                                   
                <span><svg id = "language_edit" onclick = "editing_language()" class="float-right w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </span>                
              </div>                            
              <!-- 구사가능 언어 수정 클릭했을 때 -->                             
              <div id = "languagediv_click_edit" class = "hidden flex-col">                               
                <div id = "now_select"></div>
                <div id = "select_box"></div>
                <span id = "add_language" class = "text-sm" onclick="add_select()">+ 더 추가</span>
                <div class = "flex mt-2">
                  <button id = "save_language_btn" onclick = "edit_done_language()" class = "mr-3 py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                  <button id = "cancel_language_btn" onclick = "edit_cancel_language()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>
                </div>                                
              </div>   
            </div>             
          </div>           
          <!-- 한국어 구사 수준 -->
          <div class = "flex justify-between items-center my-auto py-2">
            <div class = "text-sm w-3/12">한국어 구사 수준</div>
            <div id = "" class = "w-9/12 justify-between">
              <!-- 한국어 구사 수정 클릭 안했을 때 -->
              <div id = "koreandiv_not_edit" class = "flex justify-between text-sm text-gray-500">
                <span id = "korean"></span>                                   
                <span onclick = "editing_korean()"><svg id = "korean_edit" class="float-right w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 
                  002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>                
                </span>
              </div>
              <!-- 한국어 구사 수정 클릭했을 때 -->
              <div id = "koreandiv_click_edit" class = "hidden ">
                <select id = "select_korean" class = "w-44 px-1 py-1 text-sm text-gray-500 border-gray-200 rounded border mb-3">
                  <option value = 'A1'>A1 : 초보</option>
                  <option value = 'A2'>A2 : 기초</option>
                  <option value = 'B1'>B1 : 중급</option>
                  <option value = 'B2'>B2 : 중상급</option>
                  <option value = 'C1'>C1 : 고급</option>
                  <option value = 'C2'>C2 : 고급 이상</option>
                  <option value = 'native'>원어민</option>
                </select><br>                  
                <button onclick = "edit_done_korean()" class = "py-1 px-2 font-semibold bg-blue-500 text-white hover:bg-blue-700 hover:text-white rounded border">저장</button>
                <button onclick = "edit_cancel_korean()" class = "py-1 px-2 font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300 hover:text-gray-600 rounded border">취소</button>               
              </div>
            </div>     
          </div>                          
        </div>   

    </div>       
    <!-- <custom-input id = ""></custom-input>

    <template id = 'template1'>
      <label class = "text-red-500">이메일 입력</label><input>
    </template>

    
    <script>
      class 클래스 extends HTMLElement {

        constructor() {
          super();
          this.name = 'hihi';

          console.log('constructor : '+this.name);

          this.innerHTML = this.name;
          this.append(template1.content.cloneNode(true))
        }
        connectedCallback() {

          let 라벨 = document.createElement('label');
          라벨.innerHTML = name;
          this.appendChild(라벨);

          
        }       
      }
      customElements.define('custom-input', 클래스);
    </script> -->
      
    </body><br><br><br><br><br><br>
</html>