class TodoController {

    constructor(model, view) {
        this.model = model;
        this.view = view;

        this.registerEventListener(model, view);
    }

    /*
        EVENT LISTENER 을 등록합니다.
    */
    registerEventListener(model, view) {
        const registerationBtn = view.findElementByClassName("register");
        const todoListfoldingBtn = view.findElementByClassName("fold");
        const todoListUnfoldingBtn = view.findElementByClassName("unfold");

        registerationBtn.addEventListener("click", () => {
            this.addTodoListData(model, view);
        });

        todoListfoldingBtn.addEventListener("click", () => {
            view.controlTodoListHidden("fold");
        });

        todoListUnfoldingBtn.addEventListener("click", () => {
            view.controlTodoListHidden("unfold");
        });
    }

    /*
        BUTTON EVENT
        할일을 추가하는 이벤트를 담당합니다.
    */
    addTodoListData(model, view) {
        const currentInputData = view.findElementByName("todo").value;
        model.setCurrentInputTodoData(currentInputData);
        const todoItemNode = view.createListItemNode();
        const todoListParentNode = view.findElementByClassName("todolist");
        view.registerTask(todoListParentNode, todoItemNode);
        model.pushTodoListData();
    }
}