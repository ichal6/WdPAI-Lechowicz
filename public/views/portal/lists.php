<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="public/css/portal.css">
    <link rel="stylesheet" type="text/css" href="public/css/lists.css">
    <script defer src="public/js/navigator.js"></script>
    <script defer src="public/js/lists.js"></script>
    <script defer src="public/js/search.js"></script>
    <title>Lists</title>
</head>
<body>
    <?php
        include_once('commons/header.php');
    ?>

    <div id="main-part">
    <?php
        include_once('commons/left-menu.php');
    ?>
    <?php
        if(isset($messages)){
            $user = $messages['user'];
            $categories = $messages['categories'];
            $types = $messages['types'];
            $priorities = $messages['priorities'];
            $currencies = $messages['currencies'];
            $units = $messages['units'];
            $error = in_array('error', $messages) ? $messages['error'] : null;
        } else{
            die('Problem with session.');
    } ?>
        <section>
            <div id="lists-container">
                <div id="lists-container-header">
                    <select name="priorities" class="select">
                        <option selected="selected" value="all">All priorities</option>
                        <?php foreach ($priorities as $priority) {?>
                            <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="categories" class="select desktop">
                        <option selected="selected" value="all">All categories</option>
                        <?php foreach ($categories as $category) {?>
                            <option value="<?=$category->getId()?>"><?=$category->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="types" class="select desktop">
                        <option selected="selected" value="all">All types</option>
                        <?php foreach ($types as $type) {?>
                            <option value="<?=$type->getId()?>"><?=$type->getName()?></option>
                        <?php }?>
                    </select>

                    <button class="mobile" id="show-more-filter" type="button"><img src="public/assets/portal/lists/more-content.svg"></button>
                </div>


                <div id="list-body">

                </div>

            </div>
            <div id="create-list">
                <form action="add_list" method="POST">
                    <h2>Add new List:</h2>
                    <input name="title" id="title-input" placeholder="Title" required minlength="3" maxlength="255">
                    <select name="type" id="type-input">
                        <?php foreach ($types as $type) {?>
                            <option selected="selected" value="<?=$type->getId()?>"><?=$type->getName()?></option>
                        <?php }?>
                    </select>
                    <input list="list-category" name="category" type="text" id="category-input" placeholder="Category (optional)" minlength="3" maxlength="255">
                    <datalist id="list-category">
                        <?php foreach ($categories as $category) {?>
                            <option value="<?=$category->getName()?>"></option>
                        <?php }?>
                    </datalist>
                    <select name="priority" id="list-priority">
                        <option selected="selected" value="">Priority (optional)</option>
                        <?php foreach ($priorities as $priority) {?>
                            <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                        <?php }?>
                    </select>

                    <button type="submit">Add new</button>
                </form>
            </div>
            <div id="add-product-to-list-form">
                <form action="add_product_to_list" method="POST" id="add-product">
                    <button id="disable-add-product" type="button" onclick="displayAddForm('add-product-to-list-form')">X</button>
                    <h2>Add product to this list:</h2>
                    <input name="list-id" value="" type="text" id="add-form-list-id" required>
                    <input name="name" type="text" id="product-name" placeholder="Name" required minlength="3" maxlength="255">
                    <input name="price" type="number" id="product-price" placeholder="Price (optional)" min="0" max="1000000">
                    <select name="currency_id" id="list-currency">
                        <?php foreach ($currencies as $currency) {?>
                            <option selected="selected" value="<?=$currency->getId()?>"><?=$currency->getName()?></option>
                        <?php }?>
                    </select>
                    <input name="quantity" type="number" id="product-quantity" placeholder="Quantity" required min="1" max='100000000'>
                    <select name="unit" id="product-unit">
                        <?php foreach ($units as $unit) {?>
                            <option selected="selected" value="<?=$unit->getId()?>"><?=$unit->getName()?></option>
                        <?php }?>
                    </select>
                    <button id="add-product-button" type="submit">Add new product</button>
                    <a href="/products" id="go-to-products">Go to products section</a>
                </form>
            </div>
            <div>
                <p id="error-box"><?=$error?></p>
            </div>
        </section>
    </div>
</body>

<template id="list-template">
    <div class="list-info">
        <input class="title-list-btn" type="button">
        <p class="label-list"></p>
        <div class="list-content" id="">
            <div class="modify-list" id="">
                <button class="edit-list" id=""><span class="desktop">Edit List</span><img class="mobile" src="public/assets/portal/lists/edit-list-icon.svg" alt="edit-icon"></button>
                <button class="remove-list" id=""><span class="desktop">Delete list</span><img class="mobile" src="public/assets/portal/lists/remove-list-icon.svg" alt="remove-icon"></button>
                <button class="share-list" id=""><span class="desktop">Share</span><img src="public/assets/portal/lists/share-icon.svg" alt="share-icon"></button>
                <button class="add-product-to-list" id=""><span class="desktop">Add product</span><img src="public/assets/portal/lists/add-product.svg" alt="add-product-icon"></button>
            </div>
        </div>
    </div>

</template>
<template id="product-template">
    <div class="product">
        <strong class="product-name"></strong>
        <p class="last-price">Last price: <strong class="price"></strong></p>
        <p>Status: <strong class="status"></strong></p>
        <p>Quantity for buy: <strong class="quantity"></strong></p>
        <button class="more" id=''>More options<img src="public/assets/portal/lists/more-icon.svg" alt="more-icon"></button>
        <div class="more-content" id="">
            <p class="category"></p>
            <p class="available"></p>
            <p class="priority"></p>
            <p class="location"></p>
            <button class="remove" id="">Remove product<img src="public/assets/portal/lists/remove-icon.svg" alt="remove-icon"></button>
            <button class="edit" id="">Edit product<img src="public/assets/portal/lists/edit-product-icon.svg" alt="edit-icon"></button>
            <button class="bought" id="">Set as bought<img src="public/assets/portal/lists/bought.svg" alt="bought-icon"></button>
            <button class="less" id=''>Less options<img src="public/assets/portal/lists/less-icon.svg" alt="less-icon"></button>
        </div>
    </div>
</template>

</html>
