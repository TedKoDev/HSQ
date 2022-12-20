<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>
    <script type="module" defer="defer" src="./myschedule.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>   
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>
        <br><br>
        <div class = "w-5/6 bg-gray-50 rounded-lg shadow mx-auto"><br>
            <div class = "px-4">
                <div class = "flex justify-between">
                    <button class = "bg-gray-300 text-gray-800 hover:bg-gray-400 px-3 py-1 rounded-lg">오늘</button>
                    <div class = "flex items-center">
                        <div class = "mx-2">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
                        </div>
                        <div class = "mx-2">2022년 12월</div>
                        <div class = "mx-2">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>
                        </div>
                    </div>
                    <button class = "mr-10 invisible">오늘</button>
                </div><br><br>
                <div class = "date_header flex w-full justify-between">
                    <div class = "text-center border-y-2 w-full py-1 text-red-500 border-r-2 border-l-2">일</div>
                    <div class = "text-center border-y-2 w-full py-1 text-gray-700 border-r-2">월</div>
                    <div class = "text-center border-y-2 w-full py-1 text-gray-700 border-r-2">화</div>
                    <div class = "text-center border-y-2 w-full py-1 text-gray-700 border-r-2">수</div>
                    <div class = "text-center border-y-2 w-full py-1 text-gray-700 border-r-2">목</div>
                    <div class = "text-center border-y-2 w-full py-1 text-gray-700 border-r-2">금</div>
                    <div class = "text-center border-y-2 w-full py-1 text-blue-500 border-r-2">토</div>
                </div> 
                <div class = "date_body flex w-full justify-between border-l-2">
                <?php 
                for ($i = 0; $i < 7; $i++) {
                    ?>
                    <div class = "flex flex-col w-full">
                        <?php 
                        for ($j = 0; $j < 5; $j++) {
                            ?>
                            <div class = "flex flex-col border-b-2 border-r-2 w-full py-1 text-gray-700 px-3 min-h-max">
                                <span class = "schedule_date text-sm">1</span>
                                <!-- <div class = "flex flex-col px-2 mt-1 bg-gray-600 rounded-lg py-1">
                                    <span class = "text-xs mb-1 text-white">21:00 - 21:30</span>
                                    <span class = "text-xs text-white">안해인</span>
                                </div> -->
                            </div>
                            <?php
                        }?>
                    </div>
                    <?php
                }?>
                </div>
            </div>             
        </div>
    </body>
</html>