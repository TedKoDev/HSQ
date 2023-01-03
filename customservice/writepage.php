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
  <script defer src="./customservice.js"></script>


</head>
<!-- Noticeboard HTML -->





<body class="bg-gray-100">
  <!-- 네비바 -->
  <?php include '../components/navbar/navbar.php' ?>
  <!-- 로그인 블록 -->


  <body class="bg-gray-200">

    <div class="flex-col justify-between mx-auto max-w-5xl items-center bg-white rounded-lg shadow-xl m-9 py-5  px-10">
      <h1 class=" text-3xl font-bold text-black-500 mb-6">고객센터/문의게시판</h1>
      <div class="flex justify-between items-center mb-6">

        <div class="w-1/4 text-center text-black-500 font-bold text-xl">번호</div>
        <div class="w-1/4 text-center text-black-500 font-bold text-xl">카테고리</div>
        <div class="w-1/4 text-center text-black-500 font-bold text-xl">제목</div>
        <div class="w-1/4 text-center text-black-500 font-bold text-xl">작성자</div>
        <div class="w-1/4 text-center text-black-500 font-bold text-xl">작성일</div>
      </div>



      <!-- Post content -->
      <div id="posts">
      </div>
      <h2 id="write" class=" text-3xl font-bold text-black-500 mb-6"> 글쓰기</h2>
    </div>
    </div>
  </body>




</html>