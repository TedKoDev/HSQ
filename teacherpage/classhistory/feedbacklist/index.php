<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">
    </head>        
    <script type = "module" defer = "defer" src="./feedbacklist.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <script>       
        
    </script>
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../../components/navbar/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../../../components/navbar/navbar_t.php' ?>            
        <!-- 히스토리 종류 선택 (수업 목록, 피드백, 수업 후기)  -->
        <?php include '../selecthistory.php' ?>
        <br>
        <div class="flex flex-col w-3/4 mx-auto ">
            <div class = "filter">
                
            </div>            
            <div id = "List">  
                <div class = "">

                </div>
            </div>           
        </div>
    </body>
</html>