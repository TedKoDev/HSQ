export function notfound($container) {
    this.$container = $container;    
  
    this.setState = () => {
      this.render();
    };
  
    this.render = () => {
      
      console.log("notfound");
    //   console.log(responseCanceled);

    //   showClassList($container, responseCanceled);

    //   changeSelectBtnStyle($("#canceledCl"))
    };
  
    this.render();
}

export default notfound;