<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>            
    <script type="module" defer = "defer" src="./message2.js"></script>    
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.1/dist/flowbite.min.css" />
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <style>
        .line_clamp_1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }
    .small_text {
        font-size: 12px;
    }
    </style>
    <body class="bg-gray-100">        
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>   
        <div class = "w-full h-full">      
            <div class = "w-4/5 bg-gray-50 rounded-lg mx-auto pt-2 mt-3 h-5/6 shadow">
                <!-- 첫번째 블럭(채팅방 검색, 채팅방의 강사 이름) -->
                <div class = "flex w-full">
                    <div class = "w-40">
                        <label for="chat_search" class="mb-2 text-sm font-medium text-gray-700"></label>
                        <div class="relative items-center">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="search" id="chat_search" class=" py-2 block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Search">                    
                        </div>      
                    </div>           
                    <div class = "w-3/4 flex justify-between">      
                        <button data-dropdown-toggle="dropdown" class = "user_name hidden items-center ml-4">
                            <span class = "chatting_user_name">유저 이름 </span>
                            <svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>                          
                    </div>  
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-24 dark:bg-gray-700">
                        <!-- <ul class="text-center py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton"> -->
                        <div class = "flex justify-center hover:bg-gray-100 py-1">
                            <button class="text-center text-xs block px-1 py-1">다른 수업 예약</button>
                        </div>
                        <div class = "flex justify-center hover:bg-gray-100 py-1">
                            <button class="exit_btn text-center text-xs block px-1 py-1">채팅방 나가기</button>
                        </div>                        
                    </div>
                </div>
                <!-- 두번째 블럭 (채팅방 리스트, 채팅내역) -->
                <div class ="flex w-full h-full">
                    <div class = "chatroom_list w-40 h-5/6">
                        
                    </div>
                    <div class = "chatting_square w-3/4 h-3/4">
                        <div class = "chatting_list flex flex-col w-full bg-gray-200 h-96 overflow-auto p-3">                            
                                                                                   
                        </div>
                        <div class = "send_group w-full py-1 hidden justify-between">
                            <input class = "input_message px-2 text-gray-700 w-5/6 text-sm py-2 ml-6 bg-gray-50" type = "text" placeholder = "메세지를 입력하세요."/>
                            <button class = "send_btn mr-3 px-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl w-14">전송</button>
                        </div>
                    </div>                 
                </div>           
            </div>
        </div>    
        <script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>
    </body>
</html>
