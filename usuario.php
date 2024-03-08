<?php
require 'includes/app.php';
$db = conectarDB();

$email = "email@email.com";
$password = "123456";

$password = password_hash($password, PASSWORD_BCRYPT);

var_dump($password);

$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password')";

mysqli_query($db, $query);
