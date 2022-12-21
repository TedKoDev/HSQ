class TodoModel {

    constructor() {
        this.currentInputTodoData;
        this.todoList = [];
    }

    getCurrentInputTodoData() {
        return this.currentInputTodoData;
    }

    setCurrentInputTodoData(data) {
        this.currentInputTodoData = data;
    }

    getTodoList() {
        return this.todoList;
    }

    pushTodoListData() {
        this.todoList.push(this.currentInputTodoData);
    }
}