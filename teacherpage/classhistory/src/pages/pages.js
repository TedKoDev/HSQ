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



export const getFilterInit = ($filter) => {   

    $filter.classList.add('hidden');
}
