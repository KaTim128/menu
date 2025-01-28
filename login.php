<?php
require('connection.php');

if (isset($_POST["user_login"])) {

    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    // Secure query to fetch user data
    $query = "SELECT * FROM user_tim WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $q = mysqli_fetch_assoc($result);

    // // Check if password matches
    // if ($pwd == $q["password"]) {
    //     // Store user data in session
    //     $_SESSION["email"] = $q["email"];
    //     header("Location: index.php");
    //     exit;
    // } else {
    //     echo "Error: " . mysqli_error($conn);
    // }

    if ($pwd == $q["password"]) {
        // Store user data in session
        $_SESSION["email"] = $q["email"];
        $_SESSION["user_id"] = $q["id"];
        $logged_in_user_id = $_SESSION["user_id"];

        // Step 1: Fetch all items from the guest cart
        $guest_cart_query = "SELECT * FROM cart_tim WHERE user_id = 0";
        $guest_cart_result = mysqli_query($conn, $guest_cart_query);

        while ($guest_item = mysqli_fetch_assoc($guest_cart_result)) {
            $product_id = $guest_item["product_id"];
            $quantity = $guest_item["quantity"];

            // Step 2: Check if the item already exists in the logged-in user's cart
            $check_existing_query = "SELECT * FROM cart_tim WHERE user_id = $logged_in_user_id AND product_id = $product_id";
            $check_existing_result = mysqli_query($conn, $check_existing_query);

            if (mysqli_num_rows($check_existing_result) > 0) {
                // Item already exists, so update the quantity
                $update_query = "UPDATE cart_tim SET quantity = quantity + $quantity WHERE user_id = $logged_in_user_id AND product_id = $product_id";
                mysqli_query($conn, $update_query);
            } else {
                // Item does not exist, so insert it into the user's cart
                $insert_query = "INSERT INTO cart_tim (user_id, product_id, quantity) VALUES ($logged_in_user_id, $product_id, $quantity)";
                mysqli_query($conn, $insert_query);
            }
        }

        // Step 3: Clear the guest cart
        $clear_guest_cart_query = "DELETE FROM cart_tim WHERE user_id = 0";
        mysqli_query($conn, $clear_guest_cart_query);

        header("Location: index.php");
        exit;
    } else {
        echo "Error: Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <title>Bootstrap Form</title>
    <link rel="stylesheet" href="bootstrap.css">
    <script src="bootstrap.bundle.js"></script>
</head>

<body>
    <h1 class="text-success text-center mt-5">Timmy Turner</h1>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="registrationForm" method="post" action="login.php">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                    required />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="pwd" id="password"
                                    placeholder="Password" required />
                            </div>
                            <button type="submit" class="btn btn-success" name="user_login">Login</button>
                        </form>
                        <p class="mt-3">
                            Not registered?<a href="register.php"> Create an account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>