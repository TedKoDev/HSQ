<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/output.css" rel="stylesheet">
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <!-- 쿠기 생성, 가져오기, 삭제 -->
  <script defer="defer" src="/commenJS/cookie.js"></script>
  <script defer src="./myinfo.js"></script>
  <script>

  </script>
</head>

<body class="bg-gray-100">
  <!-- 네비바 -->
  <?php include '../components/navbar/navbar.php' ?>
  <!-- 로그인 블록 -->
  <br>
  <div class="flex max-w-5xl justify-between mx-auto">
    <!-- 왼쪽 상단에 유저 이미지, 이름등의 정보 블록 -->
    <div class="flex flex-col w-1/3 bg-gray-50 px-4 py-4 shadow rounded-lg">
      <div class="mx-auto">
        <img id="profile_image" class="w-24 h-24 border-3 border-gray-900 rounded-full" src="<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>
      </div>
      <div id="name" class="text-lg"></div>
      <div class="text-sm">
        <a id="age"></a> <a id="sex"></a><a id="country"></a><a id="residence"></a>
      </div>
    </div>
    <!-- 우측의 유저 정보 (자기소개, 국적, 언어 구사수준등등) -->
    <div class="flex flex-col w-2/3 ml-5">
      <div class="bg-gray-50 px-6 py-4 shadow rounded-lg mb-6">
        <div class="flex justify-between">
          <span class=" text-xl">프로필</span>
          <a href="../editprofile/" class="py-1 px-3 bg-gray-300 text-gray-900 hover:bg-gray-400
             hover:text-black rounded border border-">프로필 편집</a>
        </div><br>
        <div id="intro" class="text-sm">
        </div><br>
        <a class="text-sm mb-2">구사 가능 언어 : </a> <a id="language" class="text-sm ml-4"></a>
        <br>
        <a class="text-sm mb-2">한국어 구사 능력 : </a> <a id="korean" class="text-sm ml-4"></a>
        <br>
      </div>
    </div>
  </div>
  </div>
  <!-- 수업 내역 -->
  <div class="flex  max-w-5xl justify-end mx-auto">
    <div class="flex flex-col w-1/3">
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
    <!-- 강사(해당 유저가 강사일 경우에만 표시)  -->
    <div id="teacherInfo_div" class="flex max-w-5xl justify-end mx-auto">
      <div class="flex flex-col w-1/3">
      </div>
      <div class="flex flex-col w-2/3 ml-5">
        <div class="bg-gray-50 px-6 py-4 shadow rounded-lg">
          <div class="flex justify-between">
            <span class=" text-xl">강사 정보</span>
          </div><br>
          <div id="t_intro" class="text-sm">강사입니다
          </div>
          <br>
          <a class="text-sm mb-2 pt-1">결제 링크 : </a>
          <div id="payment_div" class="flex flex-col text-sm"></div>
        </div><br>
      </div>
    </div>
</body><br><br><br><br><br><br>

</html>