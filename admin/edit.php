<?php require("admin_panel.php");

$message_updt = isset($_SESSION['message']) ? $_SESSION['message'] : "";
unset($_SESSION['message']);

if (!isset($_SESSION['message_updt'])) {
    $_SESSION['message_updt'] = "";
}
?>

<div class="col-md-10">
    <?php
    // Debugging echo to check if edit is set
    if (isset($_GET["edit"])) {
        $product_id = $_GET['edit'];

        // Query to fetch product data
        $product_query = "SELECT * FROM product_tim WHERE id = $product_id";
        $product_result = mysqli_query($conn, $product_query);
    }

    // Check if we have data in $product_result
    if (isset($product_result) && mysqli_num_rows($product_result) > 0) {
        // echo "Product data found.<br>";  // Debugging echo for data found in result
        while ($row = mysqli_fetch_assoc($product_result)) {
            $product_id = $row["id"];
            $product_name = $row["name"];
            $product_image = $row["img"];
            $product_price = $row["price"];
            $product_description = $row["description"];
            $product_category = $row["category"];

        }
    } else {
        echo "No product found with the given ID.<br>";  // Debugging echo for no data
    }

    // Handle POST request for updating the product
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
        $product_id = $_POST['product_id'];
        echo "Updating Product ID: " . $product_id . "<br>";  // Debugging echo for product_id in POST
    
        // Get the form data
        $prod_name = mysqli_real_escape_string($conn, $_POST['prod_name']);
        $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
        $prod_desc = mysqli_real_escape_string($conn, $_POST['prod_desc']);
        $prod_cat = mysqli_real_escape_string($conn, $_POST['prod_cat']);

        // Handle file upload if a new image is uploaded
        $prod_img = $_FILES['prod_img']['name'];
        $temp_image = $_FILES['prod_img']['tmp_name'];

        if (!empty($prod_img)) {
            echo "New Image Uploaded: " . $prod_img . "<br>";  // Debugging echo for uploaded image
            if (move_uploaded_file($temp_image, "./uploads/$prod_img")) {
                $update_query = "UPDATE product_tim SET 
                                    name = '$prod_name', 
                                    price = '$prod_price', 
                                    description = '$prod_desc', 
                                    category = '$prod_cat', 
                                    img = '$prod_img' 
                                WHERE id = $product_id";
                if (mysqli_query($conn, $update_query)) {
                    $_SESSION['message_updt'] = "Product updated successfully";
                    header("Location: view.php");
                    exit();
                }
            }
        } else {
            // If no new image, update the other fields
            echo "No new image uploaded.<br>";  // Debugging echo for no image upload
            $update_query = "UPDATE product_tim SET 
                                name = '$prod_name', 
                                price = '$prod_price', 
                                description = '$prod_desc', 
                                category = '$prod_cat' 
                            WHERE id = $product_id";
            if (mysqli_query($conn, $update_query)) {
                $_SESSION['message_updt'] = "Product updated successfully";
                header("Location: view.php");
                exit();
            }
        }
    }
    ?>

    <form action="edit.php" method="POST" enctype="multipart/form-data" class="p-5 m-5">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

        <div class="form-group mb-3">
            <label for="prod_name">Product Name:</label>
            <input type="text" class="form-control" id="prod_name" name="prod_name" value="<?php echo $product_name; ?>"
                required>
        </div>

        <div class="form-group mb-3">
            <label for="prod_price">Product Price:</label>
            <input type="text" class="form-control" id="prod_price" name="prod_price"
                value="<?php echo $product_price; ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="prod_desc">Product Description:</label>
            <textarea class="form-control" id="prod_desc" name="prod_desc" rows="4"
                required><?php echo $product_description; ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="prod_cat">Product Category:</label>
            <select class="form-control" id="prod_cat" name="prod_cat" required>
                <?php
                $category_query = "SELECT * FROM category_tim";
                $category_result = mysqli_query($conn, $category_query);
                while ($category_row = mysqli_fetch_assoc($category_result)) {
                    echo '<option value="' . $category_row['category_title'] . '"';
                    if ($product_category == $category_row['category_title']) {
                        echo ' selected';
                    }
                    echo '>' . $category_row['category_title'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="prod_img">Product Image:</label>
            <input type="file" class="form-control" id="prod_img" name="prod_img">
            <p class="mb-3">Current Image: <img src="./uploads/<?php echo $product_image; ?>" width="100" class="m-4"
                    style="border-radius:10px" alt="Product Image"></p>
        </div>

        <button type="submit" name="update_product" class="btn btn-primary text-dark">Update Product</button>
    </form>
</div>

</body>

</html>