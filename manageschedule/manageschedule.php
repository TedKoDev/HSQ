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

        // 모달 관련 코드     
      
        // 일정 수정 완료 (서버에 저장)
        async function edit_done() {

            let send_array = new Array();

            for (let i = 1; i <= 336; i++) {

                let input_check = document.getElementById(i+"_m");

                if (input_check.checked) {

                    send_array.push(input_check.value);
                    
                }                        
            }

            let send_string = send_array.join("_");

            console.log(send_string);                    

            const body = {

                token: checkCookie,
                plan: send_string,  

                };
            const res = await fetch('./managescheduleProcess.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(body)
            });

            const body2 = document.getElementsByTagName('body')[0];

            const overlay2 = document.querySelector('#overlay')

            // 모달창 내리기
            overlay2
                .classList
                .toggle('hidden')
            overlay2
                .classList
                .toggle('flex')

            body2
                .classList
                .remove('scrollLock');
        }
        
        // 모달창 보여주기, 모달창 다시 내리기
        window.addEventListener('DOMContentLoaded', () => {

            const body = document.getElementsByTagName('body')[0];

            const overlay = document.querySelector('#overlay')
            const edit_btn = document.getElementById('edit_schedule_btn')
            const closeBtn = document.querySelector('#close-modal')

            const edit_done_btn = document.getElementById('edit_done_btn')
            const edit_cancel_btn = document.getElementById('edit_cancel_btn')

            const show_modal = () => {
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

                // 일정 있는 곳에만 색깔 변환
                setschedule("_m_l");

            }

            const cancel_modal = () => {
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

            edit_btn.addEventListener('click', show_modal)

            closeBtn.addEventListener('click', cancel_modal)
            edit_cancel_btn.addEventListener('click', cancel_modal)
        })


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
                                        name=""
                                        value="<?php echo $num; ?>"
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
                                    name=""
                                    value="<?php echo $num; ?>"
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
                    <button onclick = "edit_done()" id = "edit_done_btn" class="px-3 py-1 bg-red-800 text-gray-200 hover:bg-red-600 rounded">저장</button>
                </div>    
            </div>
        </div>
    </body>

</html>