<?php
require("admin_panel.php");

$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
unset($_SESSION['message']);
?>

<div class="col-md-10">
    <div class="form-container m-5">
        <div id="alert_box" class="alert alert-success d-flex justify-content-between align-items-center" role="alert"
            style="height: 50px; visibility: <?= empty($message) ? 'hidden' : 'visible' ?>;">
            <span><?= htmlspecialchars($message) ?></span>
            <button id="close" type="button" class="btn-close"></button>
        </div>
        <form method="post">
            <div class="mb-5 container ">
                <label for="category" class="form-label mt-5 justify-content-center item-align-center d-flex"><b>Insert New
                    Category</b></label>
                <input type="text" name="category" id="category" class="form-control" placeholder="Enter category">
                <button type="submit" class="btn mt-3">Submit</button>
            </div>
        </form>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-5 container">
                <label class="form-label justify-content-center item-align-center d-flex"><b>Insert New Product</b></label>
                <input type="text" name="prod_name" class="form-control mt-1" placeholder="Enter new product name"
                    required>

                <input type="file" name="prod_img" class="form-control mt-3" required>

                <input type="number" name="prod_price" class="form-control mt-3" placeholder="Enter new product price"
                    step="0.01" min="0" required>

                <textarea name="prod_desc" class="form-control mt-3" placeholder="Enter new product description"
                    rows="3" required></textarea>

                <select name="prod_cat" class="form-control mt-3" required>
                    <option value="" disabled selected>Category</option>
                    <?php
                    $select_courses = "SELECT * FROM category_tim";
                    $result_courses = mysqli_query($conn, $select_courses);
                    while ($row = mysqli_fetch_assoc($result_courses)) {
                        $category_title = $row['category_title'];
                        $category_id = $row['category_id'];
                        echo "<option value='$category_title'>$category_title</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="insert_product" class="btn mt-3">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</body>
<script>
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