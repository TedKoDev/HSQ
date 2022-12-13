/**
 * @param  { string } to
 * @param  { boolean } isReplace
 */
export const navigate = (to, isReplace = false) => {

  console.log("shop_test4 : "+shop_test);
    const historyChangeEvent = new CustomEvent("historychange", {
      detail: {
        to,
        isReplace,
      },
    });
  
    dispatchEvent(historyChangeEvent);
  };