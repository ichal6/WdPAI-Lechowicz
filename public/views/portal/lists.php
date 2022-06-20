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
                            <option value="<?=$priority->getName()?>"><?=$priority->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="categories" class="select">
                        <option selected="selected" value="all">All categories</option>
                        <?php foreach ($categories as $category) {?>
                            <option value="<?=$category->getName()?>"><?=$category->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="Types" class="select">
                        <option selected="selected" value="all">All types</option>
                        <?php foreach ($types as $type) {?>
                            <option value="<?=$type->getName()?>"><?=$type->getName()?></option>
                        <?php }?>
                    </select>
                </div>
                <div id="list-body">

                </div>

            </div>
            <div id="Create-list">
                <form>
                    <h2>Add new List:</h2>
                    <input id="list-name" placeholder="Name">
                    <input id="type" placeholder="Type">
                    <input type="text" id="category" placeholder="Category">
                    <input type="text" id="subcategory" placeholder="Subcategory">
                    <button type="submit">Add new</button>
                </form>
                <form>
                    <h2>Add product to this list:</h2>
                    <input type="text" id="product-name" placeholder="Name">
                    <input type="text" id="product-price" placeholder="Price">
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
            <div class="modify-list">
                <a href="lists" class="button" id="edit-list-button">Edit list</a>
                <a href="lists" class="button" id="remove-list-button">Delete list</a>
                <a href="lists" class="button" id="share-list-button">Share<img src="public/assets/portal/lists/share-icon.svg" alt="share-icon"></a>
            </div>
        </div>
    </div>

</template>
<template id="product-template">
    <div class="product">
        <strong class="product-name">Mydło szare</strong>
        <p class="last-price">Last price: <strong class="price">1,5 zł</strong></p>
        <p class="status">Status: zakupione</p>
        <p class="quantity">Quantity for buy: 1 piece</p>
        <div class="more-content" id="">
            <p class="category">Category: chemiczne</p>
            <p class="available">Available on market: high</p>
            <p class="priority">Priority: high</p>
            <p class="location">Locations: Pomieszczenie gospodarcze</p>
            <div class="remove"><p>Remove</p><img src="public/assets/portal/lists/remove-icon.svg" alt="remove-icon"></div>
            <div class="edit"><p>Edit</p><img src="public/assets/portal/lists/edit-product-icon.svg" alt="edit-icon"></div>
            <div class="less"><p>Less</p><img src="public/assets/portal/lists/less-icon.svg" alt="less-icon"></div>
        </div>
    </div>
</template>
</html>
