<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script defer="defer" src="../commenJS/cookie.js"></script>
    <script src="./teacherpage.js"></script>

    <script></script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <!-- 회원가입 블록 -->
        <br>
        <nav class="bg-white border border-b-0 shadow">
            <div class="max-w-full mx-auto px-4">
                <div class="flex justify-between">
                    <div class="flex">
                        
                        <!-- 강사,수업, 커뮤니티 -->
                        <div class="hidden md:flex items-center space-x-1 ml-3">
                            <a
                                href="#"
                                class="py-1 px-2 text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded">내 수업</a>
                            <a
                                href="#"
                                class="py-1 px-2 text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded">학생 관리</a>
                            <a
                                href="#"
                                class="py-1 px-2 text-gray-700 hover:text-gray-900 hover:bg-gray-400 rounded">일정</a>
                        </div>
                    </div>
                    <!-- 유저아이콘, 로그인,회원가입 -->
                    <div class="hidden md:flex items-center space-x-1">
                        <!-- 유저 아이콘 -->
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
                            <!-- 유저 아이콘의 드롭다운 메뉴 -->
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
                                    <!-- <form method="POST" action="#" role="none"> <button type="submit"
                                    class="text-gray-700 hover:bg-gray-200 block w-full px-4 py-2 text-left text-sm"
                                    role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button> </form> -->
                                </div>
                            </div>
                        </div>

                        <!-- 로그인/회원가입 -->
                        <a
                            id="id_login"
                            href="../login/login.php"
                            class="hidden py-1 px-3 hover:bg-gray-400 hover:text-gray-800 rounded">로그인</a>
                        <a
                            id="id_signup"
                            href="../signup/signup.php"
                            class="hidden py-1 px-3 bg-yellow-300 hover:bg-yellow-500 text-yellow-900 hover:text-yellow-900 rounded
                transition duration-300">회원가입</a>
                    </div>
                </div>
            </div>

        </nav>
    </body>
</html>