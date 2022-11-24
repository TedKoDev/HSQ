<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script defer="defer" src="../commenJS/cookie.js"></script>
    <script src="./t_regisclass.js"></script>

    <script>

        let type_num = 0;
        let type_array = new Array();
        function click_add_type() {
            
            let add_btn = document.getElementById("add_type_btn");
            // 현재 select의 값 가져오기
            let selete_type = document.getElementById("select_type").value;
            // 새롭게 생성되는 타입들이 붙을 div 가져오기
            let type_list = document.getElementById("type_list");

            // 1증가
            type_num = type_num + 1;
            // 새로운 div 생성
            let type_item = document.createElement('div');
            // type_1 이런식으로 id 부여
            type_item.setAttribute("id", "type_"+type_num);

            // 추가될 뷰 대입
            type_item.innerHTML = [         
            '<div class = "flex bg-gray-500 mr-2">',   
                '<div class = "">'+selete_type+'</div>',
                '<div class = "ml-1" onclick = "delete_type('+type_num+')"> X</div>',
            '</div>'].join(""); 

            // select를 div 아래에 연결
            type_list.appendChild(type_item);

            // array에 해당 type 추가
            type_array.push(selete_type);
        }

        function delete_type(type_num) {
            
            // 해당 배열 삭제
            delete type_array[type_num-1];

            // 삭제할 div 태그 가져오기
            let delete_div = document.getElementById("type_"+type_num);
            // 삭제
            delete_div.remove();
        }

        async function regisclass_btn() {

             // 전송할 수업명, 수업소개, 수업 유형, 수업료
            let cname = document.getElementById("class_name").value;
            let cintro = document.getElementById('class_intro').value;
            let price_30 = document.getElementById('price_30').value;
            let price_60 = document.getElementById('price_60').value;

            let price_json = new Object();
            let thirty = '30';
            let sixthy = '60';
            // price_json[thirty] = price_30;
            // price_json[sixthy] = price_60;

            console.log("token : "+checkCookie);
            console.log("cname : "+cname);
            console.log("cintro : "+cintro);
            console.log("type : "+type_array);
            console.log("timeprice : "+price_json);


            let body = {     
                token : checkCookie,
                cname : cname,
                cintro : cintro,
                people : 1,
                type : type_array,
                timeprice : '[{"time":"30","price":"10"},{"time":"40","price":"20"},{"time":"50","price":"30"}]',
            };
            let res = await fetch('./t_regisclassProcess.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(body)
            });

            let response = await res.json();  

            console.log(response);
        }

    </script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../components/navbar_t.php' ?>    
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
                            <input type = "text" id = "price_30" class = "ml-4 px-2 text-sm text-gray-900 border border-gray-700 rounded"/>
                        </div>
                        <div class = "flex">
                            <div>60분 : </div>
                            <input type = "text" id = "price_60" class = "ml-4 px-2 text-sm text-gray-900 border border-gray-700 rounded"/>
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