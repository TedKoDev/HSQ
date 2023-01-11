import { cookieName, getCookie, s3_url } from "/commenJS/cookie_modules.js";
import {changeSelectBtnStyle, getFilterInit} from "./pages.js";
import {$, $_all} from "/utils/querySelector.js";
// import {classList_json} from "../../classhistory.js";
import { paging } from "./feedbacklist.js";

export function classhistorylist($container) {
    this.$container = $container;

    this.setState = () => {
        this.render();
    };

    this.render = () => {        
        
        changeSelectBtnStyle($('#classList'), $_all(".historyType"));
        

        // 수업 목록 이외의 부분 표시 (ex : 필터 관련된 input이랑 검색 버튼)
        // getFilterblock($('.filter'));
        $('.filter').classList.remove('hidden');
        // 수업 목록 표시
        showClassList($container);      

    };

    this.render();
}


let week = new Array('일', '월', '화', '수', '목', '금', '토');
// 담아온 수업 리스트 json 파싱해서 화면에 표시
async function showClassList($container) {

    $container.innerHTML = "";
    $container.setAttribute("class", "");

    const classList = await getClasslist();
    const result = classList.result;       
    
    // 값이 있을 경우에만 화면에 뿌려주기
    if (result.length != 0) {

        let totalLength = classList.length;

        console.log(totalLength);   
       
        for (let i = 0; i < result.length; i++) {
            //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done)
            const status = result[i].class_register_status;
            const classDate = result[i].schedule_list;
            const className = result[i].class_name;
            const classTime = result[i].class_time;
            const teacherImage = result[i].user_img;
            const classId = result[i].class_register_id;
            const userName = result[i].user_name;
            const price = result[i].class_price;
            const userId = result[i].user_id;
            

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

            $container.appendChild(a) 

            // 수업 목록 클릭했을 때 수업 상세로 이동할 수 있는 리스너            
            a.addEventListener('click', () => {

                goClassDetail(classId, userId, '/teacherpage/classhistory/historydetail/');
            })
            
        }
        
        // 페이징 뷰 표시하는 로직
        const pagingDiv = document.createElement("div");  
        pagingDiv.setAttribute("class", "flex mt-5");      
        pagingDiv.innerHTML = ` <div class = "pagination mx-auto flex items-center">
                                    <span class = "prevBtn" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/></svg>
                                    </span>
                                    <ol id = "numbers">
                                        
                                    </ol>
                                    <span class = "nextBtn" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg>
                                    </span>
                                </div>`;
            
        $container.appendChild(pagingDiv);

        setpageNumber(totalLength);
    } 
    // 없으면 수업이 없다는 뷰 뿌려주기;
    else {

    }
}

// 수업 목록 가져오기
async function getClasslist() {
    
    const classType = $('.classType');
    const className = $('.className');
    const userName = $('.userName');
    const classStart = $('.classStart');
    const classEnd = $('.classEnd');

    if (page_classList == null) {
        page_classList = 0;
      }
    let filterObject = {

        token: getCookie(cookieName),
        kind: "tclist",
        class_reserve_check: "all", 
        plus: page_classList,  
    };
    
    if (key_class_type != "") {
    filterObject.filter_class_status_check = key_class_type;    
    classType.value = key_class_type;
    }
    if (key_user_name != "") {
        filterObject.filter_user_name = key_user_name;    
        userName.value = key_user_name;
        console.log(className);
    }
    if (key_class_name != "") {
        filterObject.filter_class_name = key_class_name;
        className.value = key_class_name;
    }
    if (key_time_from != "") {

       filterObject.filter_class_resister_time_from = dayjs(key_time_from).valueOf();
       classStart.value = key_time_from;
    }
    
    if (key_time_to != "") {
        filterObject.filter_class_resister_time_to = dayjs(key_time_to).valueOf();
        classEnd.value = key_time_to;
    }

    console.log(filterObject);

    const res = await fetch('/restapi/classinfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(filterObject)
    });    
    
    const classList_json = await res.json();    
    
    console.log(classList_json);

    return classList_json;
}



