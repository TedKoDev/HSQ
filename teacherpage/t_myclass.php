<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script src="../commenJS/cookie.js"></script>
    <script src="./t_myclass.js"></script>

    <script></script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../components/navbar_t.php' ?>    
        <br><br>
        <div class = "flex justify-between max-w-3xl mx-auto items-center">
            <div class = "font-bold text-2xl">내 수업</div> 
            <a href = "./t_regisclass.php" class = "py-1 px-4 border-2 rounded-lg bg-blue-500  hover:bg-blue-700 text-white">수업 등록</a>
        </div><br>
        <div id = "class_list" class = "flex flex-col justify-center max-w-3xl mx-auto bg-gray-50 shadow rounded-lg "><br>
            <!-- <div class = "flex bg-gray-200 justify-between rounded-lg mx-10">
                <div class = "flex flex-col">
                    <div>수업명</div>
                    <div>수업 소개</div>
                    <div class = "flex">
                        <div>읽기</div><div>회화 연습</div>
                    </div>
                </div>   
                <div class = "flex flex-col my-auto">
                    <div>30분 : <a>300</a></div>
                    <div>60분 : <a>600</a></div>
                </div>            
            </div>                -->
        </div>
    </body>
</html>