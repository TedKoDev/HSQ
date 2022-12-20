// 클릭한 타입의 텍스트 굵게 하고 하단에 색깔 칠하기
export const changeSelectBtnStyle = (target, $historyType) => {

    // console.log($historyType);
    const classType = $historyType;
    for (let i = 0; i < classType.length; i++) {
        classType[i].setAttribute(
            "class",
            "historyType mx-2 py-5 font-normal text-sm border-0"
        );

        // console.log("change_pass");
    }
    target.setAttribute(
        "class",
        "historyType mx-2 py-5 font-semibold text-sm border-b-4 border-blue-400 text-gr" +
                "ay-800"
    )
};

// export const getFilterblock = ($filter) => {

//     $filter.innerHTML = `<form action = '/teacherpage/classhistory/classlist/' method = 'get'>
//                           <div class = "flex w-full">                          
//                               <select class = "classType text-gray-400 selectClassType w-1/3 px-1 py-1 rounded border border-gray-200 mb-3 mx-1" name = "class_type">
//                               <option class = "" value="" disabled selected hidden>수업 상태</option>
//                               <option class = "text-gray-800" value = "all">모든 수업</option>
//                               <option class = "text-gray-800" value = "done">완료된 수업</option> 
//                               <option class = "text-gray-800" value = "approved">예정된 수업</option>  
//                               <option class = "text-gray-800" value = "wait">예약 승인 대기중</option>
//                               <option class = "text-gray-800" value = "cancel">취소된 수업</option>              
//                               </select>
//                               <input type = "text" name = "class_name" class = "className w-1/3 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1" placeholder = "수업명"></input>
//                               <input type = "text" name = "user_name" class = "userName w-1/3 text-sm px-1 py-1 rounded border border-gray-200 mb-3 mx-1" placeholder = "학생명"></input>                                                       
//                           </div>
//                           <div class = "flex justify-between items-center">
//                             <div class = "flex w-full">                            
//                                 <div class = "flex flex-col w-1/3">
//                                     <span class = "classStart text-xs text-gray-700 ml-2 mb-1">시작일</span>
//                                     <input type = "date" name = "time_from" class = "text-xs text-gray-500 px-1 py-1 rounded border border-gray-200 mb-3 mx-1" placeholder = "수업 날짜(시작)"></input>
//                                 </div>
//                                 <div class = "flex flex-col w-1/3">
//                                     <span class = "classEnd text-xs text-gray-700 ml-2 mb-1">종료일</span>
//                                     <input type = "date" name = "time_to" class = "text-xs text-gray-500 px-1 py-1 rounded border border-gray-200 mb-3 mx-1" placeholder = "수업 날짜(종료)"></input>
//                                 </div>                              
//                             </div>                            
//                               <button type = "summit" class="searchBtn bg-blue-500 hover:bg-blue-600 text-white rounded-lg w-1/5 h-8
//                               border-blue-900 px-1 text-sm">검색
//                               </button>
//                           </div>
//                         </form><br>
//                         <div class = "bg-sky-500 text-white text-xs pl-2 py-1 mx-2">UTC <span class = "utc">09:00</span></div>`;
// }

export const getFilterInit = ($filter) => {   

    $filter.classList.add('hidden');
}
