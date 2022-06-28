<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/enter-page.css">
    <script defer src="public/js/enter-page.js"></script>
    <title>ShopTherapy-Login</title>
</head>
<body>
    <?php
        include_once('commons/background.php');
    ?>

    <?php
        include_once('commons/nav.php');
    ?>

    <aside>
        <h1>We’re glad to see you back!</h1>
        <h2>Log in</h2>

        <p>Making a list of shopping, bilans  from month, day and of course control your money!</p>
        <p>You are just about to make a first step to orderly future.</p>
        <p>You don’t have an account?</p>

        <button id="aside-button">Sign up. It'free</button>
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
