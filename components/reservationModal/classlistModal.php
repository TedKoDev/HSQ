<div
    class="reserve-modal-class h-full w-full fixed bottom-0 justify-center items-center bg-black bg-opacity-50 hidden">
    <div class="flex flex-col-reverse w-full h-full">
        <!-- modal -->
        <div class="flex flex-col justify-between bg-white rounded-t-lg shadow-lg w-full h-5/6">
            <!-- modal_header -->
            <div class="flex justify-between px-3 items-center h-1/8 border-b">
                <svg
                    class="float-right h-8 w-8 cursor-pointer p-1 hover:bg-gray-300 rounded-full invisible"
                    width="24"
                    height="24"
                    xmlns="http://www.w3.org/2000/svg"
                    fill-rule="evenodd"
                    clip-rule="evenodd"><path
                    d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/>
                </svg>
                <div class="text-base text-center border-b-1 py-3">수업 유형을 선택하세요

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
            <div class="class-list flex flex-col w-2/3 mx-auto h-3/4"></div>
            <div class="border-t-2 flex items-center justify-between px-4 h-1/8 bottom-0">
                <div class="flex">
                    <div class="cl-name mx-1 px-1 py-1 text-gray-500"></div>
                    <div class="cl-time mx-1 px-1 py-1 text-gray-500"></div>
                    <div class="cl-schedule mx-1 px-1 py-1 text-gray-500"></div>
                    <div class="cl-communication mx-1 px-1 py-1 text-gray-500"></div>
                </div>
                <div class="flex justify-end items-center w-100 p-3 bottom-0">
                    <button
                        class="nextBtn_cl bg-gray-200 px-3 py-1 rounded text-white"
                        disabled="disabled"
                        type="button">다음</button>
                </div>
            </div>

        </div>
    </div>
</div>