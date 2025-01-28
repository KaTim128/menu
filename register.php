<?php
require('connection.php');

if (isset($_POST['user_register'])) {
    $nm = $_POST['nm'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $rpwd = $_POST['rpwd'];

    if ($pwd !== $rpwd) {
        echo "<script>
                alert('Ouch wrong repeated password!');
                window.location.href = 'register.php';
              </script>";
        exit;
    } else {
        $insert_query = "INSERT INTO `testing_tim` (name,email,password) VALUES ('$nm','$email','$pwd')";
        $result = mysqli_query($conn, $insert_query);

        if ($result) {
            echo "<script>
                alert('Registration Successful!');
                window.location.href = 'login.php';
              </script>";
            exit;

        } else {
            echo "Error: " . mysqli_error($conn);
            exit;
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.css">
    <script src="bootstrap.bundle.js"></script>
    <style>
        * {
            box-sizing: border-box
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
        }

        /* Full-width input fields */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Overwrite default styles of hr */
        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        /* Set a style for the submit/register button */
        .registerbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }

        .registerbtn:hover {
            opacity: 1;
        }

        /* Add a blue text color to links */
        a {
            color: dodgerblue;
        }

        /* Set a grey background color and center the text of the "sign in" section */
        .signin {
            background-color: #f1f1f1;
            text-align: center;
        }
    </style>
</head>

<body>
    <form method="post">
        <div class="container">
            <h1 class="text-success text-center mt-5">Register</h1>
            <hr>
            <label for="nm"><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="nm" id="nm" required>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" id="pwd" required>

            <label for="rpwd"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="rpwd" id="rpwd" required>
            <hr>

            <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
            <div class="d-flex justify-content-center">
                <button type="submit" class="registerbtn" style="width:50%;" name="user_register">Register</button>
            </div>
        </div>

        <div class="container signin">
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </div>
    </form>
</body>

</html>