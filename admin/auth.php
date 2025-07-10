<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Администрирование</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<form action="admin.php" method="post">
    <label>Логин</label>
    <input type="text" name="login" placeholder="Введите свой логин" required>
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введите пароль" required>
    <p>
            Есть аккаунт? - <a href="../index.php">Войдите!</a>
        </p>
    <button type="submit">Войти</button>
</form>
</body>
</html>
