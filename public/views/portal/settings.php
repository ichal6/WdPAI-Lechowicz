<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="public/css/portal.css">
<!--    <link rel="stylesheet" type="text/css" href="public/css/lists.css">-->
    <title>Account settings</title>
</head>
<body>
    <?php
        include_once('commons/header.php');
    ?>

    <div id="main-part">
        <?php
            include_once('commons/left-menu.php');
        ?>
        <form>
            <label>Update data for your account:</label>
            <input placeholder="name">
            <input placeholder="surname">
            <input placeholder="old password">
            <input placeholder="password">
            <input placeholder="email">
            <button type="submit" id="update-button">Update</button>
        </form>
        <button id="disable">Disable account</button>
    </div>
</body>
</html>