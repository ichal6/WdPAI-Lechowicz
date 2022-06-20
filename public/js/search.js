const search = document.querySelector('input[placeholder="Type here for search"]');
const listContainer = document.getElementById("list-body");

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

    const labelList = clone.querySelector('.label-list');
    labelList.innerText = 'Type: ' + list.type_name +
        ' | Category: ' + list.category + ' | Owner: ' + list.owner + ' | Priorytet: ' + list.priority;
    // const image = clone.querySelector("img");
    // image.src = `/public/uploads/${list.image}`;
    // const title = clone.querySelector("h2");
    // title.innerHTML = list.title;
    // const description = clone.querySelector("p");
    // description.innerHTML = list.description;
    // const like = clone.querySelector(".fa-heart");
    // like.innerText = list.like;
    // const dislike = clone.querySelector(".fa-minus-square");
    // dislike.innerText = list.dislike;

    listContainer.appendChild(clone);
}

const expandListButton = document.querySelector('.title-list-btn');
const productsContainer = document.getElementsByClassName('list-content');

console.log(expandListButton);

expandListButton.addEventListener("onclick", function (event) {
    event.preventDefault();

    const data = {list: this.value};

    console.log(data);

    fetch("/list", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (lists) {
        productsContainer.innerHTML = "";
        // loadLists(lists)
    });
});

