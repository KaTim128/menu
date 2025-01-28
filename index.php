<?php
require("header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addtocart'])) {
    $product_id = intval($_POST['addtocart']);


    // Fetch product details from the database
    $product_query = mysqli_query($conn, "SELECT * FROM product_tim WHERE id = $product_id");
    if ($product_query && mysqli_num_rows($product_query) > 0) {
        $row = mysqli_fetch_array($product_query);
        $product_name = mysqli_real_escape_string($conn, $row['name']);
        $product_price = floatval($row['price']);
        $product_image = mysqli_real_escape_string($conn, $row['img']);

        // Check if the product is already in the cart
        $check_cart_query = "SELECT * FROM cart_tim WHERE product_id = $product_id AND user_id = $user_id";
        $check_cart_result = mysqli_query($conn, $check_cart_query);

        if (mysqli_num_rows($check_cart_result) == 0) {
            $insert_cart_query = "INSERT INTO cart_tim (user_id, product_id, name, price, quantity, image) VALUES ($user_id, $product_id, '$product_name', $product_price, 1, '$product_image')";
            mysqli_query($conn, $insert_cart_query);
        }
    }
    exit;
}

$quantity = 1;

?>
test
<div class="container-fluid p-0">
    <div class="row flex-wrap gx-0">
        <?php require "sidebar.php" ?>
        <div class="col-md-10 p-3">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-2 rounded">
                <div class="container-fluid">
                    <button class="navbar-toggler btn btn-outline-dark p-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon-inner"></span>
                        <span>
                            <h5 class="mt-2 cat">Categories</h5>
                        </span> </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-center" href="index.php">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center" href="?category=western">Western</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center" href="?category=japanese">Japanese</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-center" href="?category=chinese">Chinese</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row gx-0 justify-content-start">
                <?php
                $w = " WHERE id > 0";
                $sq = isset($_POST["search_data"]) ? $_POST["search_data"] : ''; // Use an empty string if the key is not set
                if ($sq != "") {
                    $w .= " AND name LIKE '%" . htmlspecialchars($sq) . "%'";
                }

                $sc = isset($_GET["category"]) ? $_GET["category"] : '';
                if ($sc != "") {
                    $w .= " AND category = '" . mysqli_real_escape_string($conn, $sc) . "'";
                }

                $select_query = "SELECT * FROM product_tim" . $w;
                $query_result = mysqli_query($conn, $select_query);
                while ($row = mysqli_fetch_array($query_result)) {
                    $product_name = $row["name"];
                    $product_image = $row["img"];
                    $product_price = $row["price"];
                    $product_id = $row["id"];
                    $product_category = $row["category"];

                    $cart_query = mysqli_query($conn, "SELECT product_id FROM cart_tim WHERE product_id = $product_id AND user_id = $user_id");
                    $incart_result = mysqli_fetch_array($cart_query);
                    ?>
                    <div class="col-6 col-sm-6 col-md-3 mb-3 p-2">
                        <div class="card shadow-sm h-100">
                            <img src="images/<?php echo $product_image; ?>" class="card-img-top"
                                alt="<?php echo $product_name; ?>" style="object-fit: cover; width: 100%;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <p class="card-title text-truncate card-title"><b><?php echo $product_name; ?></b></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text mb-0">Price:
                                        RM<?php echo number_format($product_price, 2); ?></p>
                                </div>
                                <button type="button" class="btn btn-yellow btn-sm px-3 py-2 mt-2"
                                    onclick="addToCart(<?= $row['id'] ?>)" <?= isset($incart_result['product_id']) ? 'disabled' : '' ?>>
                                    <?= isset($incart_result['product_id']) ? 'In Cart' : 'Add to Cart' ?>
                                </button>
                                <button type="button" class="btn btn-yellow btn-sm px-3 py-2 mt-2"
                                    onclick="window.location.href='details.php?id=<?= $row['id'] ?>'">Details</button>

                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(productId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const data = `addtocart=${productId}`;

        xhr.onload = function () {
            if (xhr.status === 200) {
                localStorage.setItem('notification', 'Product added to cart!');
            } else {
                localStorage.setItem('notification', 'Error adding product to cart!');
            }
            location.reload();
        };
        xhr.send(data);
    }

    window.onload = function () {
        const notificationMessage = localStorage.getItem('notification');
        if (notificationMessage) {
            showNotification(notificationMessage);
            localStorage.removeItem('notification');
        }
    };

    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerText = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
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

<?php require "footer.php"; ?>