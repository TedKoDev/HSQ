import { $, $_all } from "/utils/querySelector.js";
import { cookieName, getCookie } from "/commenJS/cookie_modules.js";
import { responseAll, responseApproved, responseNotapproved, responseDone, responseCanceled } from "../myclasses.js";

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
      this.$container.innerHTML = `
        <main class="mainPage">
          모든 수업
        </main>
      `;

      console.log(responseAll);

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
      this.$container.innerHTML = `
        <main class="mainPage">
          예약되지 않은 수업
        </main>
      `;      
      
      console.log(responseNotapproved);

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
      this.$container.innerHTML = `
        <main class="mainPage">
          대기중인 수업
        </main>
      `;

      console.log(responseApproved);

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
      this.$container.innerHTML = `
        <main class="mainPage">
          완료된 수업
        </main>
      `;

      console.log(responseDone);
      
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
      this.$container.innerHTML = `
        <main class="mainPage">
          취소된 수업
        </main>
      `;

      console.log(responseCanceled);

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