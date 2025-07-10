<?php
require_once '../connect.php';

if(isset($_GET['id'])) {
    $result_id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT `id`, `name`, `short_description`, `decription` FROM `posts` WHERE `id`='$result_id'";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result);
} else {
    // Обработка случая, когда id не передан
    // Можно перенаправить пользователя на другую страницу или вывести сообщение об ошибке
    exit('ID не передан');
}
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
<form action="../jjj/update.php" method="post">
    <input type="hidden" name="id" value="<?= isset($result['id']) ? $result['id'] : '' ?>">
    <p>Заголовок</p>
    <input type="text" name="name" value="<?= isset($result['name']) ? $result['name'] : '' ?>" required>
    <p>Краткое описание</p>
    <textarea name="short_description"  required><?= isset($result['short_description']) ? $result['short_description'] : '' ?></textarea>
    <p>Описание</p>
    <textarea name="decription" required><?= isset($result['decription']) ? $result['decription'] : '' ?></textarea>
    <button type="submit">Обновить</button>
</form>

</body>
</html>
