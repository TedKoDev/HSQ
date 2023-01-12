<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">

    </head>    
    <style>
        .date {
        font-size: 12px;
        }
    </style>
    <script type="module" defer="defer" src="./studentdetail.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>    
    <script>
        let user_id = "<?php echo $_GET['user_id']; ?>";
    </script>
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../components/navbar/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../../components/navbar/navbar_t.php' ?>
        <br><br>
        <div class="flex w-4/5 mx-auto justify-between">
            <div class="classList flex flex-col w-3/4 bg-gray-50 rounded-lg px-2 mx-2">
                <div class="flex flex-col justify-between mt-2 border-b-2 pb-2">
                    <span class="class_date text-base text-gray-900">수업 이력</span>                    
                </div>                
            </div>
            <div class="w-1/4 mx-2">
                <div class="flex flex-col rounded-lg bg-gray-50 shadow px-4 py-2 text-center">
                    <img
                        class="user_img w-14 h-14 mx-auto my-2 rounded-full"
                        src="/images_forHS/userImage_default.png"></img>
                    <span class="user_name text-sm py-2"></span>
                    <span class="text-sm text-gray-700">거주 국가 :
                        <span class="user_residence text-sm text-gray-700"></span></span>
                    <div>
                        <span class="text-xs text-gray-500 mx-1">UTC
                            <span class="student_utc"></span></span><span class="text-xs text-gray-500 mx-1">(<span class="utc_difference mr-1">0</span>시간차)</span>
                    </div>
                    <div class="flex flex-col text-left mt-2">
                        <span class="text-xs my-1">구사 가능 언어 :
                        </span>
                        <span class="user_language text-gray-600"></span>
                        <span class="text-xs my-1 mt-2">한국어 레벨 : <span class = "user_korean text-gray-600"></span></span>                       
                        <span class="text-xs my-1 mt-2">수업 횟수 : <span class="class_count text-gray-600">5<span>회</span></span></span>
                        
                    </div>
                    <div
                        class="showSendmsgModal_btn mt-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg border-gray-900 px-1 py-1 my-1">학생에게 연락하기</div>
                </div>
            </div>
        </div>
    </body>
</html>