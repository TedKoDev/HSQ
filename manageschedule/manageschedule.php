<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">

    </head>
    <script src="../commenJS/cookie.js"></script>
    <script src="./manageschedule.js" defer="defer"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <style>
        .scrollLock {
            height: 100%;
            overflow: hidden;
        }
    </style>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../components/navbar_t.php' ?>
        <br><br>
        <div>
            <div
                class="flex flex-col justify-center max-w-3xl mx-auto bg-gray-50 shadow rounded-lg  "><br>
                <div class="flex">
                    <div class="mx-auto font-bold text-2xl mb-3">나의 일정</div>
                </div><br>
                <div class="flex mx-auto">
                    <a
                        id="upload_schedule_btn"
                        class="mx-2 px-3 py-1 my-auto font-semibold bg-gray-300 text-gray-700 hover:bg-gray-400 hover:text-black
                        rounded border">정규 일정 등록</a>
                    <a
                        id="edit_schedule_btn"
                        class="mx-2 px-3 py-1 my-auto font-semibold bg-gray-300 text-gray-700 hover:bg-gray-400 hover:text-black
                        rounded border">일정 편집</a>
                </div>

                <div class="flex max-w-3xl justify-around px-4 mb-2">
                    <div class="flex">
                        <div class="flex items-center">
                            <a class="bg-blue-600 rounded-full px-1 py-1"></a>
                            <span class="ml-1">예약 가능</span>
                        </div>
                    </div>
                    <div class="flex ml-auto">
                        <button
                            onclick="change_schedule('before', 'header_s', '_l', '')"
                            class="border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">이전</button>
                        <button
                            onclick="change_schedule('after', 'header_s', '_l', '')"
                            class="border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">다음</button>
                    </div>
                </div>
                <div id="header_s" class="flex mx-auto mt-2"></div>
                <div id="body_s" class="flex mx-auto">
                    <?php 
                        $num = 0;
                            for ($i = 0; $i < 8; $i++) {
                            
                                if ($i == 0) {
                                ?>
                    <div id="body_s_<?php echo $i; ?>" class="flex flex-col">
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
                    <div id="body_s_<?php echo $i; ?>" class="flex flex-col">
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
                                disabled="disabled"/>
                            <label
                                for="<?php echo $num; ?>"
                                id="<?php echo $num; ?>_l"
                                class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                                    rounded border"
                                name="schedule_label"></label>
                        </div>
                        <?php
                                    }
                                ?>
                    </div>
                    <?php
                                }
                            }
                        ?>
                </div><br><br><br><br>
            </div>
        </div>

        <!-- 모달창(일정 편집) -->
        <div
            class="bg-gray-700 bg-opacity-50 fixed inset-0 hidden justify-center items-center border-2"
            id="overlay">
            <div class="bg-gray-200 max-w-2xl py-2 px-3 rounded shadow-xl text-gray-800">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-bold">일정 편집</h4>
                    <!-- <svg class="h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                    id="close-modal" fill="currentColor" viewbox="0 0 20 20"> <path
                    fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0
                    111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293
                    4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path> </svg> -->
                    <div class="flex flex-col">
                        <div class="mt-3 flex justify-end space-x-3 mb-3">
                            <button
                                id="edit_cancel_btn"
                                class="px-3 py-1 rounded bg-blue-300 hover:bg-blue-500 hover:bg-opacity-50 hover:text-blue-900">닫기</button>
                            <button
                                onclick="edit_done()"
                                id="edit_done_btn"
                                class="px-3 py-1 bg-blue-800 text-gray-200 hover:bg-blue-600 rounded">저장</button>
                        </div>
                        <div class="flex ml-auto">
                            <button
                                onclick="change_schedule('before', 'header_s_m', '_m_l', '_m')"
                                class="border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">이전</button>
                            <button
                                onclick="change_schedule('after', 'header_s_m', '_m_l', '_m')"
                                class="border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">다음</button>
                        </div>
                    </div>
                </div>
                <!-- 스케줄 부분 스크롤 되게 처리 -->
                <div id="schedule" class="flex flex-col h-96 overflow-auto">
                    <div id="header_s_m" class="flex mx-auto"></div>
                    <div id="body_s_m" class="flex mx-auto">
                        <?php 
                        $num = 0;
                            for ($i = 0; $i < 8; $i++) {
                            
                                if ($i == 0) {
                                ?>
                        <div id="body_s_m_<?php echo $i; ?>" class="flex flex-col">
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
                        <div id="body_s_m_<?php echo $i; ?>" class="flex flex-col">
                            <?php 
                                    
                                    for ($j = 1; $j <= 48; $j++) {

                                        $num = $num + 1; 
                                    ?>
                            <div class="flex items-center w-20">
                                <input
                                    type="checkbox"
                                    id="<?php echo $num; ?>_m"
                                    name="edit"
                                    value="<?php echo $num; ?>"
                                    class="hidden"
                                    onclick='test_click(event)'/>
                                <label
                                    for="<?php echo $num; ?>_m"
                                    id="<?php echo $num; ?>_m_l"
                                    class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                                    rounded border"
                                    name="schedule_label"></label>
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
            </div>
        </div>
            <!-- 모달창(정규 일정 등록) -->
            <div
                class="bg-gray-700 bg-opacity-50 fixed inset-0 hidden justify-center items-center border-2"
                id="overlay_upload">
                <div class="bg-gray-200 max-w-2xl py-2 px-3 rounded shadow-xl text-gray-800">
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg font-bold">정규 일정 등록</h4>
                        <!-- <svg class="h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                        id="close-modal" fill="currentColor" viewbox="0 0 20 20"> <path
                        fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0
                        111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293
                        4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path> </svg> -->
                        <div class="flex flex-col">
                            <div class="mt-3 flex justify-end space-x-3 mb-3">
                                <button
                                    id="upload_cancel_btn"
                                    class="px-3 py-1 rounded bg-blue-300 hover:bg-blue-500 hover:bg-opacity-50 hover:text-blue-900">닫기</button>
                                <button
                                    onclick="upload_done()"
                                    id="edit_done_btn"
                                    class="px-3 py-1 bg-blue-800 text-gray-200 hover:bg-blue-600 rounded">등록</button>
                            </div>                            
                        </div>
                    </div>
                    <div class = "flex flex-col">
                        <div>기간 선택</div>
                        <div class = "flex">
                        <input type='radio' id = "4week" value='4' onclick='radio_click(event)' checked/>4주
                        <input type='radio' id = "8week" value='8' onclick='radio_click(event)'/>8주
                        <input type='radio' id = "12week" value='12' onclick='radio_click(event)'/>12주
                        </div>
                        <div>정규 일정 등록 시 오늘 날짜가 포함된 주 부터 일정이 등록됩니다</div>
                    <div>
                    <!-- 스케줄 부분 스크롤 되게 처리 -->
                    <div id="schedule" class="flex flex-col h-96 overflow-auto">
                        <div id="header_s_u" class="flex mx-auto mb-2">
                            <a class = "w-20 h-5 text-center"></a>
                            <a class = "w-20 h-5 text-center">월</a>
                            <a class = "w-20 h-5 text-center">화</a>
                            <a class = "w-20 h-5 text-center">수</a>
                            <a class = "w-20 h-5 text-center">목</a>
                            <a class = "w-20 h-5 text-center">금</a>
                            <a class = "w-20 h-5 text-center">토</a>
                            <a class = "w-20 h-5 text-center">일</a>
                        </div>
                        <div id="body_s_u" class="flex mx-auto">
                            <?php 
                            $num = 0;
                                for ($i = 0; $i < 8; $i++) {
                                
                                    if ($i == 0) {
                                    ?>
                            <div id="body_s_u_<?php echo $i; ?>" class="flex flex-col">
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
                            <div id="body_s_u_<?php echo $i; ?>" class="flex flex-col">
                                <?php 
                                        
                                        for ($j = 1; $j <= 48; $j++) {

                                            $num = $num + 1; 
                                        ?>
                                <div class="flex items-center w-20">
                                    <input
                                        type="checkbox"
                                        id="<?php echo $num; ?>_u"
                                        name="upload"
                                        value="<?php echo $num; ?>"
                                        class="hidden"
                                        onclick='test_click(event)'/>
                                    <label
                                        for="<?php echo $num; ?>_u"
                                        id="<?php echo $num; ?>_u_l"
                                        class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                                        rounded border"
                                        name="schedule_label"></label>
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
                </div>
            </div>
        </body>

    </html>