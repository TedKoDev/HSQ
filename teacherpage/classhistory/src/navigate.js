/**
 * @param  { string } to
 * @param  { boolean } isReplace
 */
export const navigate = (to, isReplace = false) => {
    
    const historyChangeEvent = new CustomEvent("classtypeChange", {
            
      detail: {
        to,
        isReplace,
      },
    });
  
    dispatchEvent(historyChangeEvent);
  };