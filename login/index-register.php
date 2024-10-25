<?php
$open_connect = 1;
require('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="https://www.anime-sugoi.com/upload/icon.png?v=6">
</head>
<body>
<form class="container" action="processregister.php" method="POST">
    <h2>Register</h2>
    <input class="textbox" name="username_account" type="text" placeholder="ชื่อผู้ใช้" required>
    <input class="textbox" name="password_account1" type="password" placeholder="รหัสผ่าน" required> <!-- เพิ่ม name="password" -->
    <input class="textbox" name="password_account2" type="password" placeholder="ยืนยันรหัสผ่าน" required> <!-- เพิ่ม name="password" -->
    <input class="btn-submit" type="submit" value="Register"> <!-- แก้ไขการใช้เครื่องหมายคำพูด -->
</form>
</body>
</html>
