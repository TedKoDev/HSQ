<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/output.css" rel="stylesheet">
  <!-- cdn으로 테일윈드 사용시  <script src="https://cdn.tailwindcss.com"></script> -->
  <!-- 쿠기 생성, 가져오기, 삭제 -->
  <script defer="defer" src="/commenJS/cookie.js"></script>

  <!-- js 파일 연결  -->
  <script defer src="./customservice2.js"></script>


</head>
<!-- Noticeboard HTML -->





<body class="bg-gray-100">
  <!-- 네비바 -->
  <?php include '../components/navbar/navbar.php' ?>
  <!-- 로그인 블록 -->


  <body class="bg-gray-200">
    <div class="grid grid-cols-4 gap-4">
      <div class="col-span-4 md:col-span-2 lg:col-span-1 flex items-center justify-center bg-gray-300 rounded-lg board" data-board-id="board-1">
        Board 1
      </div>
      <div class="col-span-4 md:col-span-2 lg:col-span-1 flex items-center justify-center bg-gray-300 rounded-lg board" data-board-id="board-2">
        Board 2
      </div>
      <div class="col-span-4 md:col-span-2 lg:col-span-1 flex items-center justify-center bg-gray-300 rounded-lg board" data-board-id="board-3">
        Board 3
      </div>
      <div class="col-span-4 md:col-span-2 lg:col-span-1 flex items-center justify-center bg-gray-300 rounded-lg board" data-board-id="board-4">
        Board 4
      </div>
    </div>





  </body>


</html>