<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>        
    <script type="module" defer = "defer" src="../myclasses.js"></script>    
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../components/navbar/navbar.php' ?>          
        <!-- 수업 유형(모든수업, 예약되지 않은 수업, 대기중인 수업, 완료된 수업) -->
        <div class = "navbar flex bg-gray-50 border-y-2 border-gray-200 px-4">
            <a href = "/myclasses/all/" id = "allCl" class = "classType mx-2 py-5 text-sm text-gray-600">모든 수업</a>
            <a href = "/myclasses/notapproved/"  id = "notApprovedCl" class = "classType mx-2 py-5 text-sm text-gray-600">예약되지 않은 수업</a>
            <a href = "/myclasses/approved/"  id = "approvedCl" class = "classType mx-2 py-5 text-sm text-gray-600">대기중인 수업</a>
            <a href = "/myclasses/done/"  id = "doneCl" class = "classType mx-2 py-5 text-sm text-gray-600">완료된 수업</a>
            <a href = "/myclasses/canceled/"  id = "canceledCl" class = "classType mx-2 py-5 text-sm text-gray-600">취소된 수업</a>
        </div>
        <br>
        <div id = "classList" class = "classList flex flex-col w-1/2 mx-auto">
            <!-- <div class = "flex w-full bg-gray-50 rounded-lg shadow border border-gray-200 py-2 hover:shadow">
                <div class = "flex flex-col w-1/5 text-center">
                    <span class = "text-xs text-gray-500">완료됨</span><span class = "text-lg font-semibold">10</span><span class = "text-xs text-gray-700">12월</span>
                </div>
                <div class = "flex justify-between items-center w-4/5 relative pr-4 group">
                    <div class = "flex flex-col">
                        <span  class = "text-lg font-semibold">21:00</span><span  class = "text-xs text-gray-500">한국어 기초1<a> - 30분</a></span>
                    </div>
                    <div class = "group-hover:hidden">
                        <img id = "profile_image" class = "mx-auto w-10 h-10 border-3 border-gray-900 rounded-full"
                            src = '/images_forHS/userImage_default.png'>
                        </img>
                    </div>                
                    <div class = "absolute right-4">
                        <button class = "bg-blue-600 rounded-lg text-white px-3 py-1 hidden group-hover:block">수업 후기</button>
                    </div>                                        
                </div>
            </div> -->
        </div>
    </body>
</html>