<?php require('admin_panel.php');

$message_updt = isset($_SESSION['message_updt']) ? $_SESSION['message_updt'] : "";
unset($_SESSION['message_updt']);



?>
<div class="col-md-10 p-4">
    <div class="table-responsive">
        <div id="alert_box" class="alert alert-success d-flex justify-content-between align-items-center" role="alert"
            style="height: 50px; visibility: <?= empty($message_updt) ? 'hidden' : 'visible' ?>;">
            <span><?= htmlspecialchars($message_updt) ?></span>
            <button id="close" type="button" class="btn-close"></button>
        </div>

        <div class="mb-3">
            <button method="post" class="btn mb-3 zoom text-center">
                <a class="text-dark font-bold" value="cat" href="?prod=cat">Categories</a>
            </button>
            <button method="post" class="btn mb-3 zoom text-center">
                <a class="text-dark font-bold" value="prod" href="?prod=prod">Products</a>
            </button>
        </div>

        <?php
        if (isset($_GET['prod']) && $_GET['prod'] == 'prod') {
            // Show products if the 'prod' value is set in the GET request
            ?>
            <table class="table table-bordered table-hover text-center">
                <thead class="table-light">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <form class="d-flex w-50" action="#" method="post">
                        <input class="form-control me-2 search-bar mb-3" style="width:500px;" name="search_prod"
                            type="search" placeholder="Search" aria-label="Search">
                        <div class="form-group">
                            <select class="form-control mb-3" id="col_name" name="col_name" style="width:145px;">
                                <option value="" disabled selected>Select Column ▼</option>
                                <option value="name">Name</option>
                                <option value="id">ID</option>
                                <option value="category">Category</option>
                            </select>
                        </div>
                        <button class="btn btn-search text-dark text-center" style="width:100px;"
                            type="submit">Search</button>
                    </form>

                    <!-- Hidden input to store the selected column name -->
                    <input type="hidden" name="col_name" id="col_name" value="name">

                    <?php
                    $col_name = isset($_POST['col_name']) ? $_POST['col_name'] : 'name';
                    $w = " WHERE id > 0";
                    $sq = isset($_POST["search_prod"]) ? $_POST["search_prod"] : '';
                    if ($sq != "") {
                        $w .= " AND " . $col_name . " LIKE '%" . htmlspecialchars($sq) . "%'";
                    }

                    $select_query = "SELECT * FROM product_tim" . $w;
                    $query_result = mysqli_query($conn, $select_query);
                    while ($row = mysqli_fetch_array($query_result)) {
                        $product_id = $row["id"];
                        $product_name = $row["name"];
                        $product_image = $row["img"];
                        $product_description = $row["description"];
                        $product_price = $row["price"];
                        $product_category = $row["category"];
                        ?>
                        <tr>
                            <td><?= $product_id ?></td>
                            <td><?= htmlspecialchars($product_name) ?></td>
                            <td>
                                <img src='./uploads/<?= htmlspecialchars($product_image) ?>' class='img-thumbnail'
                                    style='width:80px; height:80px; object-fit:cover;'>
                            </td>
                            <td
                                style="margin: 15px; max-width: 600px; width:600px; word-wrap: break-word; white-space: normal; text-align: left;">
                                <?= htmlspecialchars($product_description) ?>
                            </td>
                            <td>RM<?= number_format($product_price, 2) ?></td>
                            <td><?= $product_category ?></td>
                            <td>
                                <a href="edit.php?edit=<?= $product_id ?>" class="btn btn-yellow text-dark">Edit Product</a>
                                <a href="admin_panel.php?remove=<?= $product_id ?>" class="btn btn-yellow text-dark">Remove Product</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <?php
        } elseif (isset($_GET['prod']) && $_GET['prod'] == 'cat') {
            ?>
            <table class="table table-bordered table-hover text-center"
                style="max-width:600px; margin-left:auto; margin-right:auto; margin-top:60px;">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Category ID</th>
                        <th class="text-center">Category Title</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_query = "SELECT * FROM category_tim";
                    $query_result = mysqli_query($conn, $select_query);
                    while ($row = mysqli_fetch_array($query_result)) {
                        $category_id = $row["category_id"];
                        $category_title = $row["category_title"];
                        ?>
                        <tr class="table-row">
                            <td class="text-center align-middle"><?= $category_id ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($category_title) ?></td>
                            <td class="text-center">
                                <a href="edit.php?edit=<?= $category_id ?>" class="btn btn-yellow text-dark">Edit Category</a>
                                <a href="admin_panel.php?remove=<?= $category_id ?>" class="btn btn-yellow text-dark">Remove Category</a>
                            </td>
                        </tr>
                        <?php
                    }
        }
        ?>
            </tbody>
        </table>

    </div>
</div>
</div>
</div>
</body>

<script>
    // Function to update the hidden input with the selected column name
    function setColumn(colName) {
        document.getElementById('col_name').value = colName;
    }

    $(document).ready(function () {
        var $alertBox = $('#alert_box');

        if ($alertBox.length) {
            var myTimeOut = setTimeout(myTimeoutFunction, 3000);

            $alertBox.on('mouseleave', function () {
                myTimeOut = setTimeout(myTimeoutFunction, 3000);
            });

            $alertBox.on('mouseenter', function () {
                clearTimeout(myTimeOut);
            });

            function myTimeoutFunction() {
                $alertBox.fadeOut('fast', function () {
                    $(this).css("visibility", "hidden"); // Hide but keep space
                });
            }

            // On click, fade out and hide
            $("#close").click(function () {
                clearTimeout(myTimeOut);
                $alertBox.fadeOut('fast', function () {
                    $(this).css("visibility", "hidden");
                });
            });
        }
    });
</script>

</html>