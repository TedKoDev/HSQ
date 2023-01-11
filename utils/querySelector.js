export const $ = (selector) => {
    const result = document.querySelector(selector);
    if (!(result instanceof HTMLElement)) return null;
  
    return result;
  }

export const $_all = (selector) => {
    const result = document.querySelectorAll(selector);    
    return result;
}