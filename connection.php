<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'menu_db';
session_start();

// Create connection (without specifying database)
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

// Check connection
if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

// Create the database 'bookstore_db' if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
$result = mysqli_query($conn, $sql_create_db);

if (!$result) {
    die("Error creating database: " . mysqli_error($conn));
}

// Close the connection without selecting database
mysqli_close($conn);

// Reconnect to MySQL with the specified database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection again
if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

// Create the database 'bookstore_db' if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
$result = mysqli_query($conn, $sql_create_db);

if (!$result) {
    die("Error creating database: " . mysqli_error($conn));
}
mysqli_close($conn);

// Reconnect to MySQL with the specified database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die('Could not connect to MySQL: ' . mysqli_connect_error());
}

$sql_cart = "CREATE TABLE IF NOT EXISTS cart_tim (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    name TEXT  NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT(10) NOT NULL,
    image TEXT NOT NULL
)";

$retval = mysqli_query($conn, $sql_cart);
if (!$retval) {
    die('Could not create table cart_tim: ' . mysqli_error($conn));
}


$sql_users = "CREATE TABLE IF NOT EXISTS user_tim (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL
)";

$retval = mysqli_query($conn, $sql_users);
if (!$retval) {
    die('Could not create table user_tim: ' . mysqli_error($conn));
}

$sql_products = "CREATE TABLE IF NOT EXISTS product_tim (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name TEXT NOT NULL,
    img TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT NULL,
    category TEXT NOT NULL
)";

$retval = mysqli_query($conn, $sql_products);
if (!$retval) {
    die('Could not create table product_tim: ' . mysqli_error($conn));
}

$sql_category = 'CREATE TABLE IF NOT EXISTS category_tim (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_title VARCHAR(50) NOT NULL
)';

$retval = mysqli_query($conn, $sql_category);
if (!$retval) {
    die('Could not create table category: ' . mysqli_error($conn));
}
?>