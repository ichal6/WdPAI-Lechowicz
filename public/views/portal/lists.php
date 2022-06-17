<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="public/css/portal.css">
    <link rel="stylesheet" type="text/css" href="public/css/lists.css">
    <title>Lists</title>
</head>
<body>
    <?php
        include_once('commons/header.php');
    ?>

    <div id="main-part">
        <nav id="left-menu">
            <a href="/lists"><img src="public/assets/lists-select.svg">Lists</a>
        </nav>

        <section>
            <div id="lists-container">
                <div id="lists-container-header">
                    <select name="lists" class="select">
                        <option selected="selected" value="spożywcze">Lists:</option>
                        <option value="spożywcze">Spożywcze</option>
                        <option value="chemiczne">Chemiczne</option>
                    </select>

                    <select name="categories" class="select">
                        <option selected="selected" value="daily">Category:</option>
                        <option value="daily">Codzienne</option>
                        <option value="present">Prezent</option>
                    </select>

                    <select name="Types" class="select">
                        <option selected="selected" value="normal">Types:</option>
                        <option value="normal">Normal</option>
                        <option value="cyclic">Cyclic</option>
                    </select>
                </div>
                <div id="list-body">
                    <div id="list-info">
                        <p>Type: Cyclic | Category: chemiczne | Owner: Alicja | Priorytet: High  </p>
                        <div class="product">
                            <strong>Płyn do prania Biały Jeleń</strong>
                            <p>Last price: <strong class="price">20 zł</strong></p>
                            <p>Status: available</p>
                            <p>Quantity for buy: 1 piece</p>
                            <div class="more"><p>More</p><img src="public/assets/portal/lists/more-icon.svg" alt="more-icon"></div>
                        </div>
                        <div class="product">
                            <strong>Mydło szare</strong>
                            <p>Last price: <strong class="price">1,5 zł</strong></p>
                            <p>Status: zakupione</p>
                            <p>Quantity for buy: 1 piece</p>
                            <p>Category: chemiczne</p>
                            <p>Subcategory: do łazienki</p>
                            <p>Available: high</p>
                            <p>Priority: high</p>
                            <p>Locations: Pomieszczenie gospodarcze</p>
                            <div class="remove"><p>Remove</p><img src="public/assets/portal/lists/remove-icon.svg" alt="remove-icon"></div>
                            <div class="edit"><p>Edit</p><img src="public/assets/portal/lists/edit-product-icon.svg" alt="edit-icon"></div>
                            <div class="less"><p>Less</p><img src="public/assets/portal/lists/less-icon.svg" alt="less-icon"></div>
                        </div>
                    </div>
                    <a href="lists" class="button" id="edit-list-button">Edit list</a>
                    <a href="lists" class="button" id="remove-list-button">Delete list</a>
                    <a href="lists" class="button" id="share-list-button">Share<img src="public/assets/portal/lists/share-icon.svg" alt="share-icon"></a>
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
</html>