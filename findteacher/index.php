<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script src="../commenJS/cookie.js"></script>
    <script src="./findteacher.js"></script>

    <script></script>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>       
        <br><br>
        <div class = "flex-col justify-center mx-auto max-w-3xl items-center">
            <div class = "font-bold text-2xl">강사 찾기</div><br>     
            <div class="flex justify-end">
                <div class="mb-3 xl:w-80">
                    <div class="flex items-stretch w-full">
                        <input type="search" class="form-control flex-auto min-w-0 block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" placeholder="강사 이름" aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700  focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" type="button" id="button-addon2">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>        
        </div>    
        <div id = "teacher_list" class = "flex flex-col justify-center max-w-3xl mx-auto bg-gray-100 rounded-lg ">

            
            
        </div><br>
        <div class = "flex">
            <div id = "see_more" class = "hidden my-5 py-2 w-1/6 mx-auto bg-gray-50 text-center rounded-md 
                border-gray-400 shadow" onclick = "see_more()">더 보기
            </div>
        </div>
    </body>
</html>