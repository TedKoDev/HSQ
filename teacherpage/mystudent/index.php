<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/output.css" rel="stylesheet">

    </head>    
    <script type="module" defer="defer" src="./mystudent.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>    
    <body class="bg-gray-100 w-full">
        <!-- 네비바 -->
        <?php include '../../components/navbar/navbar.php' ?>
        <!-- 강사용 네비바 -->
        <?php include '../../components/navbar/navbar_t.php' ?>
        <br><br>
        <div class = "w-3/4 flex flex-col mx-auto">
            <span class = "font-bold text-2xl">내 수강생</span><br>
            <div class="flex justify-end">
                <div class="mb-3 xl:w-60">
                    <div class="flex items-stretch w-full">
                        <input type="search" class="searchInput flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="학생 이름" aria-label="Search" aria-describedby="button-addon2">
                        <button class="searchBtn px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" type="button" id="button-addon2">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class = "flex justify-end">
                <select class = "w-52 px-1 py-1 text-sm text-gray-500 border-gray-200 rounded border mb-3">
                  <option value = ''>순서 변경</option>
                  <option value = ''>최근에 수강한 학생 순</option>
                  <option value = ''>가장 많이 수강한 학생 순</option>                  
                </select>                  
            </div>
            <div class = "studentList_div flex bg-gray-50 rounded-lg px-2 py-2 flex-wrap">                                                   
            </div>
        </div>
    </body>
</html>