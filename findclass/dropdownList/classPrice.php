<div id="classPrice" class="hidden z-10 w-48 bg-white rounded-xl shadow">

    <div class="px-4 py-2 flex flex-col justify-center">
        <div class="values text-xs">
            <span class = "">$</span><span class = "mx-1" id="range1">
                0 
            </span><span class = "">USD</span>
            <span> &dash; </span>
            <span class = "">$</span><span class = "mx-1" id="range2">
                1000
            </span><span class = "">USD</span>
        </div>
        <br>
        <div class="flex flex-col justify-center">
            <div class="slider-track"></div>
            <div class = "flex">
                <input type="range" min="0" max="1000" value="0" id="slider-1" oninput="slideOne()">
                <span class = "ml-1 text-xs text-gray-600">최저</span>
            </div>
            <div class = "flex">
                <input type="range" min="0" max="1000" value="1000" id="slider-2" oninput="slideTwo()">
                <span class = "ml-1 text-xs text-gray-600">최고</span>
            </div>
        </div>
    </div>    
</div>