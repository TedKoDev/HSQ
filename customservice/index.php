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
  <script defer src="./myinfo.js"></script>


</head>
<!-- Noticeboard HTML -->

 
<body class="bg-gray-100">
  <!-- 네비바 -->
  <?php include '../components/navbar/navbar.php' ?>
  <!-- 로그인 블록 -->


  <body class="bg-gray-200">
  <div class="max-w-4xl mx-auto py-12 px-4 bg-white rounded-lg shadow-xl">
    <h1 class="text-3xl font-bold text-yellow-500 mb-6">Bulletin Board</h1>
    <div class="flex justify-between items-center mb-6">
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Order</div>
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Title</div>
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Author</div>
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Date</div>
    </div>
    <?php
      // Connect to the database
      $conn = mysqli_connect('localhost', 'username', 'password', 'database');

      // Retrieve the posts from the database
      $result = mysqli_query($conn, 'SELECT * FROM posts ORDER BY created_at DESC');
      while ($row = mysqli_fetch_assoc($result)) {
        // Display the post
        echo '<div class="border-b border-gray-300 mb-6 pb-4 cursor-pointer" onclick="openDetail(' . $row['id'] . ')">';
        echo '  <div class="flex justify-between items-center mb-4">';
        echo '    <div class="w-1/4 text-yellow-500">' . $row['order'] . '</div>';
        echo '    <div class="w-1/4 text-yellow-500">' . $row['title'] . '</div>';
        echo '    <div class="w-1/4 text-yellow-500">' . $row['author'] . '</div>';
        echo '    <div class="w-1/4 text-yellow-500">' . date('F d, Y', strtotime($row['created_at'])) . '</div>';
        echo '  </div>';
        echo '  <p class="text-yellow-500 mb-4">' . $row['content'] . '</p>';
        echo '</div>';
      }
    ?>
  </div>
  <script>
    function openDetail(postId) {
      // Open the detail page for the post with the specified ID
      window.location.href = 'detail.php?id=' + postId;
    }
  </script>
</body
<!DOCTYPE html>
<html>
<head>
  <title>Bulletin Board</title>
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
  <div class="max-w-4xl mx-auto py-12 px-4 bg-white rounded-lg shadow-xl">
    <h1 class="text-3xl font-bold text-yellow-500 mb-6">Bulletin Board</h1>
    <div class="flex justify-between items-center border-b-2 mb-6">
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Order</div>
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Title</div>
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Author</div>
      <div class="w-1/4 text-yellow-500 font-bold text-xl">Date</div>
    </div>
    <?php
      // Connect to the database
      $conn = mysqli_connect('localhost', 'username', 'password', 'database');

      // Retrieve the posts from the database
      $result = mysqli_query($conn, 'SELECT * FROM posts ORDER BY created_at DESC');
      while ($row = mysqli_fetch_assoc($result)) {
        // Display the post
        echo '<div class="border-b border-gray-300 mb-6 pb-4 cursor-pointer" onclick="openDetail(' . $row['id'] . ')">';
        echo '  <div class="flex justify-between items-center mb-4">';
        echo '    <div class="w-1/4 text-yellow-500">' . $row['order'] . '</div>';
        echo '    <div class="w-1/4 text-yellow-500">' . $row['title'] . '</div>';
        echo '    <div class="w-1/4 text-yellow-500">' . $row['author'] . '</div>';
        echo '    <div class="w-1/4 text-yellow-500">' . date('F d, Y', strtotime($row['created_at'])) . '</div>';
        echo '  </div>';
        echo '  <p class="text-yellow-500 mb-4">' . $row['content'] . '</p>';
        echo '</div>';
      }
    ?>
  </div>
  <script>
    function openDetail(postId) {
      // Open the detail page for the post with the specified ID
      window.location.href = 'detail.php?id=' + postId;
    }
  </script>


  <!-- 우측의 유저 정보 (자기소개, 국적, 언어 구사수준등등) -->
  <div class="flex flex-col w-2/3 ml-5">
    <div class="bg-gray-50 px-6 py-4 shadow rounded-lg">
      <div class="flex justify-between">
        <span class=" text-xl">프로필</span>
        <a href="../editprofile/" class="py-1 px-3 bg-gray-300 text-gray-900 hover:bg-gray-400
             hover:text-black rounded border border-">프로필 편집</a>
      </div><br>
      <div id="intro" class="text-sm">
      </div><br><br>
      <a class="text-sm mb-2">구사 가능 언어 : </a> <a id="language" class="text-sm ml-4"></a>
      <br>
      <a class="text-sm mb-2 ">한국어 구사 능력 : </a> <a id="korean" class="text-sm ml-4"></a>
    </div><br>
  </div>
  </div>
  <!-- 수업 내역 -->
  <div class="flex max-w-5xl justify-end mx-auto">
    <div class="flex flex-col w-1/3">
    </div>
    <div class="flex flex-col w-2/3 ml-5">
      <div class="bg-gray-50 px-6 py-4 shadow rounded-lg">
        <div class="flex justify-between">
          <span class=" text-xl">수업 내역</span>
        </div><br>
      </div><br>
    </div>
  </div>
  <!-- 내 활동 -->
  <div class="flex max-w-5xl justify-end mx-auto">
    <div class="flex flex-col w-1/3">
    </div>
    <div class="flex flex-col w-2/3 ml-5">
      <div class="bg-gray-50 px-6 py-4 shadow rounded-lg">
        <div class="flex justify-between">
          <span class=" text-xl">내 활동</span>
        </div><br>
      </div><br>
    </div>
  </div>
</body><br><br><br><br><br><br>

</html>