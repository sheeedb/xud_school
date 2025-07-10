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
    <title>Удаление работника</title>
</head>
<body>

<a href="face2.php">Главная</a>
<hr>

<h2>Удалить работника</h2>
<form action="../jjj/delete.php" method="post">
<input type="hidden" name="id" value="<?= $result['id'] ?>">
    <p>Вы точно хотите удалить работника?</p>
    <button type="submit">Удалить</button>
</form>

</body>
</html>