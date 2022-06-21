function changeColorForCurrentPage(){
    const title = document.querySelector('title').innerText;
    switch (title){
        case 'Lists':
            document.getElementById('lists-menu-item').style.color = '#0bd1b8';
            document.getElementById('lists-menu-item').innerHTML = '<img src="public/assets/lists-select.svg">' + title;
            break;
    }
}

changeColorForCurrentPage();