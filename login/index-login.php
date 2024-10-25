<?php
$open_connect = 1;
require('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="https://png.pngtree.com/element_our/png/20181227/movie-icon-which-is-designed-for-all-application-purpose-new-png_287896.jpg?v=6">
</head>
<body>
<form class="container" action="processlogin.php" method="POST">
    <h2>Login</h2>
    <input class="textbox" name="username_account" type="text" placeholder="Username">
    <input class="textbox" name="password_account" type="password" placeholder="Password" required> <!-- เพิ่ม name="password" -->
    <input class="btn-submit" type="submit" value="Login"> <!-- แก้ไขการใช้เครื่องหมายคำพูด -->
</form>
</body>
</html>
