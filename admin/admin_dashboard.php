<?php
require("admin_panel.php");


$select_query = "SELECT * FROM product_tim";
$result_query = mysqli_query($conn, $select_query);
$total_rows = mysqli_num_rows($result_query);
?>

<div class="col-md-10">
    <div class="m-5">
        <p>
        <h1><b class="mb-5">Total Number of Products: <?= $total_rows ?></b></h1>
        </p>
        <p>
        <h1><b class="mb-5">Total Number of Orders: <?= 0 ?></b></h1>
        </p>
        <p>
        <h1><b class="mb-5">Total Number of Users: <?= 0 ?></b></h1>
        </p>
    </div>
</div>

</body>

</html>