const search = document.querySelector('input[placeholder="Type here for search"]');
const listContainer = document.getElementById("list-body");
const prioritiesSelect = document.getElementsByName('priorities')[0];
const categoriesSelect = document.getElementsByName('categories')[0];
const typesSelect = document.getElementsByName('types')[0];
const disableButton = document.getElementById('disable-add-product');

function displayAddForm(id){
    const targetDiv = document.getElementById(id);
    targetDiv.style.display = "block";
}

disableButton.addEventListener('click', function (event) {
    displayAddForm('add-product-to-list-form')
});

prioritiesSelect.addEventListener("change", function (event) {
    event.preventDefault();

    if(this.value === 'all'){
        firstLoadLists();
        return;
    }

    const data = {priority_id: this.value};

    console.log(data);

    fetch("/filter_priority", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (lists) {
        listContainer.innerHTML = "";
        loadLists(lists)
    });
});

categoriesSelect.addEventListener("change", function (event) {
    event.preventDefault();

    if(this.value === 'all'){
        firstLoadLists();
        return;
    }

    const data = {category_id: this.value};

    console.log(data);

    fetch("/filter_category", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (lists) {
        listContainer.innerHTML = "";
        loadLists(lists)
    });
});

typesSelect.addEventListener("change", function (event) {
    event.preventDefault();

    if(this.value === 'all'){
        firstLoadLists();
        return;
    }

    const data = {type_id: this.value};

    console.log(data);

    fetch("/filter_type", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (lists) {
        listContainer.innerHTML = "";
        loadLists(lists)
    });
});

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        console.log(data);

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (lists) {
            listContainer.innerHTML = "";
            loadLists(lists)
        });
    }
});

function loadLists(lists) {
    lists.forEach(list => {
        console.log(list);
        createList(list);
    });
}

function createList(list) {
    const template = document.querySelector("#list-template");
    const clone = template.content.cloneNode(true);
    const hideButton = clone.querySelector('input');
    hideButton.value = list.title;
    hideButton.addEventListener('click', () => displayList('list-'+list.id));

    const div = clone.querySelector('.list-content');
    div.id = 'list-'+list.id;
    div.style.display = 'none';

    const labelList = clone.querySelector('.label-list');
    let label = 'Type: ' + list.type_name;
    if(list.category !== null){
        label += ' | Category: ' + list.category;
    }
    label += ' | Owner: ' + list.owner;
    if(list.priority !== null){
        label += ' | Priorytet: ' + list.priority;
    }
    labelList.innerText = label;
    labelList.id = 'label-list-' + list.id;

    const modifyList = clone.querySelector('.modify-list');
    modifyList.id = 'modify-list-' + list.id;

    const removeList = clone.querySelector('.remove-list');
    removeList.id = 'remove-list-' + list.id;

    removeList.addEventListener("click", function (event) {
        event.preventDefault();
        const id_list = this.id.slice(12);

        const data = {list_id: id_list};

        console.log(data);

        fetch("/remove_list", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function () {
            firstLoadLists();
        });
    });

    const editList = clone.querySelector('.edit-list');
    editList.id = 'edit-list-' + list.id;

    const shareList = clone.querySelector('.share-list');
    shareList.id = 'share-list-' + list.id;

    const addProductToList = clone.querySelector('.add-product-to-list');
    addProductToList.id = 'add-product-to-list-' + list.id;
    document.getElementById('add-product-to-list-form').style.display = 'none';

    addProductToList.addEventListener("click", function (event) {
        const listId = document.getElementById('add-form-list-id');
        listId.value = list.id;
        hideAddNewList();
        displayAddForm('add-product-to-list-form');
    });
    const disableButton = document.getElementById('disable-add-product');
    disableButton.addEventListener('click', function (event) {
        displayAddForm('add-product-to-list-form');
    });

    listContainer.appendChild(clone);
}

function firstLoadLists(){
    const data = {search: ''};

    fetch("/search", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (lists) {
        listContainer.innerHTML = "";
        loadLists(lists)
    });
}

firstLoadLists();
