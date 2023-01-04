<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script>
        let class_id = "<?php echo $class_id = $_GET['class_id']; ?>";
        // 강사 id (강사에게 연락하기 할 때 사용할 용도)
        let U_id;
    </script>
    <script type="module" defer="defer" src="./myclass.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>   
        <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>
        <br>
        <div class="flex w-4/5 mx-auto justify-between">
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg hover:shadow px-2">
                <div class="flex justify-between mt-2 items-center">
                    <span class="class_date text-xs text-gray-700"></span>
                    <span
                        class="class_status text-xs bg-gray-200 text-gray-700 rounded-lg px-2 py-1">완료됨</span>
                </div>
                <span class="class_time_between text-2xl font-bold my-5">21:00 / 21:30</span>
                <hr class="bg-gray-300 border">
                <div class="flex justify-between my-5">
                    <div class="flex items-center">
                        <img
                            class="teacher_image mx-auto w-10 h-10 border-3 border-gray-900 rounded-full"
                            src="/images_forHS/userImage_default.png"></img>
                        <div class="flex flex-col ml-2">
                            <span class="teacher_name text-sm text-gray-900">안해인</span>
                            <span class="teacher_special text-xs text-gray-400">커뮤니티 튜터</span>
                        </div>
                    </div>
                </div>
                <hr class="bg-gray-300 border border-1">
                <span class="class_name py-4">한국어 기초1</span>
                <div class="flex w-full justify-between">
                    <div class="flex flex-col w-1/4">
                        <span class="text-xs text-gray-400 mb-1">수업 유형</span>
                        <span class="class_type text-sm text-gray-700 max-w-1/4">읽기 발음</span>
                    </div>
                    <div class="flex flex-col w-1/4">
                        <span class="text-xs text-gray-400 mb-1">소요 시간</span>
                        <div class = "flex items-center">
                            <span class="class_time text-sm text-gray-700">30</span>
                            <span class="text-sm text-gray-700">분</span>
                        </div>
                    </div>
                    <div class="flex flex-col w-1/4">
                        <span class="text-xs text-gray-400 mb-1">요금</span>
                        <div class="flex">
                            <span class="text-sm text-gray-700">$</span><span class="class_price text-sm text-gray-700 mx-1">6</span>
                            <span class="text-sm text-gray-700">USD</span>
                        </div>
                    </div>
                </div>
                <span class="class_desc text-sm py-4">수업 설명</span>
                <hr class="bg-gray-300 border border-1">
                <div class="flex items-center">
                    <span class="text-sm py-4">커뮤니케이션 도구</span>
                    <div
                        class="flex w-5/12 text-sm justify-center px-2 py-2 bg-gray-50 rounded hover:shadow"
                        value="0"
                        id="hs_meta"
                        name="HangleSquare Metaverse">
                        <img class="toolImage w-5 h-5" src="../images_forHS/logo.png"></img>
                        <span class="toolText mx-1 text-gray-600">HangleSquare Metaverse</span>
                    </div>
                </div>
                <hr class="bg-gray-300 border border-1">
                <div class = "flex py-4 justify-between w-full items-center">
                    <span class="text-sm">강의 평가</span>
                    <button class = "review_btn text-sm bg-violet-500 hover:bg-violet-600 rounded-lg px-2 py-1 text-white">수업 후기 등록</button>
                </div>                
                <div class="flex">
                    <div class="flex items-center">
                        <img class="tool_image w-5 h-5" src="/images_forHS/userImage_default.png"></img>
                        <div class="flex flex-col ml-2">
                            <span class="user_name text-xs text-gray-800">안해인</span>
                            <span class="review_date text-xs text-gray-500">2022년 12월 2일</span>
                            <div></div>
                            <div class="flex flex-col"></div>
                        </div>
                        <hr class="bg-gray-300 border border-1">
                    </div>
                    <div class="flex flex-col">
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <span class="text-sm py-4">강사 피드백</span>
            </div>
            <div class="flex flex-col w-1/5">
                <div class="rounded-lg bg-gray-50 shadow px-4 py-2 text-center">
                    <div
                        class="show-reserve bg-blue-500 hover:bg-blue-600 text-white rounded-lg border-blue-900 px-1 py-1 my-1">다른 수업 예약</div>
                    <div
                        class="showSendmsgModal_btn bg-gray-500 hover:bg-gray-600 text-white rounded-lg border-gray-900 px-1 py-1 my-1">강사에게 연락하기</div>
                </div>
            </div>
        </div>
        <!-- 강사에게 연락하기 모달 -->
        <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
        <?php include '../components/sendmsgModal/sendmsgModal.php'?>
        <!-- 수업 후기 등록 모달 -->
        <?php include './addReview_student.php'?>
    </body>
</html>