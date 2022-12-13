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