const addStar_span = document.querySelector('.addStar_modal');
const addStar_value = document.querySelector('.addStar_modal_value');

const drawStar = (target) => {
    addStar_span.style.width = `${target.value * 10}%`;

    // console.log(addStar_value.value);
  }