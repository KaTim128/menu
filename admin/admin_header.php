<?php require('../connection.php') ?>
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
        <!-- Sidebar Panel Section -->
        <div class="sidebar p-4 text-center">
                <img src="../images/default.png" alt=""
                        style="width: 80%; height: 20%; border-radius: 20px; padding:17px;">
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?insertCategory" class="text-dark font-bold">Insert Category</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?insertProduct" class="text-dark font-bold">Insert Product</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?viewCategories" class="text-dark font-bold">View Category</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?ViewProducts" class="text-dark font-bold">All Orders</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?listPayments" class="text-dark font-bold">All Payments</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?listUsers" class="text-dark font-bold">List Users</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="adminPanel.php?listMsgs" class="text-dark font-bold">User Messages</a>
                </button>
                <button class="btn mb-3 zoom">
                        <a href="../index.php" class="text-dark font-bold">Logout</a>
                </button>
        </div>
</body>