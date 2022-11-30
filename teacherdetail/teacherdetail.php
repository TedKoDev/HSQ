<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script defer="defer" src="../commenJS/cookie.js"></script>
    <script defer="defer" src="./teacherdetail.js"></script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <br>
        <div class="flex max-w-4xl mx-auto justify-between">
            <div class="flex flex-col w-3/4  bg-gray-50 rounded-lg px-4 py-2 mb-3 shadow">
                <div class="flex mb-2">
                    <!-- 프로필 이미지 -->
                    <div>
                        <img
                            id="profile_image"
                            class="w-20 h-20 border-3 border-gray-900 rounded-full "
                            src="<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>
                    </div>
                    <!-- 이름, 강사 자격, 구사 가능 언어 -->
                    <div class="flex flex-col ml-4">
                        <div id = "name">이름</div>
                        <div id = "certi">강사 자격</div>
                        <div class = "flex">
                            <div>구사 언어 :
                            </div>
                            <div id = "language" class="flex">                           
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- 자기 소개, 강의 스타일 항목 선택-->
                <div class="flex mb-2">
                    <div class = "px-3">자기 소개</div>
                    <div class = "px-3">강의 스타일</div>
                </div>
                <!-- (자기소개, 강의스타일) 텍스트 -->
                <div class = "flex">
                    <div id = "intro_div">
                        <div class = "flex flex-col">
                            <a id = "country"></a>
                            <a id = "residence"></a>
                            <div id = "intro"></div>
                        </div>
                    </div>
                    <div class = "t_intro_div">
                        <div id = "t_intro"></div>
                    </div>
                </div>                
            </div>
            <div class="flex flex-col w-1/5 bg-gray-50 rounded-lg px-4 py-2 shadow justify-center text-center">
                <div class = " bg-blue-500 hover:bg-blue-600 text-white rounded-lg border-blue-900 px-1 py-1 my-1">수업 예약</div>
                <div class = " bg-gray-500 hover:bg-gray-600 text-white rounded-lg border-gray-900 px-1 py-1 my-1">강사에게 연락하기</div>
            </div>
        </div>
        <!-- 평점, 학생, 수업, 출결, 응답률 -->
        <div class="flex max-w-4xl mx-auto ">
            <div class="flex w-3/4  bg-gray-50 rounded-lg px-4 py-2 shadow">
                <div class="flex flex-col w-1/5">
                    <div class="mx-auto">4.8</div>
                    <div class="mx-auto">평점</div>
                </div>
                <div class="flex flex-col w-1/5">
                    <div class="mx-auto">350</div>
                    <div class="mx-auto">학생</div>
                </div>
                <div class="flex flex-col w-1/5">
                    <div class="mx-auto">1,828</div>
                    <div class="mx-auto">수업</div>
                </div>
                <div class="flex flex-col w-1/5">
                    <div class="mx-auto">100%</div>
                    <div class="mx-auto">출결</div>
                </div>
                <div class="flex flex-col w-1/5">
                    <div class="mx-auto">100%</div>
                    <div class="mx-auto">응답률</div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mt-3 mb-2 max-w-4xl mx-auto">
            <div class="w-3/4 mb-1">수업</div>
            <!-- 수업 목록 -->
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg px-4 py-2 shadow">
                <div class="flex">
                    <div class="flex flex-col">
                        <div>수업 제목</div>
                        <div class="flex">
                            <a>수업 레벨</a><a class = "mx-2"> | </a>
                            <a>수업 유형</a><a class = "mx-2"> | </a>
                            <a>수업 횟수</a>
                        </div>
                    </div>
                    <div>
                        가격
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col mt-3 mb-2 max-w-4xl mx-auto">
            <div class="w-3/4 mb-1">수업 가능한 시간</div>
            <!-- 일정 표시 -->
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg px-4 py-2 shadow">
                <div id="schedule" class="flex flex-col h-96 overflow-auto">
                    <div id="header_s" class="flex mx-auto">

                    </div>
                    <div id = "body_s" class = "flex mx-auto">
                        <?php 
                        $num = 0;
                            for ($i = 0; $i < 8; $i++) {
                            
                                if ($i == 0) {
                                ?>
                                    <div id = "body_s_<?php echo $i; ?>" class = "flex flex-col">
                                <?php 
                                    $add = 0;
                                    for ($j = 0; $j < 48; $j++) {

                                        $add = $add + 30;
                                        $hour = sprintf('%02d', $add / 60);
                                        $minute = sprintf('%02d', $add % 60);
                                    ?>
                                        <div class="flex items-center w-20 h-5">
                                            <div>
                                                <span>~
                                                    <?php  echo $hour; ?></span>
                                                :
                                                <span><?php echo $minute; ?></span>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                    </div>
                                <?php
                                }
                                else {
                                ?>
                                     <div id = "body_s_<?php echo $i; ?>" class = "flex flex-col">
                                <?php 
                                    
                                    for ($j = 1; $j <= 48; $j++) {

                                        $num = $num + 1; 
                                    ?>
                                        <div class="flex items-center w-20">
                                            <input
                                                type="checkbox"
                                                id="<?php echo $num; ?>"
                                                name=""
                                                value="<?php echo $num; ?>"
                                                class="hidden"
                                                onclick='test_click(event)'
                                                disabled/>
                                            <label
                                                for="<?php echo $num; ?>"
                                                id="<?php echo $num; ?>_l"
                                                class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                                    rounded border"
                                                name="schedule_label">
                                            </label>
                                        </div>
                                <?php
                                    }
                                ?>
                                    </div>
                                <?php
                                }
                            }
                        ?>
                    </div>
                </div>                 
                <div class = "text-center">회원님의 시간대 기준 <a>(UTC+09:00)</a></div>                
            </div>
            <br><br><br><br>
        </div>
        
    </body>    
</html>