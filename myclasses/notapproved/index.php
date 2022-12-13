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
        <?php include '../selectclass.php' ?>
    </body>
</html>