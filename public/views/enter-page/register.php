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
        <h1>We’re glad to see you here!</h1>
        <p>Making a list of shopping, bilans  from month, day and of course control your money!</p>
        <p>You are just about to make a first step to orderly future.</p>
        <p>You don’t have an account?</p>

        <button id="aside-button">Log in</button>
    </aside>

    <section>
        <h1>Sign up:</h1>
        <form action="register" method="POST">
            <dev class="input">
                <img src="public/assets/register-page/person-icon.svg" alt="person-icon">
                <input name="name" type="text" id="name-input" placeholder="Your name" required>
            </dev>
            <dev class="input">
                <img src="public/assets/register-page/person-icon.svg" alt="person-icon">
                <input name="surname" type="text" id="surname-input" placeholder="Your surname" required>
            </dev>
            <dev class="input">
                <img src="public/assets/login-page/email-icon.svg" alt="email-icon">
                <input name="email" type="email" id="email-input" placeholder="Your email (use as login)" required>
            </dev>
            <dev class="input">
                <img src="public/assets/login-page/password-icon.svg" alt="password icon">
                <input name="password" type="password" id="password-input" placeholder="Your password" required>
            </dev>
            <dev class="input">
                <img src="public/assets/login-page/password-icon.svg" alt="password icon" class="repeat-password">
                <img src="public/assets/login-page/password-icon.svg" alt="password icon" class="repeat-password">
                <input name="confirm-password" type="password" id="password-input-confirm" class="repeat-password-input" placeholder="Repeat password" required>
            </dev>
            <div id="error-message">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?>
            </div>
            <button type="submit" id="ready-button">Ready to go!</button>
        </form>
    </section>
</body>
</html>
