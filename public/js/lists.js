function displayList(id){
    const targetDiv = document.getElementById(id);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
    } else {
        showProduct(id);
        const labelList = document.getElementById('label-' + id);
        labelList.style.borderRadius = '0';
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
    const productsContainer = document.getElementById('list-' + id_list).cloneNode(true);
    const modifyList = document.getElementById('modify-list-'+id_list);

    productsContainer.innerHTML = '';
    products.forEach(product => {
        console.log(product);
        createProduct(product, id_list);
    });
    productsContainer.innerHTML = productsContainer.innerHTML + modifyList
}

function createProduct(product, id_list) {
    const template = document.querySelector("#product-template");
    const clone = template.content.cloneNode(true);
    const productsContainer = document.getElementById('list-' + id_list);

    const productName = clone.querySelector('.product-name');
    productName.innerText = product.name;

    if(product.price){
        const price = clone.querySelector('.price');
        price.innerText = product.price + " " + product.currency;
    } else{
        const lastPrice = clone.querySelector('.last-price');
        lastPrice.innerText = '';
    }



    const status = clone.querySelector('.status');
    status.innerText = 'Status: ' + product.status_name;

    const quantity = clone.querySelector('.quantity');
    quantity.innerText = 'Quantity for buy: ' + product.quantity + " " + product.unit_name;

    const category = clone.querySelector('.category');
    category.innerText = 'Category: ' + product.category;

    const available = clone.querySelector('.available');
    available.innerText = 'Available on market: ' + product.available;

    const priority = clone.querySelector('.priority');
    priority.innerText = 'Priority: ' + product.priority;

    const location = clone.querySelector('.location');
    location.innerText = 'Location: ' + product.location;


    const moreContent = clone.querySelector('.more-content');
    moreContent.id = 'product-' + product.id;
    moreContent.style.display = 'none';

    const moreButton = clone.querySelector('.more');
    moreButton.id = 'button-product-more-' + product.id;
    moreButton.addEventListener('click', () => displayMoreContent(moreContent.id, moreButton.id));

    const lessButton = clone.querySelector('.less');
    lessButton.id = 'button-product-less-' + product.id;
    lessButton.addEventListener('click', () => displayMoreContent(moreContent.id, moreButton.id));

    const removeButton = clone.querySelector('.remove');
    removeButton.id = 'button-product-remove-' + product.id;
    removeButton.addEventListener("click", function (event) {
        event.preventDefault();
        const id_product = this.id.slice(22);

        const data = {id: id_product};

        console.log(data);

        fetch("/remove_product", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (lists) {
            firstLoadLists();
        });
    });

    const boughtButton = clone.querySelector('.bought');
    boughtButton.id = 'button-product-bought-' + product.id;
    boughtButton.addEventListener("click", function (event) {
        event.preventDefault();
        const id_product = this.id.slice(22);

        const data = {id: id_product};

        console.log(data);

        fetch("/bought_product", {
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

    productsContainer.appendChild(clone);
}


