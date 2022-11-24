<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script defer="defer" src="../commenJS/cookie.js"></script>
    <script src="./t_regisclass.js"></script>

    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../components/navbar_t.php' ?>  
        <?php include './t_regisclassProcess.php' ?>  
        <br><br>
        <div class = "flex flex-col max-w-3xl mx-auto bg-gray-50 shadow rounded-lg  "><br>
            <div class = "mx-auto font-bold text-2xl mb-3">수업 등록</div>
             
            <div id = "test" class = "flex flex-col max-w-3xl ">            
                <div class = "flex my-2 px-10">
                    <div class = "text-sm w-2/12 items-center">수업명</div>
                    <div class = "w-10/12">
                        <input type = "text" id = "class_name" class = "px-2 w-full text-sm text-gray-900 border border-gray-700 rounded"/>
                    </div>
                </div><br>
                <div class = "flex my-2 px-10">
                    <div class = "text-sm w-2/12 items-center">수업 소개</div>
                    <div class = "w-10/12">
                        <textarea rows = "5" type = "text" id = "class_intro" class = "px-2 w-full text-sm rounded border border-gray-700"></textarea>
                    </div>
                </div>
                <div class = "flex px-10">
                    <div class = "w-2/12 text-sm">수업 유형</div>
                    <select id = "select_type" class = "w-44 px-1 py-1 text-sm text-gray-900 border-gray-700 rounded border mb-3">
                        <option value = '회화 연습'>회화 연습</option>
                        <option value = '발음'>발음</option>
                        <option value = '문법'>문법</option>
                        <option value = '철자'>철자</option>
                        <option value = '읽기'>읽기</option>
                        <option value = '듣기'>듣기</option>
                        <option value = '작문'>작문</option>
                    </select>
                    <button onclick = "click_add_type()" id = "add_type_btn" class = "text-sm h-8 ml-3 py-1 px-2 border-2 rounded-lg bg-gray-500  hover:bg-gray-600 text-white" >유형 추가</button>                    
                </div>
                <div class = "flex my-2 px-10">
                    <div class = "w-2/12"></div>
                    <div id = "type_list" class = "w-10/12 flex "></div>
                </div>               
                <div class = "flex my-2 px-10">
                    <div class = "w-2/12 text-sm">수업료</div>
                    <div class = "w-10/12 flex flex-col">
                        <div class = "flex mb-2">
                            <div>30분 : </div>
                            <input placeholder = "단위 : $" type = "text" id = "price_30" class = "ml-4 px-2 text-sm text-gray-900 border border-gray-700 rounded"/>
                        </div>
                        <div class = "flex">
                            <div>60분 : </div>
                            <input placeholder = "단위 : $" type = "text" id = "price_60" class = "ml-4 px-2 text-sm text-gray-900 border border-gray-700 rounded"/>
                        </div>
                    </div>                    
                </div>                
                <br>                    
                <button type = "button" onclick = "regisclass_btn()" class = " mx-auto py-2 px-4 border-2 rounded-lg bg-blue-500  hover:bg-blue-700 text-white">등록</button>
                
                <br><br>            
            </div> 
        </div>        
                        
        </div>
    </body>
</html>