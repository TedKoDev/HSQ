<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <link href="/dist/output.css" rel="stylesheet">
    </head>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>   
    <script type="module" defer="defer" src="./myschedule.js"></script>    
    <!-- <script type = "module" defer = "defer" src = "../calendartest/test.js"></script> -->
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>
        <br><br>
        <div class = "w-5/6 bg-gray-50 rounded-lg shadow mx-auto"><br>
            <div class = "px-4">
                <div class = "flex justify-between">
                    <button class = "bg-gray-300 text-gray-800 hover:bg-gray-400 px-3 py-1 rounded-lg">오늘</button>
                    <div class = "flex items-center">
                        <div class = "prev_btn mx-2">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
                        </div>
                        <div class = "currentMonth mx-2"></div>
                        <div class = "next_btn mx-2">
                            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>
                        </div>
                    </div>
                    <button class = "mr-10 invisible">오늘</button>
                </div><br><br>                
                <div class = "date_header flex w-full justify-between">
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-red-500 border-r-2 border-l-2">일</div>
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-gray-700 border-r-2">월</div>
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-gray-700 border-r-2">화</div>
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-gray-700 border-r-2">수</div>
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-gray-700 border-r-2">목</div>
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-gray-700 border-r-2">금</div>
                    <div class = "w-full text-center border-y-2 w-1/7 py-1 text-blue-500 border-r-2">토</div>
                </div> 
                <div class = "date_body flex flex-col w-full justify-between border-l-2">
                <?php 
                $num = 0;
                for ($i = 0; $i < 6; $i++) {
                    
                    ?>
                    <div class = "flex w-full">
                        <?php 
                        for ($j = 0; $j < 7; $j++) {
                            $num = $num + 1;
                            ?>
                            <div class = "schedule_block flex flex-col border-b-2 border-r-2 w-full py-1 text-gray-700 px-2"
                                id = "<?php echo $num; ?>_block">
                                <span class = "schedule_date text-sm" id = "<?php echo $num; ?>_date"></span>
                                <div class = "schedule_list flex flex-col overflow-auto max-h-48" id = "<?php echo $num; ?>_list">

                                </div>                                                                                             
                            </div>
                            <?php
                        }?>
                    </div>
                    <?php
                }?>
                </div>
                <br>
                <div class = "flex">
                    <div class = "flex items-center">
                        <a class = "bg-sky-600 rounded-full px-1 py-1"></a>
                        <span class = "ml-1 mr-4">승인 대기중</span>
                        <a class = "bg-violet-500 rounded-full px-1 py-1"></a>
                        <span class = "mx-1 mr-4">수업 예정</span>  
                        <a class = "bg-gray-400 rounded-full px-1 py-1"></a>
                        <span class = "ml-1 mr-4">취소됨</span>
                        <a class = "bg-gray-600 rounded-full px-1 py-1"></a>
                        <span class = "mx-1 mr-4">완료됨</span>                           
                    </div>                    
                </div>  
                <br>            
            </div>                  
        </div>
        <br><br><br>       
    </body>
</html>