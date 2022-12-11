<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>    
    <script defer = "defer" src="./myclasses.js"></script>

    <script></script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>          
        <!-- 수업 유형(모든수업, 예약되지 않은 수업, 대기중인 수업, 완료된 수업) -->
        <div class = "flex bg-gray-50 border-y-2 border-gray-200 px-4">
            <button id = "allCl" onclick = "selectClasstype('all')" class = "mx-2 py-5 font-semibold text-sm border-b-4 border-blue-400 text-gray-800">모든 수업</button>
            <button id = "notApprovedCl" onclick = "selectClasstype('notApproved')" class = "mx-2 py-5 text-sm text-gray-600">예약되지 않은 수업</button>
            <button id = "waitingCl" onclick = "selectClasstype('waiting')" class = "mx-2 py-5 text-sm text-gray-600">대기중인 수업</button>
            <button id = "doneCl" onclick = "selectClasstype('done')" class = "mx-2 py-5 text-sm text-gray-600">완료된 수업</button>
        </div>
    </body>
</html>