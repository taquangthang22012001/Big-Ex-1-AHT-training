<?php
session_start();
use TODOLIST\todolist1\User;
include"../Model/User.php";

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

    <form action="" method="post">
        <h1>Đăng nhập</h1>
        <div class="">
            <label for="userName">Tài Khoản</label>
            <input type="text" name="userName">
        </div>
        <div class="">
            <label for="pass">Mật Khẩu</label>
            <input type="password" name="pass">
        </div>
        <div class="">
            <input type="submit" value="đăng nhập">
            <a href="../View/SignIn.php">Đăng ký tại đây</a>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($_POST['userName']) || empty($_POST['pass'])) {
                echo "<p> Thiếu dữ liệu </p>";
            } else {
                $userName = trim($_POST["userName"]);
                $pass = trim($_POST["pass"]);   
                $curentUser = new User($userName, $pass);

                if ($curentUser->login()) {
                    $_SESSION["userName"] = trim($curentUser->login());
                    header("Location: HomePage.php");
                } else {
                    echo "Đăng nhập thất bại";
                }
            }
        } ?>

    </form>

</body>

</html>