import {changeSelectBtnStyle, getFilterblock} from "./pages.js";
import {$, $_all} from "/utils/querySelector.js";
import {classList_json} from "../../classhistory.js";
import {s3_url} from "../../../../commenJS/cookie_modules.js";


export function classhistorylist($container) {
    this.$container = $container;

    this.setState = () => {
        this.render();
    };

    this.render = () => {

        console.log("수업목록");

        changeSelectBtnStyle($('#classList'), $_all(".historyType"));

        // 수업 목록 이외의 부분 표시 (ex : 필터 관련된 input이랑 검색 버튼)
        getFilterblock($('.filter'));
        // 수업 목록 표시
        showClassList($container, classList_json);

    };

    this.render();
}


let week = new Array('일', '월', '화', '수', '목', '금', '토');
// 담아온 수업 리스트 json 파싱해서 화면에 표시
const showClassList = ($container, response) => {

    $container.innerHTML = "";

    const classList = response.result;

    console.log(classList);

    // 값이 있을 경우에만 화면에 뿌려주기
    if (classList.length != 0) {

        for (let i = 0; i < classList.length; i++) {
            //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done)
            const status = classList[i].class_register_status;
            const classDate = classList[i].schedule_list;
            const className = classList[i].class_name;
            const classTime = classList[i].class_time;
            const teacherImage = classList[i].user_img;
            const classId = classList[i].class_register_id;
            const userName = classList[i].user_name;
            const price = classList[i].class_price;

            // 수업일 int로 변환
            const dateToint = parseInt(classDate);

            // 수업시간 int로 변환
            const timeToint = parseInt(classTime);

            // 수업일에서 수업시간 빼기
            const date = dayjs(dateToint).subtract(timeToint, "m");

            // 요일 파싱
            const day = week[date.day()];            
            
            // 월,일, 시 파싱            
            const date_format = date.format('YYYY년 MM월 DD일 ('+day+') hh:mm');

            // 이미지 경로
            const teacherImgeLink = s3_url + "Profile_Image/" + teacherImage;

            // a 태그 생성
            const a = document.createElement("a");
            // 속성 값에 해당 수업의 id 대입
            a.setAttribute("id", classId);
            a.setAttribute("class", "my-1")
            a.innerHTML = `<div class = "classList flex flex-col w-full px-2 ">                            
                            <div class = "flex w-full bg-gray-50 border-b-2 border-l-2 border-r-2 hover:bg-gray-200 py-1">
                                <div class = "flex items-center w-1/5 pl-2">
                                    <img id = "profile_image" class = "w-8 h-8 border-3 border-gray-900 rounded-full mr-1" 
                                        src = `+teacherImgeLink+`>
                                    </img>
                                    <span class = "studentName text-xs text-gray-800">`+userName+`</span>
                                </div>
                                <div class = "flex flex-col w-3/5">
                                    <span class = "className text-sm">`+className+`</span>
                                    <span class = "classStartDate text-xs text-gray-600">`+date_format+`</span>
                                </div>
                                <div class = "flex flex-col w-1/5">
                                    <span class = "classStatus text-sm text-gray-400">`+statusChange(status, $('.classStatus'))+`</span>
                                    <span class = "text-sm text-gray-500">$ <span class = "classPrice">`+price+`</span> USD</span>
                                </div>                    
                            </div>                
                          </div>`;

            $container.appendChild(a) // 없으면 수업이 없다는 뷰 뿌려주기;
        }

    } else {}
}

// 수업 상태에 따라 텍스트 변경하는 함수
const statusChange = (status, $classStyle) => {

    if (status == "0") {
        status = "승인 대기"
    } else if (status == "1") {
        status = "미완료"
    } else if (status == "2") {
        status = "취소됨"
    } else if (status == "3") {
        status = "완료됨"
        $classStyle.setAttribute("class", "text-sm text-gray-400");
    }
    return status;
}



export default classhistorylist;