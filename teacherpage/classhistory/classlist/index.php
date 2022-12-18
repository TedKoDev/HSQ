<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>
    <script type="module" defer="defer" src="../classhistory.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <?php 
    
    echo $GET['user_name'];
    ?>
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
                    <div class="flex w-full">
                        <select
                            class="text-gray-400 selectClassType w-1/6 px-1 py-1 rounded border border-gray-200 mb-3 mx-1">
                            <option
                                class=""
                                value=""
                                disabled="disabled"
                                selected="selected"
                                hidden="hidden">수업 상태</option>
                            <option class="text-gray-800" value="all">모든 수업</option>
                            <option class="text-gray-800" value="done">완료된 수업</option>
                            <option class="text-gray-800" value="approved">예정된 수업</option>
                            <option class="text-gray-800" value="notApproved">예약 승인 대기중</option>
                            <option class="text-gray-800" value="canceled">취소된 수업</option>
                        </select>
                        <select
                            class="text-gray-400 selectClassName w-1/6 px-1 py-1 rounded border border-gray-200 mb-3 mx-1">
                            <option value="" disabled="disabled" selected="selected" hidden="hidden">수업 이름</option>
                            <option class="text-gray-800" value="all">한국어 기초1</option>
                            <option class="text-gray-800" value="done">한국어 말하기2</option>
                        </select>
                        <input
                            class="inputName w-1/6 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                            placeholder="학생명"></input>
                        <input
                            class="inputName w-1/6 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                            placeholder="수업 날짜(시작)"></input>
                        <input
                            class="inputName w-1/6 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1"
                            placeholder="수업 날짜(종료)"></input>
                        <button
                            class="searchBtn bg-blue-500 hover:bg-blue-600 text-white rounded-lg w-1/6 h-8
  border-blue-900 px-1 text-sm">검색
                        </button>
                    </div><br>
                    <div class="bg-sky-500 text-white text-xs pl-2 py-1 mx-2">UTC
                        <span class="utc">09:00</span></div>
                </div>
                <div id="List"></div>
            </div>
        </div>
        <br><br>
    </body>
</html>