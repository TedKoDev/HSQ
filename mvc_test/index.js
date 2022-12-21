
// model
var Data =(function() {
    
    var list = [];
    
    var Item = function(content) {
        this.content = content;
    };
    Item.prototype.finished = false;
    
    var addItem = function(content) {
        var item = new Item(content);
        list.push(item);
    }
    
    var removeItem = function(item_index) {
        list.splice(item_index, 1);
    }
    
    var checkItem = function(item_index) {
        var current_item = list[item_index];
        current_item.finished = !current_item.finished;
    }
    
    return {
        list: list,
        Item: Item,
        addItem: addItem,
        removeItem: removeItem,
        checkItem: checkItem
    };
})();

//controller
var Controller = (function(){
    
    var addItem = function(e) {

        console.log("addItem");

        e.preventDefault();

        var add_value = add_input.value;

        Data.addItem(add_value);

        UI.showList(Data.list);

        form.reset();
    };
    
    var searchItem = function() {

        console.log("searchItem");
        

        var search_value = search_input.value;

        var filter_list = Data.list.filter(function(item) {
            return item.content.indexOf(search_value) > -1;
        }); 
        
        UI.showList(filter_list);
    }

    var removeItem = function(e) {

        console.log("removeItem");

        if(e.target.tagName !== 'I') return;

        var item_id = e.target.parentNode.parentNode.id;
        var item_index = item_id.split('-')[1];

        Data.removeItem(item_index);

        UI.showList(Data.list);
    }

    var checkItem = function(e) {

        console.log("checkItem");
        
        if(e.target.tagName !== 'INPUT') return;

        var item_id = e.target.parentNode.parentNode.id;
        var item_index = item_id.split('-')[1];
        
        Data.checkItem(item_index);

        UI.showList(Data.list);
    }

    var form = document.forms['list-form'];
    var add_input = form['add-item__input'];
    var search_input = form['search-item__input'];
    
    var section = document.querySelector('section');
    
    form.addEventListener('submit', addItem);
    
    search_input.addEventListener('input', searchItem);

    section.addEventListener('click', removeItem);
    section.addEventListener('change', checkItem);
})();

// view
var UI = (function(){

    var to_do_list = document.querySelector('.to-do-list');
    var finished_list = document.querySelector('.finished-list');

    var showList = function(list) {

        finished_list.innerHTML = '';
        to_do_list.innerHTML = '';

        list.forEach(function(item, i) {

            if(!item.finished) {
                var to_do_item_HTML = 
                        '<li class="to-do-list__item" id="item-'+ i +'">' +
                            '<div class="item__content">'+item.content+'</div>' +
                            '<div class="item__action">' +
                                '<i class="fa fa-trash" aria-hidden="true"></i>' +
                                '<input type="checkbox">' +
                            '</div>' +
                        '</li>';
                to_do_list.insertAdjacentHTML('afterbegin', to_do_item_HTML);
            }else {
                var finished_item_HTML = 
                        '<li class="to-do-list__item" id="item-'+ i +'">' +
                            '<div class="item__content">'+item.content+'</div>' +
                            '<div class="item__action">' +
                                '<i class="fa fa-trash" aria-hidden="true"></i>' +
                                '<input type="checkbox" checked>' +
                            '</div>' +
                        '</li>';
                finished_list.insertAdjacentHTML('afterbegin', finished_item_HTML);
            }
        });
    }
    
    return {
        showList: showList
    };
})();