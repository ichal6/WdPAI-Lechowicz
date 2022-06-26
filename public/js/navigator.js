function changeColorForCurrentPage(){
    const title = document.querySelector('title').innerText;
    switch (title){
        case 'Lists':
            document.getElementById('lists-menu-item').style.color = '#0bd1b8';
            document.getElementById('lists-menu-item').innerHTML = '<img src="public/assets/lists-select.svg">' + '<span class="desktop">' + title + '</span>';
            break;
    }
}

document.getElementById('search-menu-item').addEventListener('click', function (event){
    const searchButton = document.getElementById('search-bar');
    if(searchButton.style.display !== 'none'){
        searchButton.style.display = 'none';
    } else{
        searchButton.style.display = 'flex';
    }
});


changeColorForCurrentPage();