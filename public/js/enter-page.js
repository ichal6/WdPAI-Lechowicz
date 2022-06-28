const aboutItem = document.getElementById('about-item');
const blogItem = document.getElementById('blog-item');
const FAQItem = document.getElementById('FAQ-item');

aboutItem.addEventListener('click', function (event){
    alert('With this application you can create shopping lists and add product to this list.');
});

function notImplementedInfo(){
    alert('Not implemented yet.');
}

blogItem.addEventListener('click', notImplementedInfo);

FAQItem.addEventListener('click', notImplementedInfo);