<?php require "connection.php"; 

$values = $_POST["values"];
$user_id = $_SESSION["user_id"];
$q = array("message" => "Cart Updated!");

foreach ($values as $cartId => $quantity) {
    $product_query = "SELECT price FROM product_tim WHERE id = (SELECT product_id FROM cart_tim WHERE id = $cartId)";
    $result = mysqli_query($conn, $product_query);
    $rows = mysqli_fetch_assoc($result);
    $productPrice = $rows['price'];
    $newPrice = $productPrice * $quantity;

    $update_query = "UPDATE cart_tim SET quantity = $quantity, price = $newPrice WHERE id = $cartId AND user_id = " . $user_id;
    $update_result = mysqli_query($conn, $update_query);
}

echo json_encode($q);
?>