// 수업 상세 화면으로 이동
export function goClassDetail(class_id, user_id, url) {
        
    const form = document.createElement('form');
    form.setAttribute('method', 'get');    
    form.setAttribute('action', url);

    const hiddenField_class = document.createElement('input');
    hiddenField_class.setAttribute('type', 'hidden');
    hiddenField_class.setAttribute('name', 'class_id');
    hiddenField_class.setAttribute('value', class_id);
    const hiddenField_user = document.createElement('input');
    hiddenField_user.setAttribute('type', 'hidden');
    hiddenField_user.setAttribute('name', 'user_id');
    hiddenField_user.setAttribute('value', user_id);

    form.appendChild(hiddenField_class);
    form.appendChild(hiddenField_user);

    document.body.appendChild(form);

    form.submit();      
    
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
    }
    return status;
}



function setpageNumber(totalLength) {
    
    const rows = $_all('.classList');
          
    const pageCount = Math.ceil(totalLength/20);
    const numbers = $('#numbers');

    const prevPageBtn = $('.prevBtn');
    const nextPageBtn = $('.nextBtn');    
    let maxPageNum = 10; // 페이지 그룹 최대 갯수    
    
    // console.log(pageCount);
    for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement("li");
        li.setAttribute("class", "float-left");     
               
        if ((i-1) == page_classList) {
            li.innerHTML = `<li ><a id = ${i-1}_page class = " bg-gray-500 mx-1 px-2">${i}</a></li>`;        
        }
        else {
            li.innerHTML = `<li ><a id = ${i-1}_page class = " mx-1 px-2">${i}</a></li>`;
        }

        numbers.appendChild(li);        
    } 

    const numberBtn = numbers.querySelectorAll('a');

    // 모든 페이지네이션 번호 감추기
    for (const nb of numberBtn) {
    nb.style.display = 'none';
    }
    
    numberBtn.forEach((item, idx) => {
        item.addEventListener('click', (e) => {            

            page_classList = e.target.id.replace("_page", "");
            paging('page', page_classList, '/teacherpage/classhistory/classlist/');           
        })
    })

    nextPageBtn.addEventListener('click', () => {
        
        page_classList = page_classList + 1;
        paging('page', page_classList, '/teacherpage/classhistory/classlist/');
    })

    prevPageBtn.addEventListener('click', () => {        
        
        page_classList = page_classList + 1;
        paging('page', page_classList, '/teacherpage/classhistory/classlist/');
    })

    displayPage(0, pageCount, maxPageNum, numberBtn, prevPageBtn, nextPageBtn, totalLength);
}

// 페이지 그룹 표시 함수
function displayPage(num, pageCount, maxPageNum, numberBtn, prevPageBtn, nextPageBtn, totalLength) {

     // 모든 페이지네이션 번호 감추기
     for (const nb of numberBtn) {
        nb.style.display = 'none';
    }        

    let pageArr = [...numberBtn];
    let start = num*maxPageNum;
    let end = start+maxPageNum;
    let pageListArr = pageArr.slice(start, end);

    for (let item of pageListArr) {
        item.style.display = 'block';
    }        

    // 이전 버튼 안보이게
    if (page_classList == 0) {
        prevPageBtn.style.display = 'none';
    }
    else {
        prevPageBtn.style.display = 'block';
    }    

    // 다음 버튼 안보이게     
    if ((parseInt(totalLength / 20) == parseInt(page_classList))) {
        nextPageBtn.style.display = 'none';
    }
    else if ((parseInt(totalLength / 20) == (parseInt(page_classList)+1)) && (parseInt(totalLength) % 20 == 0)) {
        nextPageBtn.style.display = 'none';
    }
    else {
        nextPageBtn.style.display = 'block';
    }
}




export default classhistorylist;