import { $, $_all } from "/utils/querySelector.js";
import { responseAll, responseApproved, responseNotapproved, responseDone, responseCanceled } from "../myclasses.js";
import { s3_url } from "../../commenJS/cookie_modules.js";


// 담을 json 목록
// let responseAll;
// let responseApproved;
// let responseNotapproved;
// let responseDone;
// let responseCanceled;

export function all($container) {
    this.$container = $container;    
        
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
           
      showClassList($container, responseAll);

      changeSelectBtnStyle($("#allCl"))

      
    };
  
    this.render();    
}

export function notapproved($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
     
      
      console.log(responseNotapproved);

      showClassList($container, responseNotapproved);

      changeSelectBtnStyle($("#notApprovedCl"))
    };
  
    this.render();
}

export function approved($container) {
    this.$container = $container;
   
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
      

      console.log(responseApproved);

      showClassList($container, responseApproved);

      changeSelectBtnStyle($("#approvedCl"))
    };
  
    this.render();
}

export function done($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
      

      console.log(responseDone);

      showClassList($container, responseDone);
      
      changeSelectBtnStyle($("#doneCl"))
    };
  
    this.render();
}

export function canceled($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
      

      console.log(responseCanceled);

      showClassList($container, responseCanceled);

      changeSelectBtnStyle($("#canceledCl"))
    };
  
    this.render();
}

export async function notfound($container) {
    this.$container = $container;
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
      this.$container.innerHTML = `
        <main class="mainPage">
          notfound
        </main>
      `;
     
    };
  
    this.render();
}

// 클릭한 타입의 텍스트 굵게 하고 하단에 색깔 칠하기
const changeSelectBtnStyle = (target) => {

  const classType = $_all(".classType");
  for (let i = 0; i < classType.length; i++) {
    classType[i].setAttribute("class", "classType mx-2 py-5 font-normal text-sm border-0");
  }
  target.setAttribute("class", "classType mx-2 py-5 font-semibold text-sm border-b-4 border-blue-400 text-gray-800")
};


// 담아온 수업 리스트 json 파싱해서 화면에 표시
const showClassList = ($container, response) => {

  $container.innerHTML = "";
  
  const classList = response.result; 

  // 값이 있을 경우에만 화면에 뿌려주기
  if (classList.length != 0) {

    for (let i = 0; i < classList.length; i++) {
      //예약한 수업의 응답 상태  0(신청후 대기중 wait),1(승인 approved),2(취소 cancel),3(완료 done)
      const status = classList[i].class_register_status;
      const classDate = classList[i].class_start_time;
      const className = classList[i].class_name;
      const classTime = " - "+classList[i].class_time+"분";
      const teacherImage = classList[i].user_img;
      const classId = classList[i].class_register_id;

      // 수업시간 int로 변환
      const string_to_int = parseInt(classDate);

      // 수업 시간만큼 빼고 월,일, 시 파싱
      const classStartTime = dayjs(string_to_int).subtract(parseInt(classList[i].class_time), 'minute');      
      const month = classStartTime.format('MM월');
      const date = classStartTime.format('DD');
      const hourAndMin = classStartTime.format('hh:mm');


      // 이미지 경로 
      const teacherImgeLink = s3_url+"Profile_Image/"+teacherImage;
      
      console.log(teacherImage);
      // a 태그 생성
      const a = document.createElement("a");
      // 속성 값에 해당 수업의 id 대입
      a.setAttribute("id", classId);
      a.setAttribute("class", "my-1")
      a.innerHTML = `<div class = "flex w-full bg-gray-50 rounded-lg shadow border border-gray-200 py-2 hover:shadow">
                        <div class = "flex flex-col w-1/5 text-center">
                            <span class = "text-xs text-gray-500">`+statusChange(status)+`</span><span class = "text-lg font-semibold">`+date+`</span><span class = "text-xs text-gray-700">`+month+`</span>
                        </div>
                        <div class = "flex justify-between items-center w-4/5 relative pr-4 group">
                            <div class = "flex flex-col">
                                <span  class = "text-lg font-semibold">`+hourAndMin+`</span><span  class = "text-xs text-gray-500">`+className+`<a>`+classTime+`</a></span>
                            </div>
                            <div class = "group-hover:hidden">
                                <img id = "profile_image" class = "mx-auto w-10 h-10 border-3 border-gray-900 rounded-full"
                                    src = `+teacherImgeLink+`>
                                </img>
                            </div>                
                            <div class = "absolute right-4">
                                <button class = "bg-blue-600 rounded-lg text-white px-3 py-1 hidden group-hover:block">수업 후기</button>
                            </div>                                        
                        </div>
                      </div>`;

      $container.appendChild(a);
    }

  }
  // 없으면 수업이 없다는 뷰 뿌려주기
  else {

  }
}

const statusChange = (status) => {

  if (status == "0") {
    status = "승인 대기"    
  }
  else if (status == "1") {
    status = "미완료"
  }
  else if (status == "2") {
    status = "취소됨"
  }
  else if (status == "3") {
    status = "완료됨"
  }
  return status;
}