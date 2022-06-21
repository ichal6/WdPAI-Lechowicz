function displayList(id){
    const targetDiv = document.getElementById(id);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
    } else {
        showProduct(id);
        targetDiv.style.display = "block";
    }
}

function displayMoreContent(contentId, buttonId){
    const targetDiv = document.getElementById(contentId);
    const button = document.getElementById(buttonId);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
        button.style.display = 'block';
    } else {
        targetDiv.style.display = "block";
        button.style.display = 'none';
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

    const status = clone.querySelector('.status');
    status.innerText = 'Status: ' + product.status_name;

    const quantity = clone.querySelector('.quantity');
    quantity.innerText = 'Quantity for buy: ' + product.quantity;

    const moreContent = clone.querySelector('.more-content');
    moreContent.id = 'product-' + product.id;
    moreContent.style.display = 'none';

    const moreButton = clone.querySelector('.more');
    moreButton.id = 'button-product-more-' + product.id;
    moreButton.addEventListener('click', () => displayMoreContent(moreContent.id, moreButton.id));

    const lessButton = clone.querySelector('.less');
    lessButton.id = 'button-product-less-' + product.id;
    lessButton.addEventListener('click', () => displayMoreContent(moreContent.id, moreButton.id));

    productsContainer.appendChild(clone);
}


