<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.1/dist/flowbite.min.css" />
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <!-- <link rel="stylesheet" src = "./seekbar.css"> -->
    <script defer="defer" src = "./seekbar.js"></script>
    <script defer="defer" src="../commenJS/cookie.js"></script> 
    <script type = "module" defer="defer" src="./findclass.js"></script>        
    <style>
    .line_clamp_2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    
    .small_text {
        font-size: 12px;
    }
    </style>
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>          
        <div class = "bg-gray-50">
            <br><br>
            <div class = "flex-col justify-center mx-auto max-w-3xl items-center">
                <div class = "font-bold text-2xl">한글스퀘어 수업

                </div><br>                                   
            </div>              
            <div class = "flex w-full px-3 mb-3 justify-between mx-auto py-2">
                <div class = "flex">             
                    <button id="classType_btn" data-dropdown-toggle="classType" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 py-2 text-center inline-flex items-center " type="button">수업 카테고리<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                    <button id="classTime_btn" data-dropdown-toggle="classTime" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 py-2.5 text-center inline-flex items-center " type="button">강의 시간<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                    <button id="teacherLanguage_btn" data-dropdown-toggle="teacherLanguage" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs mx-1 px-2 py-2.5 text-center inline-flex items-center " type="button">구사 가능 언어<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                    <button id="teacherSex_btn" data-dropdown-toggle="teacherSex" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 py-2.5 text-center inline-flex items-center " type="button">성별<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                    <button id="teacherCountry_btn" data-dropdown-toggle="teacherCountry" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs mx-1 px-2 py-2.5 text-center inline-flex items-center " type="button">출신지<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                    <button id="teacherType_btn" data-dropdown-toggle="teacherType" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 py-2.5 text-center inline-flex items-center " type="button">강사 유형<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>
                    <button id="classPrice_btn" data-dropdown-toggle="classPrice" class="text-gray-800 bg-gray-300 hover:bg-gray-400 font-medium rounded-2xl text-xs px-2 mx-1 py-2.5 text-center inline-flex items-center" type="button">수강료<svg class="ml-1 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>                    
                </div>
                <div>
                    <div class="flex justify-end">
                        <input type="search" class="form-control flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="수업 이름" aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" type="button" id="button-addon2">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                            </svg>
                        </button>
                    </div> 
                </div>                                
            </div>
        </div>        
        <div class = "">
            <div class = "filterItemList flex ml-1">

            </div>
            <div id = "class_list" class = "mt-2 flex flex-col justify-center max-w-3xl mx-auto bg-gray-100 rounded-lg ">
                            
            </div><br>        
            <div class = "flex">
                <button id = "see_more" class = "hidden my-5 py-2 w-1/6 mx-auto bg-gray-50 text-center rounded-md 
                    border-gray-400 shadow">더 보기
                </button>
            </div>   
        </div> 
        <!-- 드롭다운 메뉴 -->
        <!-- 언어 리스트랑 국가 리스트 -->
        <?php include '../commenJS/language_country.php' ?>             
        <!-- 수업 유형 -->
        <?php include './dropdownList/classType.php' ?> 
        <!-- 강의 시간 -->
        <?php include './dropdownList/classTime.php' ?> 
        <!-- 구사 가능 언어 -->
        <?php include './dropdownList/teacherLanguage.php' ?> 
        <!-- 성별 -->
        <?php include './dropdownList/teacherSex.php' ?> 
        <!-- 출신지 -->
        <?php include './dropdownList/teacherCountry.php' ?> 
        <!-- 강사 유형 -->
        <?php include './dropdownList/teacherType.php' ?> 
        <!-- 수강료 -->
        <?php include './dropdownList/classPrice.php' ?> 
        <script src="https://unpkg.com/flowbite@1.5.1/dist/flowbite.js"></script>    
    </body>
</html>