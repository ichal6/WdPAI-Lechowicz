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
            <?php
                if(isset($messages)){
                    $user = $messages['user'];
                } else{
                    die('Problem with session.');
            } ?>
            <label>Update data for your account:</label>
            <input name="email" placeholder="give a new email" value="<?=$user->getEmail() ?>">
            <input name="name" placeholder="give a new name" value="<?php echo $user->getName(); ?>">
            <input name="surname" placeholder="give a new surname" value="<?=$user->getSurname() ?>">
            <input name="old-password" placeholder="Please provide your old password">
            <input name="new-password" placeholder="Please provide your new password">
            <input name="new-password-repeat" placeholder="Please repeat your new password">
            <button type="submit" id="update-button">Update account</button>
            <input type="button" value="Discard changes">
        </form>
        <button id="disable">Disable account</button>
    </div>
</body>
</html>