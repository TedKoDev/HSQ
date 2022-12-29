<script type="module" defer = "defer" src="/findclass/dropdownList/classTime.js"></script> 
<div id="classTime" class="hidden z-10 w-96 bg-white rounded-xl shadow">
    <br>
    <div class="px-3 py-2">
        <div class = "flex justify-between">
            <div class = "prev_btn">
                <button>
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
                </button>
            </div>
            <div class = "text-sm text-gray-800">
                <span>2022년 12월 22일</span>
                <span> - </span>
                <span>2022년 12월 28일</span>
            </div>
            <div class = "next_btn">
                <button>
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>
                </button>
            </div>
        </div>                
        <div class = "flex justify-center">
            <?php for ($i = 0; $i < 7; $i++) 
            
            {?>
            <input type="checkbox" id = "dateBtn_<?php echo $i + 1; ?>" name = "filter_date" value="" class="hidden" />
            <label for="dateBtn_<?php echo $i + 1; ?>" class="filter_checkbox hover:bg-gray-300 rounded-lg">
                <div class = "flex flex-col px-2 py-1 mx-2">
                    <span id = "day_<?php echo $i + 1; ?>" class = "small_text text-center">월</span>
                    <span id = "date_<?php echo $i + 1; ?>" class = "text-sm text-center">1</span>
                </div>
            </label>  
            <?php } ?>              
        </div>        
        <div class = "flex w-full items-center justify-center">
        <hr class = "w-2/5"><span class = "small_text px-2 text-gray-400">오전</span><hr class = "w-2/5">
        </div>
            <div class = "flex w-4/5 justify-between mx-auto">
                <?php for ($i = 0; $i < 6; $i++) 
                
                {?>
                <input type="checkbox" id = "timeBtn_<?php echo $i + 1; ?>" name = "filter_date" value="" class="hidden" />
                <label for="timeBtn_<?php echo $i + 1; ?>" class="filter_checkbox text-xs text-gray-800 rounded-2xl hover:bg-gray-300 px-1 py-1 mx-1"><?php echo sprintf('%02d',$i); ?>:00</label>                    
                  
                <?php } ?>                 
            </div>
            <div class = "flex w-4/5 justify-between mx-auto">
                <?php for ($i = 6; $i < 12; $i++) 
                
                {?>
                <input type="checkbox" id = "timeBtn_<?php echo $i + 1; ?>" name = "filter_date" value="" class="hidden" />
                <label for="timeBtn_<?php echo $i + 1; ?>" class="filter_checkbox text-xs text-gray-800 rounded-2xl hover:bg-gray-300 px-1 py-1 mx-1"><?php echo sprintf('%02d',$i); ?>:00</label>                    
                  
                <?php } ?> 
            </div>
        <div class = "flex w-full items-center justify-center">
        <hr class = "w-2/5"><span class = "small_text px-2 text-gray-400">오후</span><hr class = "w-2/5">
        </div>
            <div class = "flex w-4/5 justify-between mx-auto">
                <?php for ($i = 12; $i < 18; $i++) 
                
                {?>
                <input type="checkbox" id = "timeBtn_<?php echo $i + 1; ?>" name = "filter_date" value="" class="hidden" />
                <label for="timeBtn_<?php echo $i + 1; ?>" class="filter_checkbox text-xs text-gray-800 rounded-2xl hover:bg-gray-300 px-1 py-1 mx-1"><?php echo sprintf('%02d',$i); ?>:00</label>                    
                  
                <?php } ?> 
            </div>
            <div class = "flex w-4/5 justify-between mx-auto">
                <?php for ($i = 18; $i < 24; $i++) 
                
                {?>
                <input type="checkbox" id = "timeBtn_<?php echo $i + 1; ?>" name = "filter_date" value="" class="hidden" />
                <label for="timeBtn_<?php echo $i + 1; ?>" class="filter_checkbox text-xs text-gray-800 rounded-2xl hover:bg-gray-300 px-1 py-1 mx-1"><?php echo sprintf('%02d',$i); ?>:00</label>                    
                  
                <?php } ?>
            </div>
    </div>    
</div>