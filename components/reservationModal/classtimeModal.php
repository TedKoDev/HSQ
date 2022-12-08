<div
    class="reserve-modal-time h-full w-full fixed bottom-0 justify-center items-center bg-black bg-opacity-50 hidden">
    <div class="flex flex-col-reverse w-full h-full">
        <!-- modal -->
        <div class="bg-white rounded shadow-lg w-full h-5/6">
            <!-- modal_header -->
            <div class="flex justify-between px-3 items-center">
                <svg
                    class="beforeArrow_cltime float-right h-8 w-8 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/>
                </svg>
                <div class="text-base text-center border-b-1 py-3">수업 시간을 선택하세요

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
            <div class="class-time flex flex-col max-w-3xl mx-auto h-4/5">
                <div class="flex mx-auto w-2/3 justify-between h-1/3 my-auto">
                    <div class="flex flex-col justify-center w-1/3">
                        <span class="text-center">30분</span>
                        <div
                            id="item_30_1"
                            class="time-item my-2 flex justify-between text-center bg-gray-50 rounded-2xl px-2 py-2 shadow hover:shadow-lg shadow-gray-200"
                            value="0"
                            name="30_1">
                            <span class="text-center">1회 수업</span>
                            <span class="price30_1"></span>
                        </div>
                        <div
                            id="item_30_5"
                            class="time-item my-2 flex justify-between text-center bg-gray-50 rounded-2xl px-2 py-2 shadow hover:shadow-lg shadow-gray-200"
                            value="0"
                            name="30_5">
                            <span class="text-center">5회 수업</span>
                            <span class="price30_5"></span>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center w-1/3 text-base">
                        <span class="text-center">60분</span>
                        <div
                            id="item_60_1"
                            class="time-item my-2 flex justify-between text-center bg-gray-50 rounded-2xl px-2 py-2 shadow hover:shadow-lg  shadow-gray-200"
                            value="0"
                            name="60_1">
                            <span>1회 수업</span>
                            <span class="price60_1"></span>
                        </div>
                        <div
                            id="item_60_5"
                            class="time-item my-2 flex justify-between text-center bg-gray-50 rounded-2xl px-2 py-2 shadow hover:shadow-lg shadow-gray-200"
                            value="0"
                            name="60_5">
                            <span>5회 수업</span>
                            <span class="price60_5"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t flex items-center justify-between px-4">
                <div class="flex">
                    <span class="cl-name mx-1 px-1 py-1 text-gray-500"></span>
                    <span class="cl-time mx-1 px-1 py-1 text-gray-500"></span>
                    <span class="cl-schedule mx-1 px-1 py-1 text-gray-500"></span>
                    <span class="cl-communication mx-1 px-1 py-1 text-gray-500"></span>
                </div>
                <div class="flex justify-end items-center w-100 p-3 bottom-0">
                    <span class="cl-price mx-1 px-1 py-1 text-gray-800"></span>
                    <button
                        class="nextBtn_ct bg-gray-200 px-3 py-1 rounded text-white"
                        disabled="disabled"
                        type="button">다음</button>
                </div>
            </div>

        </div>
    </div>
</div>