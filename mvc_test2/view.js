class TodoView {
    constructor(model) {
        this.model = model;
    }

    
    findElementByName(name) {
        return document.getElementsByName(name)[0];
    }

    findElementByTagName(name) {
        return document.getElementsByTagName(name)[0];
    }

    findElementByClassName(name) {
        return document.getElementsByClassName(name)[0];
    }

    createListItemNode() {
        const listItemNode = document.createElement("li");
        const textNode = document.createTextNode(this.model.getCurrentInputTodoData());
        listItemNode.appendChild(textNode);

        return listItemNode;
    }

    controlTodoListHidden(mode) {
        const todoListRegisterationBtn = this.findElementByClassName("register");
        const todoListParentNode = this.findElementByClassName("todolist");

        todoListRegisterationBtn.disabled = (mode === "fold") ? true : false;
        todoListParentNode.hidden = (mode === "fold") ? true : false;
    }

    registerTask(parentNode, childNode) {
        parentNode.appendChild(childNode);
    }
}