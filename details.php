<?php
require("header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addtocart'])) {
    $product_id = intval($_POST['addtocart']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);

    // Check if the product is already in the cart
    $check_cart_query = "SELECT * FROM cart_tim WHERE product_id = $product_id AND user_id = $user_id";
    $check_cart_result = mysqli_query($conn, $check_cart_query);

    if (mysqli_num_rows($check_cart_result) == 0) {
        $insert_cart_query = "INSERT INTO cart_tim (user_id, product_id, name, price, quantity, image) VALUES ($user_id, $product_id, '$product_name', $product_price, 1, '$product_image')";
        mysqli_query($conn, $insert_cart_query);
    }
    exit;
}

$quantity = 1;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $product_query = mysqli_query($conn, "SELECT * FROM product_tim WHERE id = $id");
    $row = mysqli_fetch_assoc($product_query);
    $product_id = $row['id'];
    $product_name = $row['name'];
    $product_image = htmlspecialchars($row['img']);
    $product_price = $row['price'];
    $product_description = $row['description'];
    $product_category = $row['category'];

    // Fetch cart details
    $cart_query = mysqli_query($conn, "SELECT product_id FROM cart_tim WHERE product_id = $product_id AND user_id = $user_id");
    $incart_result = mysqli_fetch_assoc($cart_query);
}
?>
<div class="container-fluid p-0">
    <div class="row flex-wrap gx-0">
        <?php require "sidebar.php" ?>
        <div class="col-md-10 p-4">
            <div class="container mb-5 p-2">
                <div class="row mt-5">
                    <div class="col-md-6 p-4" style="display: flex; justify-content: center; align-items: center;">
                        <img src="images/<?= $product_image ?>" class="shadow-sm card zoom product-image">
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-4"><b><?php echo $product_name; ?></b></h3>
                        <p><b>Price:</b> RM<?php echo $product_price; ?></p>
                        <p><b>Description:</b> <?php echo " $product_description"; ?></p>
                        <form method="post" action="details.php?id=<?= $product_id ?>">
                            <div class="row gap-2">
                                <li><b>Product ID:</b> <?php echo $product_id; ?></li>
                                <li><b>Category:</b> <?php echo $product_category; ?></li>
                                <button type="button" class="btn btn-yellow col-md-6 zoom-in mt-2" id="addtocart"
                                    onclick="addToCart(<?= $product_id ?>, '<?= $product_name ?>', <?= $product_price ?>, '<?= $product_image ?>')"
                                    <?= isset($incart_result['product_id']) ? 'disabled' : '' ?>>
                                    <?= isset($incart_result['product_id']) ? 'In Cart' : 'Add to Cart' ?>
                                </button>
                                <button type="button" class="btn btn-yellow col-md-6 zoom-in mt-2"
                                    onclick="window.location.href='cart.php'">Head to Cart</button>
                                <button type="button" class="btn btn-yellow col-md-6 zoom-in mt-2"
                                    onclick="window.location.href='index.php'">Back</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart(productId, productName, productPrice, productImage) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'details.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            const data = `addtocart=${productId}&product_name=${encodeURIComponent(productName)}&product_price=${productPrice}&product_image=${encodeURIComponent(productImage)}`;

            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Store notification in localStorage
                    localStorage.setItem('notification', 'Product added to cart!');
                } else {
                    // Store error message in localStorage
                    localStorage.setItem('notification', 'Error adding product to cart!');
                }
                // Reload the page after storing the message
                location.reload();
            };
            xhr.send(data);
        }

        // Show the notification after the page reloads
        window.onload = function () {
            const notificationMessage = localStorage.getItem('notification');
            if (notificationMessage) {
                showNotification(notificationMessage);
                localStorage.removeItem('notification');  // Remove notification from localStorage after showing it
            }
        };

        // Function to show the notification message on the page
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerText = message;
            document.body.appendChild(notification);

            // Fade out and remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);  // Remove notification after fading out
            }, 3000);  // Keep notification visible for 3 seconds
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
</div>
<?php require "footer.php"; ?>