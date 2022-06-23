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

                    <select name="categories" class="select">
                        <option selected="selected" value="all">All categories</option>
                        <?php foreach ($categories as $category) {?>
                            <option value="<?=$category->getId()?>"><?=$category->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="types" class="select">
                        <option selected="selected" value="all">All types</option>
                        <?php foreach ($types as $type) {?>
                            <option value="<?=$type->getId()?>"><?=$type->getName()?></option>
                        <?php }?>
                    </select>
                </div>
                <div id="list-body">

                </div>

            </div>
            <div id="Create-list">
                <form action="add_list" method="POST">
                    <h2>Add new List:</h2>
                    <input name="title" id="title-input" placeholder="Title">
                    <select name="type" id="type-input">
                        <?php foreach ($types as $type) {?>
                            <option selected="selected" value="<?=$type->getId()?>"><?=$type->getName()?></option>
                        <?php }?>
                    </select>
                    <input list="list-category" name="category" type="text" id="category-input" placeholder="Category (optional)">
                    <datalist id="list-category">
                        <?php foreach ($categories as $category) {?>
                            <option value="<?=$category->getName()?>">
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
                <form action="add_product" method="POST">
                    <h2>Add product to this list:</h2>
                    <input name="name" type="text" id="product-name" placeholder="Name">
                    <input name="price" type="text" id="product-price" placeholder="Price (optional)">
                    <input name="quantity" type="text" id="product-quantity" placeholder="Quantity">
                    <input name="unit" type="text" id="product-unit" placeholder="Unit">
                    <button type="submit">Add new</button>
                    <a href="/products" id="go-to-products">Go to products section</a>
                </form>

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
                <button class="edit-list" id="">Edit List</button>
                <button class="remove-list" id="">Delete list</button>
                <button class="share-list" id="">Share<img src="public/assets/portal/lists/share-icon.svg" alt="share-icon"></button>
            </div>
        </div>
    </div>

</template>
<template id="product-template">
    <div class="product">
        <strong class="product-name"></strong>
        <p class="last-price">Last price: <strong class="price"></strong></p>
        <p class="status"></p>
        <p class="quantity"></p>
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
