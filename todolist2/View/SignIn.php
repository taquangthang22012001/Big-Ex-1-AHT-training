<?php
use TODOLIST\todolist1\User;
require __DIR__ . '/../Model/User.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    form {
        width: 200px;
        display: flex;
        margin: auto;
        flex-direction: column;
    }
</style>

<body>
    <form action="" method="POST">
        <h1>Đăng ký</h1>
        <div class="">
            <label for="userName">Tài Khoản</label>
            <input type="text" name="userName">
        </div>
        <div class="">
            <label for="pass">Mật khẩu</label>
            <input type="password" name="pass">
        </div>
        <div class="">
            <input type="submit" value="Đăng ký">
            <a href="Login.php">Đăng Nhập tại đây</a>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($_POST['userName']) || empty($_POST['pass'])) {
                echo "<p> Vui lòng nhập tài khoản và mật khẩu </p>";
            } else {
                $userName = trim($_POST["userName"]);
                $pass = trim($_POST["pass"]);
                $curentUser = new User($userName, $pass);
                echo  $curentUser->signIn();
            }
        } ?>
    </form>

</body>

</html>
