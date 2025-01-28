<?php require "connection.php" ?>
<?php
$cid = $_POST["cartid"];
$user_id = $_SESSION["user_id"];
$q = array("message" => "Item removed!");

$remove_query = "DELETE FROM cart_tim WHERE id = $cid AND user_id = " . $user_id;
$remove_result = mysqli_query($conn, $remove_query);

echo json_encode($q);
?>