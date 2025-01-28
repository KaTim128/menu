<?php
require('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert new category
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
        if (!empty($category)) {
            $category = mysqli_real_escape_string($conn, $category);

            $sql = "INSERT INTO category_tim (category_title) VALUES ('$category')";
            if (mysqli_query($conn, $sql)) {
                header("Location: insertion.php?success=1");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

    // Insert new product
    if (isset($_POST['insert_product'])) {
        $prod_name = mysqli_real_escape_string($conn, $_POST['prod_name']);
        $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
        $prod_desc = mysqli_real_escape_string($conn, $_POST['prod_desc']);
        $prod_cat = mysqli_real_escape_string($conn, $_POST['prod_cat']);

        $image = $_FILES['prod_img']['name'];
        $temp_image = $_FILES['prod_img']['tmp_name'];

        // Move uploaded file to uploads directory
        if (move_uploaded_file($temp_image, "./uploads/$image")) {
            $sql = "INSERT INTO product_tim (name, img, price, description, category) 
                    VALUES ('$prod_name', '$image', '$prod_price', '$prod_desc', '$prod_cat')";

            if (mysqli_query($conn, $sql)) {
                header("Location: insertion.php?success=1");
                exit();
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>

    <link rel="stylesheet" href="../bootstrap.css">
    <script defer src="bootstrap.bundle.js"></script>
    <script src="../jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin_style.css">
</head>

<body>
    <!-- Container for the layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-2 sidebar d-flex justify-content-center align-items-center">
                <img src="../images/default.png" alt="" class="my-4">
                <button class="btn mb-3 zoom text-center">
                    <a href="insertion.php" class="text-dark font-bold">Insertion</a>
                </button>
                <button class="btn mb-3 zoom text-center">
                    <a href="insertion.php" class="text-dark font-bold">View</a>
                </button>
                <button class="btn mb-3 zoom text-center">
                    <a href="" class="text-dark font-bold">All Orders</a>
                </button>
                <button class="btn mb-3 zoom text-center">
                    <a href="" class="text-dark font-bold">Payments</a>
                </button>
                <button class="btn mb-3 zoom text-center">
                    <a href="" class="text-dark font-bold">List Users</a>
                </button>
                <button class="btn mb-3 zoom text-center">
                    <a href="" class="text-dark font-bold">Messages</a>
                </button>
                <button class="btn mb-3 zoom text-center">
                    <a href="../index.php" class="text-dark font-bold">Logout</a>
                </button>
            </div>