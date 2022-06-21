const search = document.querySelector('input[placeholder="Type here for search"]');
const listContainer = document.getElementById("list-body");
const prioritiesSelect = document.getElementsByName('priorities')[0];
const categoriesSelect = document.getElementsByName('categories')[0];
const typesSelect = document.getElementsByName('types')[0];

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

categoriesSelect.addEventListener("keyup", function (event) {
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


typesSelect.addEventListener("keyup", function (event) {
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
