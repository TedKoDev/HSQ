<div
    class="reserve-modal-schedule h-full w-full fixed bottom-0 justify-center items-center bg-black bg-opacity-50 hidden">
    <div class="flex flex-col-reverse w-full h-full">
        <!-- modal -->
        <div class="flex flex-col justify-between bg-white rounded shadow-lg w-full h-5/6">
            <!-- modal_header -->
            <div class="flex justify-between px-3 items-center h-1/8 border-b">
                <svg
                    class="beforeArrow_clschedule float-right h-8 w-8 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/>
                </svg>
                <div class="text-base text-center border-b-1 py-3">수업 일정을 선택하세요

                </div>
                <svg
                    class="close-modal float-right h-8 w-8 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                    id="close-modal"
                    fill="currentColor"
                    viewbox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0
                            111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293
                            4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <!-- modal_body -->
            <div class="class-schedule flex flex-col max-w-3xl mx-auto h-3/4">                
                <div class="flex flex-col w-full bg-gray-50 rounded-lg px-4 py-2 shadow h-full">                    
                    <div class = "flex max-w-3xl justify-around px-2 mb-2">
                        <div class = "flex">
                            <div class = "flex items-center">
                                <a class = "bg-blue-600 rounded-full px-1 py-1"></a>
                                <span class = "ml-1 mr-2">예약 가능</span>
                                <a class = "bg-gray-800 rounded-full px-1 py-1"></a>
                                <span class = "ml-1 mr-2">예약 불가</span>
                            </div>                    
                        </div>
                        <div class="flex ml-auto">
                            <button id = "beforeDate_btn_cs" onclick = "change_schedule_sm('before', 'header_s_sm', '_sm_l', '_sm')" class = "disabled: border-2 border-gray-200 bg-gray-200 text-gray-50 px-1 py-1 rounded ml-1 mr-1">이전</button>
                            <button id = "afterDate_btn_cs" onclick = "change_schedule_sm('after', 'header_s_sm', '_sm_l', '_sm')" class = "border-2 border-gray-400 bg-gray-300 hover:bg-gray-400 px-1 py-1 rounded ml-1 mr-1">다음</button>
                        </div>
                    </div>       
                    <div id="schedule" class="flex flex-col overflow-auto">
                        <div id="header_s_sm" class="flex mx-auto">

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
                                                    id="<?php echo $num; ?>_sm"
                                                    name=""
                                                    value="<?php echo $num; ?>"
                                                    class="hidden"  
                                                    onclick = "scheduleClick(this);"                                                  
                                                    disabled/>
                                                <label
                                                    for="<?php echo $num; ?>_sm"
                                                    id="<?php echo $num; ?>_sm_l"
                                                    class="label_sm px-3 py-1 mx-auto w-full h-5 font-semibold bg-gray-400 text-white
                                                        rounded border"
                                                    name="">
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
                    <div class = "text-center">시간대 <a id = "utc_scheduleModal"></a></div>                                  
                </div>   
            </div>
                
            <div class = "border-t flex items-center justify-between px-4 h-1/8">
                <div class = "flex">
                    <span class = "cl-name mx-1 px-1 py-1 text-gray-500"></span>
                    <span class = "cl-time mx-1 px-1 py-1 text-gray-500"></span>
                    <span class = "cl-schedule mx-1 px-1 py-1 text-gray-500"></span>
                    <span class = "cl-communication mx-1 px-1 py-1 text-gray-500"></span>
                </div>
                <div class="flex justify-end items-center w-100 p-3 bottom-0">
                    <span class = "cl-price mx-1 px-1 py-1 text-gray-800"></span>
                    <button class="nextBtn_cs bg-gray-200 px-3 py-1 rounded text-white" disabled type="button">다음</button>
                </div>
            </div>          
        </div>
    </div>
</div>