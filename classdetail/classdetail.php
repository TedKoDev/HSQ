<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../dist/output.css" rel="stylesheet">
    </head>
    <script defer="defer" src="/commenJS/cookie.js"></script>
    <script defer="defer" src="./classdetail.js"></script>
    <script defer="defer" src="../components/reservationModal/classtimeModal.js"></script>
    <script defer="defer" src="../components/reservationModal/scheduleModal.js"></script>
    <script defer="defer" src="../components/reservationModal/streamingtoolModal.js"></script>
    <script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
    <style>
        .scrollLock {
            height: 100%;
            overflow: hidden;
        }
    </style>
    <body class="bg-gray-100">
        <!-- 네비바 -->
        <?php include '../components/navbar/navbar.php' ?>
        <br>
        <div class="flex max-w-4xl mx-auto justify-between">
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg px-4 py-2 mb-3 shadow">
                <div id = "c_name" class = "text-lg font-semibold">            
                    수업 이름
                </div>               
                <div class = "flex">
                    <div id = "c_level" class = "text-sm text-gray-500">
                        
                    </div>
                    <div id = "c_type" class = "text-sm">
                        
                    </div>
                </div><br>
                <div id = "c_disc" class = "text-sm">
                    수업 설명
                </div>
            </div>
            <div class="flex flex-col w-1/5 py-2 rounded-lg bg-gray-50 shadow ">
                <div class = "px-4">
                    <div>30분 : <span id = "c_price30"></span>$</div> 
                    <div>60분 : <span id = "c_price60"></span>$</div> 
                </div>                
                <div class = "px-4 py-2 text-center ">
                    <div class = "show-reserve bg-blue-500 hover:bg-blue-600 text-white rounded-lg border-blue-900 px-1 py-1 my-1">수업 예약</div>
                    <div class = " bg-gray-500 hover:bg-gray-600 text-white rounded-lg border-gray-900 px-1 py-1 my-1">강사에게 연락하기</div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col mt-3 mb-2 max-w-4xl mx-auto">            
            <!-- 강사 정보 -->
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg px-4 py-2 shadow">
                <div class="w-3/4 mb-3">강사 프로필</div>
                <div class = "flex">
                    <img id = "t_img" class = "w-20 h-20 mr-2 border-3 border-gray-900 rounded-full " 
                    src = "<?php echo $hs_url; ?>images_forHS/userImage_default.png"></img>
                    <div class = "flex flex-col">
                        <div id = "t_name" class = "font-semibold">강사 이름</div>
                        <div id = "t_certi" class = "mt-1 text-xs font-semibold text-gray-500">강사 자격</div>
                        <div class = "flex">
                            <span id = "t_country" class = "text-xs text-gray-500"></span> 
                            <span id = "t_residence" class = "text-xs text-gray-500 ml-1"></span>
                        </div>
                        <div id = "t_speaks" class = " mt-2 text-sm text-gray-500">Speaks : 

                        </div>
                    </div>
                </div>
                <div id = "t_intro" class = "mt-3 text-sm">
                    강사 설명
                </div>
            </div>
        </div>
        <div class="flex flex-col mt-3 mb-2 max-w-4xl mx-auto">
            <div class="w-3/4 mb-1">수업 가능한 시간</div>           
            <!-- 일정 표시 -->
            <div class="flex flex-col w-3/4 bg-gray-50 rounded-lg px-4 py-2 shadow">
                
                <div class = "flex max-w-3xl justify-around px-2 mb-2">
                    <div class = "flex">
                        <div class = "flex items-center">
                            <a class = "bg-blue-600 rounded-full px-1 py-1"></a>
                            <span class = "ml-1">예약 가능</span>
                            <a class = "bg-gray-400 rounded-full px-1 py-1 ml-2"></a>
                            <span class = "mx-1">예약 불가</span>      
                        </div>                    
                    </div>
                    <div class="flex ml-auto">                       
                        <button id = "beforeDate_btn" onclick = "change_schedule('before', 'header_s', '_l', '')" class = "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">이전</button>
                        <button onclick = "change_schedule('after', 'header_s', '_l', '')" class = "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">다음</button>
                    </div>
                </div>       
                <div id="schedule" class="flex flex-col h-96 overflow-auto">
                    <div id="header_s" class="flex mx-auto">

                    </div>
                    <div id = "body_s" class = "flex mx-auto">
                        <?php 
                        $num = 0;
                            for ($i = 0; $i < 8; $i++) {
                            
                                if ($i == 0) {
                                ?>
                                    <div id = "body_s_<?php echo $i; ?>" class = "flex flex-col">
                                <?php 
                                    $add = 0;
                                    for ($j = 0; $j < 48; $j++) {

                                        $add = $add + 30;
                                        $hour = sprintf('%02d', $add / 60);
                                        $minute = sprintf('%02d', $add % 60);
                                    ?>
                                        <div class="flex items-center w-20 h-5">
                                            <div>
                                                <span>~
                                                    <?php  echo $hour; ?></span>
                                                :
                                                <span><?php echo $minute; ?></span>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                    </div>
                                <?php
                                }
                                else {
                                ?>
                                     <div id = "body_s_<?php echo $i; ?>" class = "flex flex-col">
                                <?php 
                                    
                                    for ($j = 1; $j <= 48; $j++) {

                                        $num = $num + 1; 
                                    ?>
                                        <div class="flex items-center w-20">
                                            <input
                                                type="checkbox"
                                                id="<?php echo $num; ?>"
                                                name=""
                                                value="<?php echo $num; ?>"
                                                class="hidden"
                                                onclick='test_click(event)'
                                                disabled/>
                                            <label
                                                for="<?php echo $num; ?>"
                                                id="<?php echo $num; ?>_l"
                                                class="px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                                    rounded border"
                                                name="schedule_label">
                                            </label>
                                        </div>
                                <?php
                                    }
                                ?>
                                    </div>
                                <?php
                                }
                            }
                        ?>
                    </div>
                </div>                 
                <div class = "text-center">시간대 <a id = "utc"></a></div>     
                <div class = "text-sm text-gray-500 text-center">(내정보 -> 프로필 편집에서 원하는 UTC 시간대를 설정할 수 있습니다.)</div>          
            </div>            
            <br><br><br><br>
        </div>
        <!-- 모달창 -->
        <div
            class="bg-gray-700 bg-opacity-50 w-full fixed inset-0 hidden justify-center items-center border-2"
            id="overlay">
            <div class="bg-gray-50 w-2/3 py-2 px-3 rounded shadow-xl text-gray-800">
                <div class = "flex flex-col">
                    <div class = "flex justify-between border-b-2 border-gray-200">
                        <div class = "">수업 상세 정보</div>
                        <svg                        
                            class="h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                            id="close-modal"
                            fill="currentColor"
                            viewbox="0 0 20 20"
                            >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div><br>
                    <div class = "font-semibold" id = "clname_m">한국어 기초</div>
                    <br>
                    <div class = "text-sm text-gray-500" > 레벨 </div>
                    <div id = "cllevel_m"></div><br>
                    <div class = "text-sm text-gray-500"> 유형 </div>
                    <div class = "flex" id = "cltype_m">                      
                    </div><br>
                    <div class = "text-sm text-gray-500">설명</div>
                    <div id = "cldesc_m">기초 한국어 수업입니다</div><br>
                    <div class = "text-sm text-gray-500">가격</div>
                    <a id = "clprice30_m">30분 : 12 $</a><a id = "clprice60_m">60분 : 24 $</a>                    
                </div>
                <a class = "w-16 mt-2 px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded float-right">예약하기</a>               
            </div>                            
        </div>             
        <!-- 수업 시간 모달창(예약) -->   
        <?php include '../components/reservationModal/classtimeModal.php'?>
        <!-- 수업 일정 모달창(예약) -->   
        <?php include '../components/reservationModal/scheduleModal.php'?>
        <!-- 커뮤니케이션 도구 모달창(예약) -->   
        <?php include '../components/reservationModal/streamingtoolModal.php'?>   
    </body>    
</html>