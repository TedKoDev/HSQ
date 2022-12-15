<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>        
    <script type = "module" defer = "defer" src="../classhistory.js"></script>      
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>  
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../../components/navbar/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../../../components/navbar/navbar_t.php' ?>            
        <!-- 히스토리 종류 선택 (수업 목록, 피드백, 수업 후기)  -->
        <?php include '../selecthistory.php' ?>
        <!-- 수업 목록 div -->
        <br>              
        <div class="flex flex-col w-3/4 mx-auto ">
            <div class = "filter">
                
            </div>
            <div id = "List">  
                <div class = "classList flex flex-col w-full px-2 ">                    
                    <div class = "flex w-full bg-gray-50 border-b-2 border-l-2 border-r-2 hover:bg-gray-200 py-1">
                        <div class = "flex items-center w-1/5 pl-2">
                            <img id = "profile_image" class = "w-8 h-8 border-3 border-gray-900 rounded-full mr-1" 
                                src = "/images_forHS/userImage_default.png">
                            </img>
                            <span class = "studentName text-xs text-gray-800">학생 이름</span>
                        </div>
                        <div class = "flex flex-col w-3/5">
                            <span class = "className text-sm">한국 드라마 대화 연습</span>
                            <span class = "classStartDate text-xs text-gray-600">2022년 6월 6일 토</span>
                        </div>
                        <div class = "flex flex-col w-1/5">
                            <span class = "classStatus text-sm text-gray-400">완료됨</span>
                            <span class = "text-sm text-gray-500">$ <span class = "classPrice">12</span> USD</span>
                        </div>                    
                    </div>                
                </div>
            </div>           
        </div>
    </body>
</html>