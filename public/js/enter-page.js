const aboutItem = document.getElementById('about-item');
const blogItem = document.getElementById('blog-item');
const FAQItem = document.getElementById('FAQ-item');
const navToRegister = document.getElementById('nav-sign-up');
const navToLogin = document.getElementById('nav-log-in');
const mainIcon = document.getElementById('main-icon');
const mobileIcon = document.getElementById('mobile-icon');
const asideSignUpButton = document.getElementById('aside-sign-up');
const asideLogInButton = document.getElementById('aside-log-in');

aboutItem.addEventListener('click', function (event){
    alert('With this application you can create shopping lists and add product to this list.');
});

function notImplementedInfo(){
    alert('Not implemented yet.');
}

function redirectToLoginPage(){
    window.location.href='login';
}

function redirectToRegisterPage(){
    window.location.href='register';
}

function redirectToIndex(){
    window.location.href='index';
}

blogItem.addEventListener('click', notImplementedInfo);
FAQItem.addEventListener('click', notImplementedInfo);

navToLogin.addEventListener('click', redirectToLoginPage);
navToRegister.addEventListener('click', redirectToRegisterPage);

mainIcon.addEventListener('click', redirectToIndex);
mobileIcon.addEventListener('click', redirectToIndex);
