<script type="module" defer = "defer" src="/components/findpw/findpw.js"></script> 
<div
    class="findpwModal hidden bg-gray-700 bg-opacity-50 w-full h-full fixed inset-0 justify-center items-center border-2"
    >
    <div class="bg-gray-50 w-2/5 py-2 px-3 rounded shadow-xl text-gray-800 mx-auto my-24">
        <div class = "flex flex-col">
            <div class = "flex justify-between border-b-2 border-gray-200">
                <div class = "mx-auto">비밀번호 찾기</div>
                <svg                
                    class="closeBtn h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
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
            <span class = "text-sm text-gray-800 mb-4">가입한 이메일로 인증 메일이 발송됩니다.</span>
            <input id = "memo" class = "inputMsg w-full mx-auto text-sm px-1 py-1 rounded border-2 border-gray-800"
                placeholder = "이메일"/>       
            <span class = "warnText_modal text-xs hidden text-red-500 mt-1">존재하지 않는 이메일입니다.</span>           
            <div class = "flex-row-reverse mr-0">
                <a class = "sendBtn text-right mt-2 mx-1 px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded float-right">인증 메일 전송</a>  
                                        
            </div>                          
        </div>                       
    </div>               
</div>