<?php
require_once '../connect.php';

$result_id = $_GET['id'];
$result = mysqli_query($connect, "SELECT * FROM `users` WHERE `id`='$result_id'");
$result = mysqli_fetch_assoc($result);
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/rec.css">
    <title>Обновление данных</title>
</head>
<body>

<a href="face2.php">Главная</a>
<hr>

<h2>Обновить данные</h2>
<form action="../jjj/update3.php" method="post">
    <input type="hidden" name="id" value="<?= $result['id'] ?>">
    <p>ФИО</p>
    <input type="text" name="full_name" value="<?= $result['full_name'] ?>" required>
    <p>Логин</p>
    <input type="text" name="login" value="<?= $result['login'] ?>" required>
    <p>Пароль</p>
    <input type="text" name="password" value="<?= $result['password'] ?>" required>
    <p>Телефон</p>
    <input type="text" name="phone" onkeyup="this.value = this.value.replace (/\D/gi, '').replace (/^0+/, '')" maxlength="11" required value="<?= $result['phone'] ?>" required>
    <p>Роль</p>
    <select name="roles_id">
        <option value="1" <?= ($result['roles_id'] == 1) ? 'selected' : '' ?>>Ученик</option>
        <option value="2" <?= ($result['roles_id'] == 2) ? 'selected' : '' ?>>Преподаватель</option>
        <option value="3" <?= ($result['roles_id'] == 3) ? 'selected' : '' ?>>Администратор</option>
    </select>
    <button type="submit">Обновить</button>
</form>

</body>
</html>
