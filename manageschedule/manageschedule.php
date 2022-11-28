<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">

    </head>
    <script src="../commenJS/cookie.js"></script>
    <script defer="defer" src="./manageschedule.js"></script>
    <script>

        // check일 경우 빨간색으로
        function test_click(event) {

            let label_id = event.target.id;

            let label = document.getElementById(label_id + "_l");

            let result = "";
            if (event.target.checked) {
                result = event.target.value;

                console.log(event.target.id);
                label.style.backgroundColor = 'red';

            } else {
                result = "0";

                label.style.backgroundColor = '#9CA3AF';

                // console.log(result);
            }
        }
    </script>
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
                <a
                    id="edit_schedule_btn"
                    class="mx-auto px-3 py-1 my-auto font-semibold bg-gray-300 text-gray-700 hover:bg-gray-400 hover:text-black
                    rounded border">일정 편집</a>

                <div class="ml-auto">
                    <span>이전</span><span>다음</span>
                </div><br>
                <div id="header_s" class="flex mx-auto"></div>
                <?php 
                    $num = 0;
                        for ($i = 0; $i < 8; $i++) {                
                    
                        ?>
                <div id="body_s_<?php echo $i; ?>" class="flex mx-auto">
                    <div class="flex flex-col">

                        <?php if ($i == 0) {
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
                                <span><?php echo $minute; ?></span></div>
                        </div>
                    <?php
                                }                       
                            }
                            else {
                                
                                for ($j = 1; $j <= 48; $j++) {

                                    $num = $num + 1;                                
                                    ?>
                        <div class="flex items-center w-20">
                            <input
                                type="checkbox"
                                id="<?php echo $num; ?>"
                                name="A3-confirmation"
                                value="yes"
                                class="hidden"
                                onclick='test_click(event)'/>
                            <label
                                for="<?php echo $num; ?>"
                                id="<?php echo $num; ?>_l"
                                class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                    rounded border"
                                name="test_label"></label>
                        </div>
                        <?php }
                        } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <script>

            window.addEventListener('DOMContentLoaded', () => {

                const body = document.getElementsByTagName('body')[0];

                const overlay = document.querySelector('#overlay')
                const edit_btn = document.getElementById('edit_schedule_btn')
                const closeBtn = document.querySelector('#close-modal')

                const edit_done_btn = document.getElementById('edit_done_btn')
                const edit_cancel_btn = document.getElementById('edit_cancel_btn')

                const toggleModal = () => {
                    overlay
                        .classList
                        .toggle('hidden')
                    overlay
                        .classList
                        .toggle('flex')

                    body
                        .classList
                        .add('scrollLock');

                    // 날짜 뿌려주기
                    getDate("header_s_m");

                }

                const toggleModal2 = () => {
                    overlay
                        .classList
                        .toggle('hidden')
                    overlay
                        .classList
                        .toggle('flex')

                    body
                        .classList
                        .remove('scrollLock');

                }

                edit_btn.addEventListener('click', toggleModal)

                closeBtn.addEventListener('click', toggleModal2)
            })
        </script>
        <div
            class="bg-gray-700 bg-opacity-50 absolute inset-0 hidden justify-center items-center border-2"
            id="overlay">
            <div class="bg-gray-200 max-w-2xl py-2 px-3 rounded shadow-xl text-gray-800">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-bold">일정 편집</h4>                    
                    <svg
                        class="h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                        id="close-modal"
                        fill="currentColor"
                        viewbox="0 0 20 20">
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

                <!-- 스케줄 부분 스크롤 되게 처리 -->
                <div class="h-96 overflow-auto">
                    <div id="header_s_m" class="flex mx-auto"></div>
                    
                    <?php 
                        $num = 0;
                            for ($i = 0; $i < 8; $i++) {                
                        
                            ?>
                    <div id="body_s_<?php echo $i; ?>" class="flex mx-auto">
                        <div class="flex flex-col">

                            <?php if ($i == 0) {
                                    $add = 0;
                                    for ($j = 0; $j < 48; $j++) {
                                        
                                        $add = $add + 30;
                                        $hour = sprintf('%02d', $add / 60);
                                        $minute = sprintf('%02d', $add % 60);
                                        ?>
                            <div class="flex items-center w-20 h-5">
                                <div><span>~ <?php  echo $hour; ?></span> : <span><?php echo $minute; ?></span></div>
                            </div>
                        <?php
                                    }                       
                                }
                                else {
                                    
                                    for ($j = 1; $j <= 48; $j++) {

                                        $num = $num + 1;                      
                                        ?>
                            <div class="flex items-center w-20">
                                <input
                                    type="checkbox"
                                    id="<?php echo $num; ?>_m"
                                    name="A3-confirmation"
                                    value="yes"
                                    class="hidden"
                                    onclick='test_click(event)'/>
                                <label
                                    for="<?php echo $num; ?>_m"
                                    id="<?php echo $num; ?>_m_l"
                                    class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                        rounded border"
                                    name="test_label"></label>
                            </div>
                            <?php }
                            } ?>
                        </div>
                        <?php } ?>
                    </div>                    
                                 
                </div>
                <div class="mt-3 flex justify-end space-x-3">
                    <button id = "edit_cancel_btn" class="px-3 py-1 rounded hover:bg-red-300 hover:bg-opacity-50 hover:text-red-900">닫기</button>
                    <button id = "edit_done_btn" class="px-3 py-1 bg-red-800 text-gray-200 hover:bg-red-600 rounded">저장</button>
                </div>    
            </div>
        </div>
    </body>

</html>