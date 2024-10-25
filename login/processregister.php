<?php

$open_connect = 1;
require('connect.php');

if (isset($_POST['username_account']) && isset($_POST['password_account1']) && isset($_POST['password_account2'])) {
    // เชื่อมต่อกับฐานข้อมูลก่อนใช้ mysqli_real_escape_string
    if ($connect) {
        $username_account = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['username_account']));
        $password_account1 = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account1']));
        $password_account2 = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password_account2']));
        
        // ตรวจสอบช่องว่างและความตรงกันของรหัสผ่าน
        if (empty($username_account)) {
            header('Location: index-register.php');
            exit();
        } elseif (empty($password_account1)) {
            header('Location: index-register.php');
            exit();
        } elseif (empty($password_account2)) {
            header('Location: index-register.php');
            exit();
        } elseif ($password_account1 != $password_account2) {
            header('Location: index-register.php'); // รหัสผ่านไม่ตรงกัน
            exit();
        } else {
            // ดำเนินการตรวจสอบและสร้างบัญชี
            $query_check_username_account = "SELECT username_account FROM account WHERE username_account = '$username_account'";
            $call_back_query_check_username_account = mysqli_query($connect, $query_check_username_account);
            if (mysqli_num_rows($call_back_query_check_username_account) > 0) {
                header('Location: index-register.php'); // มีผู้ใช้อีเมลนี้แล้ว
                exit();
            } else {
                $length = random_int(97, 128);
                $salt_account = bin2hex(random_bytes($length)); // สร้างเกลือ
                $password_account1 = $password_account1 . $salt_account; // เอารหัสรวมกับเกลือ
                $algo = PASSWORD_ARGON2ID;
                $options = [
                    'cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                    'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                    'threads' => PASSWORD_ARGON2_DEFAULT_THREADS
                ];
                $password_account = password_hash($password_account1, $algo, $options); // เข้ารหัสด้วย ARGON2ID
                $query_create_account = "INSERT INTO account VALUES ('', '$username_account', '$password_account', '$salt_account', 'member', 'default_images_account.jpg', '', '', '')";
                $call_back_create_account = mysqli_query($connect, $query_create_account);
                if ($call_back_create_account) {
                    header('Location: index-login.php'); // สร้างบัญชีสำเร็จ
                    exit();
                } else {
                    header('Location: index-register.php'); // สร้างบัญชีไม่สำเร็จ
                    exit();
                }
            }
        }
    } else {
        echo "การเชื่อมต่อกับฐานข้อมูลล้มเหลว";
    }
} else {
    header('Location: index-register.php'); // ไม่มีข้อมูล
    exit();
}
?>
