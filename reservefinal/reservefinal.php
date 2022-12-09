<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <!-- 쿠기 생성, 가져오기, 삭제 -->
        <script src="../commenJS/cookie.js"></script>
        <script defer="defer" src="./reservefinal.js"></script>
        <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>        
    </head>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <nav class="bg-white border border-b-0 shadow">
            <div class="max-w-full mx-auto px-4">
                <div class="flex justify-between">
                    <div class="flex">
                        <!-- 한글스퀘어 로고 -->
                        <div>
                            <a href="/index.php" class="flex items-center py-2 px-2 text-gray-700">
                                <img class="w-8 h-8 mr-2" src="../images_forHS/logo.png"></img>
                                <span class="font-bold">Hangle Square</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- 결제 정보 -->
        <br>
        <div></div>
        <div class = "bg-gray-50 w-1/3 py-4 mx-auto rounded-lg shadow">
            <div class = "flex flex-col ">
                <div class = "flex justify-between w-4/5 mx-auto">
                    <img id = "timg" class = "mx-1 w-14 h-14 border-2 border-gray-900 rounded-full" src = "../images_forHS/userImage_default.png"></img>
                    <div class = "flex flex-col mx-1 ">
                        <div id = "tname" class = "font-semibold">강사 이름</div>
                        <div>-</div>
                        <div id = "clname" class = "my-1">수업 이름</div>
                        <div id = "cltool" class = "my-1">수업 도구</div>
                        <div class = "flex my-1">
                            <span id = "cltime"></span>,<span id = "clnumber" class = "ml-1"></span>
                        </div>
                        <div id = "clschedule" class = "my-1">
                            
                        </div>
                    </div>
                </div><br>
                <div class = "w-4/5 mx-auto text-sm mb-1">강사에게 하고 싶은 말</div>
                <textarea rows = "5" id = "memo" class = "w-4/5 mx-auto text-sm px-1 py-1 rounded border border-gray-200"
                placeholder = "ex : 수업에서 원하는 것, 본인의 한국어 구사 수준"></textarea>
                <div class = "flex mx-auto my-3">
                    <div>합계</div>
                    <div><span class = "ml-2 mr-1">$</span><span id = "clprice">30</span><span class = "ml-1">USD</span></div>   
                </div>
                <div id = "reserveBtn" onclick = "reserveDone()" class = "px-3 py-1 mx-auto w-1/2 font-semibold bg-gray-300 text-gray-700 hover:bg-gray-400 hover:text-black 
                    rounded border text-center">
                    예약하기
                </div>
            </div>
        </div>
    </body><br><br><br><br><br><br>
</html>