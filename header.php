<?php
require('connection.php');

// Default values for a guest user
$name = "Guest";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Use session user_id or 0 for guest

// Check if email is provided in the session
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    // Use secure query to fetch user data
    $query = "SELECT * FROM user_tim WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and fetch user data
    if ($result) {
        $rows = mysqli_fetch_array($result);
        if ($rows) {
            $_SESSION['user_id'] = $rows['id']; // Store user ID in session
            $user_id = $_SESSION['user_id'];    // Set the user ID
            $name = $rows["name"];              // Fetch user name
            $email = $rows["email"];            // Fetch user email
            $formal_name = ucwords(strtolower($name)); // Format the user's name
        } else {
            // If user not found, treat as guest
            $formal_name = "Guest";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    // If no email in session, treat as guest
    $formal_name = "Guest";  // Default guest name
}

// Handle cart count
$num_items = 0;

// Modify cart query to consider guest user ID or logged-in user ID
$cart_count_query = "SELECT SUM(quantity) as total_items FROM cart_tim WHERE user_id = $user_id";
$cart_result = mysqli_query($conn, $cart_count_query);

if ($cart_result) {
    // Fetch the result as an associative array
    $cart_result_data = mysqli_fetch_assoc($cart_result);
    if ($cart_result_data && isset($cart_result_data['total_items'])) {
        $num_items = $cart_result_data['total_items']; // Get the total items in the cart
    }
    mysqli_free_result($cart_result); // Free the result to free memory
} else {
    // Handle the case where the cart query fails
    echo "Error fetching cart count: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link rel="stylesheet" href="bootstrap.css">
    <script defer src="bootstrap.bundle.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color:#efeded">
    <nav style="background-color:#212529" class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid my-2">
            <a class="navbar-brand text-light" href="index.php"><?php echo "Welcome " . $formal_name; ?></a>
            <button class="navbar-toggler btn-outline-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active zoom text-light" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link zoom text-light" href="cart.php">Cart
                            <sup>
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span class="cart-count" id="cart-count"><?= ($num_items > 0) ? $num_items : 0 ?></span>
                            </sup>
                        </a>
                    </li>
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 0) {
                        echo '<li class="nav-item"><a class="nav-link zoom text-light" href="logout.php">Sign out</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link zoom text-light" href="login.php">Sign in</a></li>';
                    }
                    ?>
                </ul>

                <form class="d-flex w-50" action="#" method="post">
                    <input class="form-control me-2 search-bar" name="search_data" type="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-search" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>