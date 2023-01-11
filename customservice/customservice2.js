const boardElements = document.querySelectorAll(".board");

boardElements.forEach((board) => {
  board.addEventListener("click", (event) => {
    // Get the board's identifier
    const boardId = event.currentTarget.dataset.boardId;

    // Navigate to the detail page and pass the board's identifier as a query parameter
    window.location.href = `/detail?id=${boardId}`;
  });
});
