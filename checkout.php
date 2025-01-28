<?php
require("connection.php");



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="bootstrap.css">
    <script defer src="bootstrap.bundle.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php if (empty($user_id)) {
        echo "<div class='alert alert-info text-center' role='alert'>
                    You are currently a guest. Please <a href='login.php'>log in</a> to add to cart!
                </div>";
    } else { ?>
        <button onclick="window.location.href='cart.php'"><b>Back</b></button>
        <?php
    }
    ?>
</body>

</html>