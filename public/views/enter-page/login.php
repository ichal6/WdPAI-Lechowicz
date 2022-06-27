<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/enter-page.css">
    <title>ShopTherapy-Login</title>
</head>
<body>
    <dev class="background-component">
        <img class="green-point" src="public/assets/login-page/green-point.svg">
        <img class="green-point" src="public/assets/login-page/green-point.svg">
        <img class="orange-x" src="public/assets/login-page/orange-x.svg">
        <img class="orange-x" src="public/assets/login-page/orange-x.svg">
        <img class="red-cross" src="public/assets/login-page/red-cross.svg">
        <img class="red-cross" src="public/assets/login-page/red-cross.svg">
        <img id="small-brackets" src="public/assets/login-page/white-brackets.svg">
        <img id="medium-brackets" src="public/assets/login-page/white-brackets.svg">
        <img id="vertical-brackets" src="public/assets/login-page/white-brackets.svg">
    </dev>
    
    <nav>
        <dev id="left-menu">
            <img id="main-icon" src="public/assets/logo-full-login-page.svg" alt="ShopTherapyy icon" onclick="window.location.href='index';"></img>
            <img id="mobile-icon" src="public/assets/logo-mobile-login-page.png" alt="ShopTherapyy icon" onclick="window.location.href='index';"></img>
            <dev id="menu-items">
                <a onclick="alert('Not implemented yet.')" class="menu-item">about</a>
                <a onclick="alert('Not implemented yet.')" class="menu-item">blog</a>
                <a onclick="alert('Not implemented yet.')" class="menu-item">FAQ</a>
            </dev>
        </dev>

        <dev id="right-menu">
            <button id="nav-sign-up" onclick="window.location.href='register';">Sign up</button>
            <button id="nav-log-in" onclick="window.location.href='login';">Log in</button>
        </dev>
    </nav>

    <aside>
        <h1>We’re glad to see you back!</h1>
        <h2>Log in</h2>

        <p>Making a list of shopping, bilans  from month, day and of course control your money!</p>
        <p>You are just about to make a first step to orderly future.</p>
        <p>You don’t have an account?</p>

        <button onclick="window.location.href='register';" id="aside-sign-up">Sign up. It'free</button>
<!--        <button onclick="window.location.href='login';" id="log-in-mobile">Login</button>-->
    </aside>

    <section>
        <h1>Log in</h1>
        <form action="login" method="POST">
            <dev class="input">
                <img src="public/assets/login-page/email-icon.svg" alt="email-icon">
                <input name="email" type="email" id="email-input" placeholder="Your email" required>
            </dev>
            <dev class="input">
                <img src="public/assets/login-page/password-icon.svg" alt="password icon">
                <input name="password" type="password" id="password-input" placeholder="Your password" required>
            </dev>
            <div id="error-message">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?></div>
            <a onclick="alert('Please contact with administrator!')" class="forgot">forgot your password?</a>
            <button type="submit" id="ready-button">Ready to go!</button>
        </form>
    </section>
</body>
</html>
