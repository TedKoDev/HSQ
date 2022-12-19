<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>        
    <script type = "module" defer = "defer" src="./historydetail.js"></script>      
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>  
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../../components/navbar/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../../../components/navbar/navbar_t.php' ?>            
        <br>
        <div class="flex w-4/5 mx-auto justify-between">
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg hover:shadow px-2 mx-2">
                <div class="flex justify-between mt-2 items-center">
                    <span class="class_date text-xs text-gray-700"></span>
                    <span
                        class="class_status text-xs bg-gray-200 text-gray-700 rounded-lg px-2 py-1"></span>
                </div>
                <span class="class_time text-2xl font-bold my-5"></span>
             
                <hr class="bg-gray-300 border border-1">
                <div class = "flex w-full justify-between items-center">
                    <span class="class_name py-4"></span>
                    <span class="py-4 text-gray-500 text-sm">$ <span class = "class_price">12</span> USD</span>
                </div>                
                <hr class="bg-gray-300 border border-1">
                <div class = "flex justify-center">
                    <button class = "class_approve_btn px-2 py-1 bg-gray-600 rounded-lg text-white mx-2 my-2 hover:bg-gray-800">수업 일정 확정</button>
                    <button class = "class_cancel_btn px-2 py-1 bg-gray-300 rounded-lg  text-gray-800 mx-2 my-2 hover:bg-gray-400">수업 취소</button> 
                    <button class = "send_paypal_btn px-2 py-1 bg-blue-500 rounded-lg  text-white mx-2 my-2 hover:bg-blue-600">결제 링크 전송</button>                                   
                </div>                
                <hr class="bg-gray-300 border border-1">
                <div class="flex items-center">
                    <span class="text-sm py-4">커뮤니케이션 도구</span>
                    <div
                        class="flex w-5/12 text-sm justify-center px-2 py-2 bg-gray-50 rounded"
                        value="0"
                        id="hs_meta"
                        name="HangleSquare Metaverse">
                        <img class="tool_image w-5 h-5" src=""></img>
                        <span class="tool_text mx-1 text-gray-600"></span>
                    </div>
                </div>
                <hr class="bg-gray-300 border border-1">
                <div class="flex flex-col">
                    <span class="text-sm py-4">강사에게 하고 싶은 말</span>
                    <span class = "class_memo text-xs test-gray-700 pb-4">잘 부탁 드립니다.</span>
                </div>
                <hr class="bg-gray-300 border border-1">                
                <span class="text-sm py-4">피드백</span>
                <span class="text-sm py-4">강의 평가</span>
                <div class="flex">
                    <div class="flex items-center">
                        <img class="toolImage w-5 h-5" src="/images_forHS/userImage_default.png"></img>
                        <div class="flex flex-col ml-2">
                            <span class="myName text-xs text-gray-800">안해인</span>
                            <span class="reviewDate text-xs text-gray-500">2022년 12월 2일</span>
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
            </div>
            <div class="w-1/4 mx-2">
                <div class="flex flex-col rounded-lg bg-gray-50 shadow px-4 py-2 text-center">
                    <img class="user_img w-14 h-14 mx-auto my-2 rounded-full" src="/images_forHS/userImage_default.png"></img>
                    <span class = "user_name text-sm py-2"></span>
                    <span class = "text-sm text-gray-700">거주 국가 : <span class = "user_residence text-sm text-gray-700"></span></span>
                    <div>
                        <span class = "text-xs text-gray-500 mx-1">UTC <span class = "student_utc"></span></span><span class = "text-xs text-gray-500 mx-1">(<span class = "utc_difference mr-1">0</span>시간차)</span>
                    </div>     
                    <div class = "flex flex-col text-left mt-2">
                        <span class = "text-xs my-1">구사 가능 언어 : </span>        
                        <span class = "user_language"></span>           
                        <span class = "text-xs my-1 mt-2">한국어 레벨 : </span>   
                        <span class = "user_korean text-xs text-gray-500"></span>
                     </div>            
                </div>
            </div>
        </div>  
        <!-- 예약 승인 모달  -->        
        <?php include './modal/acceptModal.php' ?>  
         
        <br><br>        
    </body>
</html>