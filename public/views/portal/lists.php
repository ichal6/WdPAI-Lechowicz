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
                    <button class="mobile tablet" type="button" id="show-add-list"><img alt="add-list" src="public/assets/portal/lists/add-list.svg"></button>

                    <select name="priorities" class="select tablet" id="priorities-filter">
                        <option selected="selected" value="all">All priorities</option>
                        <?php foreach ($priorities as $priority) {?>
                            <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="categories" class="select desktop tablet" id="categories-filter">
                        <option selected="selected" value="all">All categories</option>
                        <?php foreach ($categories as $category) {?>
                            <option value="<?=$category->getId()?>"><?=$category->getName()?></option>
                        <?php }?>
                    </select>

                    <select name="types" class="select desktop" id="types-filter">
                        <option selected="selected" value="all">All types</option>
                        <?php foreach ($types as $type) {?>
                            <option value="<?=$type->getId()?>"><?=$type->getName()?></option>
                        <?php }?>
                    </select>


                    <div id="list-filter">
                        <button class="mobile tablet" id="show-more-filter" type="button"><img id='more-filter-icon' src="public/assets/portal/lists/more-content.svg"></button>
                        <div id="select-filter">
                            <button id="select-priorities" type="button">Priorities</button>
                            <button id="select-types" type="button">Types</button>
                            <button id="select-categories" type="button">Categories</button>
                        </div>

                    </div>
                </div>


                <div id="list-body">

                </div>

            </div>
            <div id="right-panel">
                <div class="desktop" id="create-list">
                    <form action="add_list" method="POST" id="add-list">
                        <button class="mobile tablet" id="disable-add-list" type="button" onclick="displayAddForm('create-list')">
                            <img alt="disable add list" id="disable-add-list-icon" src="public/assets/portal/lists/add-list.svg">
                        </button>
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

                        <button id="submit-add-list" type="submit">Add new</button>
                    </form>
                </div>
                <div id="add-product-to-list-form" class="desktop">
                    <form action="add_product_to_list" method="POST" id="add-product">
                        <button id="disable-add-product" type="button">
                            <span class="desktop label">Discard changes</span>
                            <img class="tablet mobile" alt="disable add product" id="disable-add-product-icon" src="public/assets/portal/lists/add-list.svg">
                        </button>
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
                        <div id="add-product-buttons">
                            <button id="add-product-button" type="submit">Add new product</button>
                            <a href="/products" id="go-to-products">Go to products section</a>
                        </div>
                    </form>
                </div>
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
                <button class="modify-buttons edit-list" id=""><span class="label desktop">Edit List</span><img class="tablet mobile" src="public/assets/portal/lists/edit-list-icon.svg" alt="edit-icon"></button>
                <button class="modify-buttons remove-list" id=""><span class="label desktop">Delete list</span><img class="tablet mobile" src="public/assets/portal/lists/remove-list-icon.svg" alt="remove-icon"></button>
                <button class="modify-buttons share-list" id=""><span class="label" style="display: none">Share</span><img src="public/assets/portal/lists/share-icon.svg" alt="share-icon"></button>
                <button class="modify-buttons add-product-to-list" id=""><span class="label" style="display: none">Add product</span><img src="public/assets/portal/lists/add-product.svg" alt="add-product-icon"></button>
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
            <p class="category">Category: <strong class="category-content"></strong></p>
            <p class="available">Available on market: <strong class="available-content"></strong></p>
            <p class="priority">Priority: <strong class="priority-content"></strong> </p>
            <p class="location">Location: <strong class="location-content"></strong> </p>
            <div class="option-buttons">
                <button class="remove" id=""><span class="desktop tablet label-remove labels">Remove product</span><img src="public/assets/portal/lists/remove-icon.svg" alt="remove-icon"></button>
<!--                <button class="edit label" id=""><span class="desktop">Edit product</span><img src="public/assets/portal/lists/edit-product-icon.svg" alt="edit-icon"></button>-->
                <button class="bought" id=""><span class="desktop tablet label-bought labels">Set as bought</span><img src="public/assets/portal/lists/bought.svg" alt="bought-icon"></button>
                <button class="less" id=''><span class="desktop tablet label-less labels">Less options</span><img src="public/assets/portal/lists/less-icon.svg" alt="less-icon"></button>
            </div>
        </div>
    </div>
</template>

</html>
