<?php $hs_url = "https://www.hangeulsquare.com/"; ?>
<!-- 네비바 js -->
<!-- 기능들 : 1. 쿠키 변경에 따라 우측 상단 메뉴 결정 2. (로그인 되어 있을 경우) 유저 아이콘 클릭시 하단에 작은 창 (프로필
설정, 수강신청, 로그아웃등) -->
<script type = "module" defer = "defer" src="/commenJS/cookie_modules.js"></script>
<script type = "module" defer = "defer" src="/components/navbar/navbar.js"></script>
<!-- 네비바 -->
<nav class="bg-white border border-b-2 shadow">
    <div class="max-w-full mx-auto px-4">
        <div class="flex justify-between">
            <div class="flex">
                <!-- 한글스퀘어 로고 -->
                <div>
                    <a href="/index.php" class="flex items-center py-2 px-2 text-gray-700">
                        <img class="w-8 h-8 mr-2" src="<?php echo $hs_url; ?>images_forHS/logo.png"></img>
                        <span class="font-bold">Hangle Square</span>
                    </a>
                </div>
                <!-- 강사,수업, 커뮤니티 -->
                <div class="hidden md:flex items-center space-x-1 ml-3">
                    <a
                        href="/findteacher/"
                        class="py-1 px-2 text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded">강사</a>
                    <a
                        href="/findclass/"
                        class="py-1 px-2 text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded">수업</a>
                    <a
                        href="#"
                        class="py-1 px-2 text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded">커뮤니티</a>
                </div>
            </div>
            <!-- 나의 학습, 유저아이콘, 로그인,회원가입 -->
            <div class="hidden md:flex items-center space-x-1">
                <!-- 나의 학습 -->
                <button id = "myStudy" class = "mr-3 relative flex justify-center items-center focus:outline-none text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded group
                ">
                  <div class = "py-1 px-2">나의 학습</div>                  
                  <div class = "absolute hidden group-hover:block top-full min-w-full w-max bg-white rounded transition-all ease-in">
                    <ul class = "text-left border rounded">
                      <li id = "myclasses" class = "text-sm px-2 py-2 border-b border-gray-100 text-gray-700 hover:bg-gray-200">내 수업</li>
                      <li id = "myteacher" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">내 강사</li>
                      <li id = "myschedule" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">내 스케줄</li>
                      <li id = "myexam" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">내 테스트</li>                      
                    </ul>
                  </div>
                </button>
                <!-- 메세지함 -->               
                <a href = "/message/" id = "msg_icon" class = "bg-gray-300 hover:bg-gray-400 rounded-full p-1.5">
                    <!-- <svg class = "" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path d="M12 3c5.514 0 10 3.592 10 8.007 0 4.917-5.145 7.961-9.91 7.961-1.937 0-3.383-.397-4.394-.644-1 .613-1.595 1.037-4.272 1.82.535-1.373.723-2.748.602-4.265-.838-1-2.025-2.4-2.025-4.872-.001-4.415 4.485-8.007 9.999-8.007zm0-2c-6.338 0-12 4.226-12 10.007 0 2.05.738 4.063 2.047 5.625.055 1.83-1.023 4.456-1.993 6.368 2.602-.47 6.301-1.508 7.978-2.536 1.418.345 2.775.503 4.059.503 7.084 0 11.91-4.837 11.91-9.961-.001-5.811-5.702-10.006-12.001-10.006zm-3.5 10c0 .829-.671 1.5-1.5 1.5-.828 0-1.5-.671-1.5-1.5s.672-1.5 1.5-1.5c.829 0 1.5.671 1.5 1.5zm3.5-1.5c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5c.829 0 1.5-.671 1.5-1.5s-.671-1.5-1.5-1.5zm5 0c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5c.829 0 1.5-.671 1.5-1.5s-.671-1.5-1.5-1.5z"/></svg> -->
                    <svg class = "" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.739 4.063 2.047 5.625l-1.993 6.368 6.946-3c1.705.439 3.334.641 4.864.641 7.174 0 12.136-4.439 12.136-9.634 0-5.812-5.701-10.007-12-10.007zm0 1c6.065 0 11 4.041 11 9.007 0 4.922-4.787 8.634-11.136 8.634-1.881 0-3.401-.299-4.946-.695l-5.258 2.271 1.505-4.808c-1.308-1.564-2.165-3.128-2.165-5.402 0-4.966 4.935-9.007 11-9.007zm-5 7.5c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5z"/></svg>
                </a>
                
                <!-- 유저아이콘 -->                     
                <div id = "id_user_info" class = "ml-1 w-20 relative flex justify-center items-center focus:outline-none rounded group
                  ">                              
                    <img
                      id="user_image"
                      class="mx-auto w-8 h-8 rounded-full shadow"
                      src="<?php echo $hs_url; ?>images_forHS/userImage_default.png">
                    </img>  
                    <div class = "absolute hidden group-hover:block top-full min-w-full w-max bg-white rounded delay-1000 hover:block">
                        <ul class = "text-left border rounded">
                        <li id = "myinfo" class = "text-sm px-2 py-2 border-b border-gray-100 text-gray-700 hover:bg-gray-200">내 정보</li>
                        <li id = "teacher_page" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">강사 되기</li>
                        <li id = "setting" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">설정</li>
                        <li id = "logout" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">로그아웃</li>                      
                        </ul>
                    </div>                  
                </div>                
                <!-- 유저 이름 -->
                <!-- <div id = "id_user_info" class = "w-20 relative flex justify-center items-center focus:outline-none rounded group
                  ">                              
                    <button id = "user_name" class = "ml-1 mx-auto text-base text-gray-800"></button> 
                    <div class = "absolute hidden group-hover:block top-full min-w-full w-max bg-white rounded delay-1000 hover:block">
                        <ul class = "text-left border rounded">
                        <li id = "myinfo" class = "text-sm px-2 py-2 border-b border-gray-100 text-gray-700 hover:bg-gray-200">내 정보</li>
                        <li id = "teacher_page" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">강사 되기</li>
                        <li id = "setting" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">설정</li>
                        <li id = "logout" class = "text-sm px-2 py-1 border-b border-gray-100 text-gray-700 hover:bg-gray-200">로그아웃</li>                      
                        </ul>
                    </div>                  
                </div> -->

                <!-- 유저 아이콘
                <div id="test" class="relative inline-block text-left">
                    <a
                        id="id_user_info"
                        class="hidden py-2 px-2 text-gray-700"
                        onclick="userIcon_click()">
                        <img
                            id="user_image"
                            class="w-9 h-9 border-2 border-gray-900 rounded-full"
                            src="<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>
                    </a>
                    유저 아이콘의 드롭다운 메뉴
                    <div
                        id="user_dropdown"
                        class="hidden absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="id_user_info"
                        tabindex="-1">
                        <div class="py-1" role="none">
                            <a
                                id="edit_profile"
                                href="../myinfo/myinfo.php"
                                class="text-gray-700 hover:bg-gray-200 block px-4 py-2 text-sm"
                                role="menuitem"
                                tabindex="-1">내 정보</a>
                            <a
                                onclick="go_teacher_page()"
                                id="teacher_page"
                                class="text-gray-700 hover:bg-gray-200 block px-4 py-2 text-sm"
                                role="menuitem"
                                tabindex="-1">강사되기</a>
                            <a
                                id="check_message"
                                href="#"
                                class="text-gray-700 hover:bg-gray-200 block px-4 py-2 text-sm"
                                role="menuitem"
                                tabindex="-1">설정</a>
                            <a
                                id="logout"
                                class="text-gray-700 hover:bg-gray-200 block px-4 py-2 text-sm"
                                role="menuitem"
                                tabindex="-1"
                                onclick="logout()">로그아웃</a>
                        </div>
                    </div>
                </div> -->

                <!-- 로그인/회원가입 -->
                <a
                    id="id_login"
                    href="../login/"
                    class="hidden py-1 px-3 hover:bg-gray-400 hover:text-gray-800 rounded">로그인</a>
                <a
                    id="id_signup"
                    href="../signup/"
                    class="hidden py-1 px-3 bg-yellow-300 hover:bg-yellow-500 text-yellow-900 hover:text-yellow-900 rounded
        transition duration-300">회원가입</a>
            </div>

            <!-- mobile btn goes here -->
            <!-- <div class = "md:hidden flex items-center"> <button> <svg class = "w-6 h-6"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path
            stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75
            12h16.5m-16.5 5.25h16.5" /> </svg> </button> </div> -->
        </div>
    </div>
    <!-- mobile menu -->
    <!-- <div> <a href="#" class = "block py-2 px-4 text-sm
    hover:bg-gray-200">Features2</a> <a href="#" class = "block py-2 px-4 text-sm
    hover:bg-gray-200">Pricing2</a> </div> -->
</nav>