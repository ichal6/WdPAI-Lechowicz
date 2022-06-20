function displayList(id){
    const targetDiv = document.getElementById(id);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
    } else {
        showProduct(id);
        targetDiv.style.display = "block";
    }
}

function showProduct(id_list){
    id_list = id_list.slice(5);
    const data = {list: id_list};

    console.log(data);
    console.log('test');

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
        loadProducts(lists);
    });
}

function loadProducts(lists){
    lists.forEach(list => {
        console.log(list);
        createProduct(list);
    });
}

function createProduct(product) {
    const productsContainer = document.querySelector('.list-content');
    const template = document.querySelector("#product-template");
    const clone = template.content.cloneNode(true);

    const productName = clone.querySelector('.product-name');
    productName.innerText = product.name;

    const price = clone.querySelector('.price');
    price.innerText = product.price;

    productsContainer.appendChild(clone);
}


