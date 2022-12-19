<div
    class="acceptModal bg-gray-700 bg-opacity-50 w-full h-full fixed inset-0 hidden justify-center items-center border-2"
    >
    <div class="bg-gray-50 w-1/2 py-2 px-3 rounded shadow-xl text-gray-800 mx-auto my-24">
        <div class = "flex flex-col">
            <div class = "flex justify-between border-b-2 border-gray-200">
                <div class = "mx-auto">수업 일정 확정</div>
                <svg                        
                    class="acceptModalCloseBtn h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
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
            <div class = "font-semibold" id = "clname_m">수업을 확정 하시겠습니까?</div>
            <br>
            <div class = "text-sm text-gray-500" >확정 시 신청한 학생에게 수업 승인 여부 및 수업 정보가 포함된 메세지가 전달됩니다.</div>
            <div class = "flex-row-reverse mr-0">
                <a class = "acceptBtn text-right mt-2 mx-1 px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded float-right">확정하기</a>   
                <a class = "acceptModalCloseBtn text-right mt-2 mx-1 px-2 py-1 bg-gray-300 hover:bg-gray-400 text-gray-500 rounded float-right">취소</a>                             
            </div>                          
        </div>                       
    </div>               
</div> 