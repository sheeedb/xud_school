<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<form action="include/signin.php" method="post">
    <label>Логин</label>
    <input type="text" name="login" placeholder="Введите свой логин" required>
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введите пароль" required>
    <button type="submit">Войти</button> <br>

    <p>
        <a href="/admin/auth.php">Войти Администратором</a>
    </p>
</form>
</body>
</html>


