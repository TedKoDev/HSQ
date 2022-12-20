<div
    class="reserve-modal-cmtool h-full w-full fixed bottom-0 justify-center items-center bg-black bg-opacity-50 hidden">
    <div class="flex flex-col-reverse w-full h-full">
        <!-- modal -->
        <div class="flex flex-col justify-between bg-white rounded shadow-lg w-full h-5/6">
            <!-- modal_header -->
            <div class="flex justify-between px-3 items-center h-1/8 border-b">
                <svg
                    class="beforeArrow_cltool float-right h-8 w-8 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/>
                </svg>
                <div class="text-base text-center border-b-1 py-3">커뮤니케이션 도구 선택

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
            <div class="class-time flex flex-col max-w-3xl mx-auto h-3/4">       
                <div class = "text-xs text-gray-600 text-center w-1/3 mx-auto mt-10">
                    강사님은 다음 커뮤니케이션 도구 중 하나를 사용할 수 있어요. 회원님은 어떤 커뮤니케이션 도구를 사용해서 강의를 진행하고 싶나요?
                </div><br><br>       
                <div class = "flex mx-auto w-4/5 justify-around" >                    
                    <div class = "toolBtn flex w-5/12 text-sm items-center justify-center mx-auto px-2 py-2 border border-gray-300 rounded hover:shadow" value = "0"
                    onclick = "toolClick('hs_meta')" id = "hs_meta" name = "HangleSquare Metaverse">
                        <img class = "w-5 h-5" 
                        src = "../images_forHS/logo.png"></img>
                        <span class = "mx-1 text-gray-600">HangleSquare Metaverse</span>
                    </div>
                    <div class = "toolBtn flex w-5/12 text-sm items-center justify-center mx-auto px-2 py-2 border border-gray-300 rounded hover:shadow" value = "0"
                    onclick = "toolClick('skype')" id = "skype" name = "Skype">
                        <img class = "w-5 h-5" 
                            src = "../images_forHS/skype_logo.png"></img>
                        <span class = "mx-1 text-gray-600">Skype</span>
                    </div>
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
                    <button class="nextBtn_cct bg-gray-200 px-3 py-1 rounded text-white" disabled type="button">다음</button>
                </div>
            </div>          
        </div>
    </div>
</div>