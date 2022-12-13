import { $, $_all } from "/utils/querySelector.js";

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

      changeSelectBtnStyle($("#canceledCl"))
    };
  
    this.render();
}

export function notfound($container) {
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

const changeSelectBtnStyle = (target) => {

  const classType = $_all(".classType");
  for (let i = 0; i < classType.length; i++) {
    classType[i].setAttribute("class", "classType mx-2 py-5 font-normal text-sm border-0");
  }
  target.setAttribute("class", "classType mx-2 py-5 font-semibold text-sm border-b-4 border-blue-400 text-gray-800")
};