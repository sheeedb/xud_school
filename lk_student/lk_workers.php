<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Персонал</title>
</head>
<body>
<?php require "../blocks/lk_header2.php";?>
<div class="container mt-5 ">
    <h3 class="mb-5">Наш персонал</h3>
    <div class="d-flex flex-wrap">

<?php 
require "../connect.php";
$a = mysqli_query($connect, "SELECT users.full_name as full_name, users.phone AS phone, roles.name as name FROM users INNER JOIN roles ON users.roles_id = roles.id where roles.id = 3");
$users = mysqli_fetch_all($a);
foreach ($a as $user)
{
?>

<div class="card mb-4 rounded-3 shadow-sm">
    <div class="card-header py-3">
        <h4 class="my-0 fw-normal"><?php echo $user['name'] ?></h4>
    </div>
    <div class="card-body">
        <img src="../img/ava.png" class="img-thumbnail" alt="">
        <ul class="list-unstyled mt-3 mb-4">
            <?php
            ?>
            <center>
                <li><?php echo $user['full_name']?></li>
                <li><?php echo $user['name']?></li>
                <li>Телефон для связи</li>
                <li><strong><?php echo $user['phone']?></strong></li>
            </center>
        </ul>
    </div>
    </div>
<?php
}

$a = mysqli_query($connect, "SELECT users.full_name as full_name, users.phone AS phone, roles.name as name FROM users INNER JOIN roles ON users.roles_id = roles.id where roles.id = 2");
$users = mysqli_fetch_all($a);
foreach ($a as $user)
{
?>

<div class="card mb-4 rounded-3 shadow-sm">
    <div class="card-header py-3">
        <h4 class="my-0 fw-normal"><?php echo $user['name'] ?></h4>
    </div>
    <div class="card-body">
        <img src="../img/ava.png" class="img-thumbnail" alt="">
        <ul class="list-unstyled mt-3 mb-4">
            <?php
            ?>
            <center>
                <li><?php echo $user['full_name']?></li>
                <li><?php echo $user['name']?></li>
                <li>Телефон для связи</li>
                <li><strong><?php echo $user['phone']?></strong></li>
            </center>
        </ul>
    </div>
    </div>
<?php
}
?>
<?php require "../blocks/footer.php" ?>
</body>
</html>