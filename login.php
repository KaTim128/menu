<?php
require('connection.php');

// Start session

if (isset($_POST["user_login"]) && $_POST["user_login"] == 1) {

    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    // Secure query to fetch user data
    $query = "SELECT * FROM user_tim WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $q = mysqli_fetch_assoc($result);

    // Check if password matches
    if ($pwd == $q["password"]) {
        // Store user data in session
        $_SESSION["email"] = $q["email"];
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
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
                            <button type="submit" class="btn btn-success" name="user_login" value="1">Login</button>
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