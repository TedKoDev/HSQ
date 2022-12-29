<div
    class="paymentModal bg-gray-700 bg-opacity-50 w-full h-full fixed inset-0 hidden justify-center items-center border-2"
    >
    <div class="bg-gray-50 w-1/2 py-2 px-3 rounded shadow-xl text-gray-800 mx-auto my-24">
        <div class = "flex flex-col">
            <div class = "flex justify-between border-b-2 border-gray-200">
                <div class = "mx-auto">결제 링크 전송</div>
                <svg                        
                    class="paymentModalCloseBtn h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
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
            <div class = "font-semibold" id = "clname_m">아래의 결제링크를 전송하시겠습니까?</div>
            <br>            
            <div class = "paymentList flex flex-col">

            </div>
            <div class = "flex-row-reverse mr-0">
                <a class = "sendLinkBtn text-right mt-2 mx-1 px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded float-right">예</a>   
                <a class = "paymentModalCloseBtn text-right mt-2 mx-1 px-2 py-1 bg-gray-300 hover:bg-gray-400 text-gray-500 rounded float-right">아니오</a>                             
            </div>                          
        </div>                       
    </div>               
</div>