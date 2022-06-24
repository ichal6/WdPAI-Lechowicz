const search = document.querySelector('input[placeholder="Type here for search"]');
const listContainer = document.getElementById("list-body");
const prioritiesSelect = document.getElementsByName('priorities')[0];
const categoriesSelect = document.getElementsByName('categories')[0];
const typesSelect = document.getElementsByName('types')[0];

function displayAddForm(id){
    const targetDiv = document.getElementById(id);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
    } else {
        targetDiv.style.display = "block";
    }
}

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
    labelList.innerText = 'Type: ' + list.type_name +
        ' | Category: ' + list.category + ' | Owner: ' + list.owner + ' | Priorytet: ' + list.priority;

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
    document.getElementById('add-form-list-id').style.display = 'none';

    addProductToList.addEventListener("click", function (event) {
        displayAddForm('add-product');
        const listId = document.getElementById('add-form-list-id');
        listId.value = list.id;
    });
    // addProductToList.addEventListener("click", function (event) {
    //     event.preventDefault();
    //     const id_list = this.id.slice(20);
    //
    //     const data = {list_id: id_list};
    //
    //     console.log(data);
    //
    //     fetch("/add_product_to_list", {
    //         method: "POST",
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify(data)
    //     }).then(function (response) {
    //         return response.json();
    //     }).then(function () {
    //         firstLoadLists();
    //     });
    // });

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
