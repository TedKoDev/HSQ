<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">    
  </head>      
  <script defer src = "../commenJS/cookie.js"></script> 
  <script src = "./teacherdetail.js"></script>    
  <body class = "bg-gray-100">   
    <!-- 네비바 -->
    <?php include '../components/navbar.php' ?>    
    <br>
    <div class = "flex max-w-4xl mx-auto">        
        <div class = "flex flex-col w-3/4 border-2">
            <div class = "flex">
                <!-- 프로필 이미지 -->
                <div>
                    <img id = "profile_image" class = "w-20 h-20 border-3 border-gray-900 rounded-full " 
                    src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>
                </div>
                <!-- 이름, 강사 자격, 구사 가능 언어 -->
                <div class = "flex flex-col">
                    <div>이름</div>
                    <div>강사 자격</div>
                    <div class = "flex">
                        <div>구사 언어 : </div>
                    </div>
                </div>
            </div>
            <!-- 자기 소개, 강의 스타일 항목 선택-->
            <div class = "flex">
                <div>자기 소개</div>
                <div>강의 스타일</div>
            </div>
            <!-- (자기소개, 강의스타일) 텍스트 -->
            <div>안녕하세요 저는...</div>
        </div>        
        <div class = "flex flex-col w-1/4 border-2">
            <div>강의 예약</div>
            <div>강사에게 연락하기</div>
        </div>
    </div>
    <!-- 평점, 학생, 수업, 출결, 응답률 -->
    <div class = "flex max-w-4xl mx-auto border-2">
        <div class = "flex w-3/4 border-2">
            <div class = "flex flex-col w-1/5">
                <div class = "mx-auto">4.8</div><div class = "mx-auto">평점</div>
            </div>
            <div class = "flex flex-col w-1/5">
                <div class = "mx-auto">350</div><div class = "mx-auto">학생</div>
            </div>
            <div class = "flex flex-col w-1/5">
                <div class = "mx-auto">1,828</div><div class = "mx-auto">수업</div>
            </div>
            <div class = "flex flex-col w-1/5">
                <div class = "mx-auto">100%</div><div class = "mx-auto">출결</div>
            </div>
            <div class = "flex flex-col w-1/5">
                <div class = "mx-auto">100%</div><div class = "mx-auto">응답률</div>
            </div>
        </div>
    </div>
    <div class = "flex flex-col mt-3 mb-2 max-w-4xl mx-auto">
        <div class = "w-3/4 border-2">수업</div>
         <!-- 수업 목록 -->
        <div class = "flex flex-col w-3/4 border-2">
            <div class = "flex">
                <div class = "flex flex-col">
                    <div>수업 제목</div>
                    <div class = "flex">
                        <a>수업 레벨</a> <a>수업 유형</a> <a>수업 횟수</a>
                    </div>
                </div>
                <div>
                    가격
                </div>
            </div>
        </div>
    </div>
   
  </body>        
</html>

