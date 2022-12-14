<div
    class="addReviewModal bg-gray-700 bg-opacity-50 w-full h-full fixed inset-0 hidden justify-center items-center border-2"
    >
    <div class="bg-gray-50 w-1/2 py-2 px-3 rounded shadow-xl text-gray-800 mx-auto my-24">
        <div class = "flex flex-col">
            <div class = "flex justify-between border-b-2 border-gray-200">
                <div class = "mx-auto">수업 후기 등록</div>
                <svg                        
                    class="reviewModalCloseBtn h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
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
            <div class = "font-base" id = "clname_m">수업에 대한 후기를 남겨주세요</div>      
            <div class = "my-2">      
                <span class="relative text-gray-400 text-xl">
                    ★★★★★
                    <span class = "addStar_modal text-xl w-0 absolute left-0 text-orange-500 overflow-hidden pointer-events-none">★★★★★</span>
                    <input class = "addStar_modal_value w-full h-full absolute left-0 opacity-0 cursor-pointer" type="range" oninput="drawStar(this)" value="1" step="1" min="0" max="10">
                </span>
            </div>
            <textarea rows = "5" class = "review_text w-full mx-auto text-sm px-1 py-1 rounded border border-gray-200"
                placeholder = "(수업/강사에 대한 후기)"></textarea>
            <!-- <div class = "text-sm text-gray-500" >확정 시 신청한 학생에게 수업 승인 여부 및 수업 정보가 포함된 메세지가 전달됩니다.</div> -->
            <div class = "flex-row-reverse mr-0">
                <a class = "sendReviewBtn text-right mt-2 mx-1 px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded float-right">등록하기</a>   
                <a class = "reviewModalCloseBtn text-right mt-2 mx-1 px-2 py-1 bg-gray-300 hover:bg-gray-400 text-gray-500 rounded float-right">취소</a>                             
            </div>                          
        </div>                       
    </div>               
</div> 