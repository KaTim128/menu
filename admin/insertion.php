<?php
require("admin_panel.php");
?>

<div class="col-md-10">
    <div class="form-container m-5">
        <form method="post">
            <div class="mb-5 container ">
                <label for="category" class="form-label mt-5 justify-content-center item-align-center d-flex">Insert New
                    Category</label>
                <input type="text" name="category" id="category" class="form-control" placeholder="Enter category">
                <button type="submit" class="btn mt-3">Submit</button>
            </div>
        </form>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-5 container">
                <label class="form-label justify-content-center item-align-center d-flex">Insert New Product</label>
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
                        echo "<option value='$category_id'>$category_title</option>";
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

</html>