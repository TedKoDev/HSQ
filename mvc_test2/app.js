window.addEventListener('DOMContentLoaded', function() {
    console.log("success window onload");
    const model = new TodoModel();
    const view = new TodoView(model);
    const controller = new TodoController(model, view);

});