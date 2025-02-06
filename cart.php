<?php
require("header.php");

$cartTotalPrice = 0;

// Query to get the user's cart
$user_cart_query = "SELECT * FROM cart_tim WHERE user_id = $user_id";
$result = mysqli_query($conn, $user_cart_query);


// Handle updating the cart item quantities
if (isset($_POST['update_all'])) {
    echo 'test1';
    // Loop through each item and update their quantities
    foreach ($_POST['quantity'] as $cartId => $newQuantity) {
        // Validate quantity
        echo 'test2';
        if (is_numeric($newQuantity) && $newQuantity > 0) {
            // Update the cart item in the database
            $update_query = "UPDATE cart_tim SET quantity = $newQuantity WHERE id = $cartId AND user_id = $user_id";
            mysqli_query($conn, $update_query);
        }
    }
    echo 'test3';
    // Re-fetch the updated cart after the quantity update
    $result = mysqli_query($conn, $user_cart_query);
}

// Handle removing the item from the cart
if (isset($_POST['remove'])) {
    $cartIdToRemove = $_POST['remove'];  // Get the cart item ID to remove
    // Delete the item from the cart
    $remove_query = "DELETE FROM cart_tim WHERE id = $cartIdToRemove AND user_id = $user_id";
    mysqli_query($conn, $remove_query);

    // Re-fetch the cart after removing the item
    $result = mysqli_query($conn, $user_cart_query);
}

?>
<div class="container-fluid p-0">
    <div class="row flex-wrap gx-0">
        <?php require "sidebar.php" ?>
        <div class="col-md-10 p-4">
            <form method="POST" action="cart.php">
                <div class="table-responsive">
                    <table class="cart-table" border="1"
                        style="text-align: center; border-collapse: collapse; width: 100%; margin: 10px 0; border:2px solid #ddd;">
                        <thead style="background-color: #efeded;">
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($cart = mysqli_fetch_assoc($result)) {
                                $product_id = $cart["product_id"];
                                $product_query = "SELECT * FROM product_tim WHERE id = $product_id";
                                $product_result = mysqli_query($conn, $product_query);
                                $product_data = mysqli_fetch_assoc($product_result);

                                $product_name = $product_data["name"];
                                $product_image = $product_data["img"];
                                $product_price = $product_data["price"];
                                $total_price = $product_price * $cart["quantity"];
                                $cartTotalPrice += $total_price;
                                ?>
                                <tr>
                                    <td class="cart-table-cell" style="padding: 10px; border: 2px solid #ddd;"
                                        data-label="Product ID"><?= $cart["id"] ?></td>
                                    <td class="cart-table-cell" style="padding: 10px; border: 2px solid #ddd;"
                                        data-label="Product Name"><?= $product_data["name"] ?></td>
                                    <td class="cart-table-cell"
                                        style="text-align: center; vertical-align: middle; padding: 10px; border: 1px solid #ddd;"
                                        data-label="Product Image">
                                        <img src='./admin/uploads/<?= $product_image ?>'
                                            class='product-image shadow-sm card zoom display-center my-2'
                                            style='border-radius:5px; width:80px; height:80px; display: block; margin: 0 auto;'
                                            alt='Product Image'>
                                    </td>
                                    <td class="cart-table-cell" style="padding: 10px; border: 2px solid #ddd;"
                                        data-label="Price">RM<?= number_format($total_price, 2) ?></td>
                                    <td class="cart-table-cell" style="padding: 10px; border: 2px solid #ddd;"
                                        data-label="Quantity">
                                        <input type="number" id="quantity<?= $cart["id"] ?>"
                                            name="quantity[<?= $cart["id"] ?>]" value="<?= $cart["quantity"] ?>" min="1"
                                            max="10" class="quantity-input">
                                    </td>
                                    <td class="cart-table-cell" style="padding: 10px; border: 2px solid #ddd;"
                                        data-label="Operations">
                                        <button name="remove" style="margin:5px;" id="btn-remove-<?= $cart["id"] ?>"
                                            class="btn btn-red btn-sm py-2" value="<?= $cart["id"] ?>">Remove</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Total Price and Checkout Button in One Block -->
                    <div class="d-flex flex-column flex-sm-row align-items-center w-100 justify-content-between">
                        <?php if (mysqli_num_rows($result) > 0) { ?>
                            <h2 class="m-4 w-100 text-center">Total Amount: RM<?= number_format($cartTotalPrice, 2) ?></h2>
                            <button type="submit" id="btn-update" name="update_all"
                                class="btn btn-yellow zoom-in w-100 mx-4 my-2">Update
                                All</button>
                            <button type="button" class="btn btn-yellow zoom-in w-100 mx-4 my-2"
                                onclick="window.location.href='checkout.php'">Checkout</button>
                        <?php } ?>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#btn-update").click(function (e) {
        e.preventDefault();

        let inputs = document.querySelectorAll("input[id^='quantity']");

        let values = {};

        inputs.forEach(input => {
            let id = input.id.replace("quantity", "");
            values[id] = input.value;
        });
        console.log(values); // Outputs all input values in an array
        $.ajax({
            url: 'update_cart.php',
            type: 'POST',
            data: { values: values },// Pass the cart ID
            // quantity: quantity // Pass the updated quantity
            success: function (response) {
                var data = JSON.parse(response); // Parse the JSON response
                localStorage.setItem('notification', data.message); // Store the message in localStorage
                window.location.reload(); // Reload the page to update the cart
            }
        });
    });


    // Handle remove button click for each row
    $("[id^='btn-remove-']").click(function (e) {
        e.preventDefault(); // Prevent the default form submission

        var cartId = $(this).val(); // Get the cart item ID from the button's value
        $.ajax({
            url: 'remove_item.php',
            type: 'POST',
            data: {
                cartid: cartId
            },
            success: function (response) {
                var data = JSON.parse(response);
                localStorage.setItem('notification', data.message);
                window.location.reload(); // Reload to update the cart
            }
        });
    });

    // Check for notification in localStorage after page reload
    window.onload = function () {
        var notificationMessage = localStorage.getItem('notification');
        if (notificationMessage) {
            showNotification(notificationMessage);
            // Clear the notification after displaying
            localStorage.removeItem('notification');
        }
    };

    // Function to show the notification
    function showNotification(message) {
        var notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerText = message;
        document.body.appendChild(notification);

        // Make it disappear after 3 seconds
        setTimeout(function () {
            notification.style.opacity = '0';
            setTimeout(function () {
                notification.remove();
            }, 500); // Remove after the fade-out transition
        }, 1000);
    }
</script>
<style>
    .notification {
        position: fixed;
        top: -100px;
        left: 0;
        width: 100%;
        background-color: rgb(227, 221, 40);
        color: #212529;
        padding: 10px 0;
        text-align: center;
        font-size: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        opacity: 1;
        transition: opacity 0.2s ease;
        font-weight: bold;
        animation: slideDown 0.3s forwards, slideUp 0.3s forwards 5s;
    }

    @keyframes slideDown {
        0% {
            top: -100px;
        }

        100% {
            top: 0;
        }
    }

    @keyframes slideUp {
        0% {
            top: 0;
        }

        100% {
            top: -100px;
        }
    }
</style>
<?php require("footer.php"); ?>