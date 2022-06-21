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

    fetch("/list", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (products) {
        loadProducts(products, id_list);
    });
}

function loadProducts(products, id_list){
    products.forEach(product => {
        console.log(product);
        createProduct(product, id_list);
    });
}

function createProduct(product, id_list) {
    const template = document.querySelector("#product-template");
    const clone = template.content.cloneNode(true);
    const productsContainer = document.getElementById('list-' + id_list);

    const productName = clone.querySelector('.product-name');
    productName.innerText = product.name;

    const price = clone.querySelector('.price');
    price.innerText = product.price;

    productsContainer.appendChild(clone);
}


