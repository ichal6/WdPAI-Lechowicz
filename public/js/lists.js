const tabletSize = 1050;
const mobileSize = 700;
const desktopSize = 1550;

function displayFilter(){
    const listDiv = document.getElementById('select-filter');
    const moreFilterIcon = document.getElementById('more-filter-icon');
    if(listDiv.style.display !== "none"){
        listDiv.style.display = "none";
        moreFilterIcon.style.transform = 'rotate(180deg)';
    } else{
        listDiv.style.display = "flex";
        moreFilterIcon.style.transform = 'rotate(0deg)';
    }
}

const moreFilterBtn = document.getElementById('show-more-filter');
const listDiv = document.getElementById('select-filter');
listDiv.style.display = "none";
moreFilterBtn.addEventListener('click', function (event){
    displayFilter();
} );

document.getElementById('select-types').addEventListener('click', function (event){
    if(window.innerWidth >= mobileSize){
        const prioritiesFilter = document.getElementById('priorities-filter');
        prioritiesFilter.style.display = 'block';
    } else{
        const prioritiesFilter = document.getElementById('priorities-filter');
        prioritiesFilter.style.display = 'none';
    }

    const categoriesFilter = document.getElementById('categories-filter');
    categoriesFilter.style.display = 'none';

    const typesFilter = document.getElementById('types-filter');
    typesFilter.style.display = 'block';
});

document.getElementById('select-categories').addEventListener('click', function (event){
    if(window.innerWidth >= mobileSize){
        const prioritiesFilter = document.getElementById('priorities-filter');
        prioritiesFilter.style.display = 'block';
    } else{
        const prioritiesFilter = document.getElementById('priorities-filter');
        prioritiesFilter.style.display = 'none';
    }

    const categoriesFilter = document.getElementById('categories-filter');
    categoriesFilter.style.display = 'block';

    const typesFilter = document.getElementById('types-filter');
    typesFilter.style.display = 'none';
});


document.getElementById('select-priorities').addEventListener('click', function (event){
    const prioritiesFilter = document.getElementById('priorities-filter');
    prioritiesFilter.style.display = 'block';

    if(window.innerWidth >= mobileSize){
        const categoriesFilter = document.getElementById('categories-filter');
        categoriesFilter.style.display = 'block';
    } else{
        const categoriesFilter = document.getElementById('categories-filter');
        categoriesFilter.style.display = 'none';
    }

    const typesFilter = document.getElementById('types-filter');
    typesFilter.style.display = 'none';
});

document.getElementById('show-add-list').addEventListener('click', function (event){
    const addListForm = document.getElementById('create-list');
    addListForm.style.display = 'block';
});

function displayList(id){
    const targetDiv = document.getElementById(id);
    const labelList = document.getElementById('label-' + id);
    if (targetDiv.style.display !== "none") {
        const modifyList = document.getElementById('modify-' + id);
        targetDiv.innerText = '';
        targetDiv.style.display = "none";
        labelList.style.borderRadius = '0 0 30px 30px';
        targetDiv.appendChild(modifyList);
    } else {
        showProduct(id);
        labelList.style.borderRadius = '0';
        targetDiv.style.display = "block";
    }
}

function displayMoreContent(contentId, buttonId){
    const targetDiv = document.getElementById(contentId);
    const button = document.getElementById(buttonId);
    if (targetDiv.style.display !== "none") {
        targetDiv.style.display = "none";
        button.style.display = 'flex';
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
    status.innerText = product.status_name;

    const quantity = clone.querySelector('.quantity');
    quantity.innerText = product.quantity + " " + product.unit_name;


    const category = clone.querySelector('.category');
    if(product.category){
        const categoryContent = clone.querySelector('.category-content')
        categoryContent.innerText = product.category;
    } else{
        category.remove();
    }

    const available = clone.querySelector('.available');
    if(product.available){
        const availableContent = clone.querySelector('.available-content');
        availableContent.innerText = product.available;
    } else{
        available.remove();
    }


    const priority = clone.querySelector('.priority');
    if(product.priority){
        const priorityContent = clone.querySelector('.priority-content');
        priorityContent.innerText = product.priority;
    } else{
        priority.remove();
    }

    const location = clone.querySelector('.location');
    if(product.location){
        const locationContent = clone.querySelector('.location-content');
        locationContent.innerText = product.location;
    } else{
        location.remove();
    }



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



window.addEventListener("resize", resizeListener);

function hideSearchBar(){
    const searchBar = document.getElementById('search-bar');
    searchBar.style.display = 'none';
}

function displaySearchBar(){
    const searchBar = document.getElementById('search-bar');
    searchBar.style.display = 'flex';
}

function mobileViewFilter(){
    const prioritiesFilter = document.getElementById('priorities-filter');
    prioritiesFilter.style.display = 'none';

    const categoriesFilter = document.getElementById('categories-filter');
    categoriesFilter.style.display = 'none';

    const typesFilter = document.getElementById('types-filter');
    typesFilter.style.display = 'block';
}

function tabletViewFilter(){
    const prioritiesFilter = document.getElementById('priorities-filter');
    prioritiesFilter.style.display = 'block';

    const categoriesFilter = document.getElementById('categories-filter');
    categoriesFilter.style.display = 'none';

    const typesFilter = document.getElementById('types-filter');
    typesFilter.style.display = 'block';
}

function desktopViewFilter(){
    const prioritiesFilter = document.getElementById('priorities-filter');
    prioritiesFilter.style.display = 'block';

    const categoriesFilter = document.getElementById('categories-filter');
    categoriesFilter.style.display = 'block';

    const typesFilter = document.getElementById('types-filter');
    typesFilter.style.display = 'block';
}

function displayAddNewList(){
    const addNewList = document.getElementById('create-list');
    addNewList.style.display = 'block';
}

function hideAddNewList(){
    const addNewList = document.getElementById('create-list');
    addNewList.style.display = 'none';
}

function resizeListener(){
    if(window.innerWidth <= mobileSize){
        mobileViewFilter();
        hideSearchBar();
        hideAddNewList();
    } else if(window.innerWidth <= tabletSize){
        tabletViewFilter();
        displaySearchBar();
        hideAddNewList();
    } else if(window.innerWidth <= desktopSize){
        desktopViewFilter();
        displaySearchBar()
        displayAddNewList();
        displayAddNewList();
    }
}

resizeListener();


