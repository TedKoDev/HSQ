<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>
    <style>
        select:invalid { color: gray; }
    </style>
    <!-- <script type="module" defer="defer" src="../classhistory.js"></script> -->
    <script type="module" defer="defer" src="./classlist.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <script>        
        let key_user_name = "<?php echo $_GET['user_name']; ?>";
        let key_class_type = "<?php echo $_GET['class_type']; ?>";
        let key_class_name = "<?php echo $_GET['class_name']; ?>";
        let key_time_from = "<?php echo $_GET['time_from']; ?>";
        let key_time_to = "<?php echo $_GET['time_to']; ?>";   
        
        let page_classList = "<?php echo $_GET['page']; ?>";
        let page_feedback;
        let page_review;
    </script>
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../../components/navbar/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../../../components/navbar/navbar_t.php' ?>
        <!-- 히스토리 종류 선택 (수업 목록, 피드백, 수업 후기) -->
        <?php include '../selecthistory.php' ?>
        <!-- 수업 목록 div -->
        <br>

        <div class="flex flex-col w-3/4 mx-auto ">
            <div class="body">
                <div class="filter">
                    <form action='/teacherpage/classhistory/classlist/' method='get'>
                        <div class="flex w-full">
                            <select
                                id = "selector" class="classType selectClassType w-1/3 px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                                name="class_type" required>
                                <option                                    
                                    value=""
                                    disabled="disabled"
                                    selected="selected"
                                    hidden="hidden">수업 상태</option>
                                <option class="text-gray-800" value="all">모든 수업</option>
                                <option class="text-gray-800" value="done">완료된 수업</option>
                                <option class="text-gray-800" value="approved">예정된 수업</option>
                                <option class="text-gray-800" value="wait">예약 승인 대기중</option>
                                <option class="text-gray-800" value="cancel">취소된 수업</option>
                            </select>
                            <input
                                type="text"
                                name="class_name"
                                class="text-gray-700 className w-1/3 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                                placeholder="수업명"></input>
                            <input
                                type="text"
                                name="user_name"
                                class="userName w-1/3 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                                placeholder="학생명"></input>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex w-full">
                                <div class="flex flex-col w-1/3">
                                    <span class="text-xs text-gray-700 ml-2 mb-1">시작일</span>
                                    <input
                                        type="date"
                                        name="time_from"
                                        class="classStart text-xs text-gray-500 px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                                        placeholder="수업 날짜(시작)"></input>
                                </div>
                                <div class="flex flex-col w-1/3">
                                    <span class="text-xs text-gray-700 ml-2 mb-1">종료일</span>
                                    <input
                                        type="date"
                                        name="time_to"
                                        class="classEnd text-xs text-gray-500 px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                                        placeholder="수업 날짜(종료)"></input>
                                </div>
                            </div>
                            <button
                                type="summit"
                                class="searchBtn bg-blue-500 hover:bg-blue-600 text-white rounded-lg w-1/5 h-8
                              border-blue-900 px-1 text-sm">검색
                            </button>
                        </div>
                    </form><br>
                    <div class="bg-sky-500 text-white text-xs pl-2 py-1 mx-2">UTC
                        <span class="utc">09:00</span></div>
                </div>                
                <div id="List"></div>
            </div>
        </div>
        <br><br>
    </body>
</html>