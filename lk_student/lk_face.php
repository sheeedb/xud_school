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
    <title>Статьи</title>
</head>
<body>
<?php require "../blocks/lk_header2.php";
require "../connect.php";
$result = mysqli_query($connect, "SELECT * FROM `posts`");
$posts = mysqli_fetch_assoc($result);
?>
<!-- Кнопка уведомлений -->
<a href="../notifications.php" class="btn btn-primary me-2">
    <i class="bi bi-bell"></i> Уведомления
</a>
<div class="container mt-5 ">
    <h3 class="mb-5">Наши статьи</h3>
    <div class="d-flex flex-wrap">
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><strong><?php echo $posts['name'] ?></strong></h4>
            </div>
            <div class="card-body">
                <img src="../img/1.jpg" alt="Задана ширина и высота" width="380" height="530">
                <ul class="list-unstyled mt-3 mb-4">
                <pre><li><?php echo $posts['short_description']?></li><br></pre><br>
                </ul>
                <a class="btn btn-outline-primary" href="../jjj/MonaLisa.php">Подробнее</a>
            </div>
        </div>
        <?php $result = mysqli_query($connect, "SELECT * FROM `posts`");
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        ?>
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><strong><?php echo $posts['name'] ?></strong></h4>
            </div>
            <?php
            $result = mysqli_query($connect, "SELECT * FROM `posts`");
            $teachers = mysqli_fetch_assoc($result);
            $teachers = mysqli_fetch_assoc($result);
            ?>
            <div class="card-body" style = "image-resolution: 300dpi;">
                <img src="../img/2.jpg"  alt="Задана ширина и высота" width="380" height="530">
                <ul class="list-unstyled mt-3 mb-4">
                <pre><li><?php echo $posts['short_description']?></li><br></pre><br>
                </ul>
                <a class="btn btn-outline-primary" href="../jjj/Starry_Night.php">Подробнее</a>
            </div>
        </div>
        <?php $result = mysqli_query($connect, "SELECT * FROM `posts`");
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        ?>
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><strong><?php echo $posts['name'] ?></strong></h4>
            </div>
            <?php
            $result = mysqli_query($connect, "SELECT * FROM `posts`");
            $teachers = mysqli_fetch_assoc($result);
            $teachers = mysqli_fetch_assoc($result);
            ?>
            <div class="card-body" style = "image-resolution: 300dpi;">
                <img src="../img/3.jpg"  alt="Задана ширина и высота" width="380" height="530">
                <ul class="list-unstyled mt-3 mb-4">
                <pre><li><?php echo $posts['short_description']?></li></pre><br>
                    
                </ul>
                <a class="btn btn-outline-primary" href="../jjj/The_Last_Supper.php">Подробнее</a>
            </div>
        </div>
        <?php $result = mysqli_query($connect, "SELECT * FROM `posts`");
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        ?>
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><strong><?php echo $posts['name'] ?></strong></h4>
            </div>
            <?php
            $result = mysqli_query($connect, "SELECT * FROM `posts`");
            $teachers = mysqli_fetch_assoc($result);
            $teachers = mysqli_fetch_assoc($result);
            ?>
            <div class="card-body" style = "image-resolution: 300dpi;">
                <img src="../img/4.jpg"  alt="Задана ширина и высота" width="380" height="530">
                <ul class="list-unstyled mt-3 mb-4">
                <pre><li><?php echo $posts['short_description']?></li></pre><br><br>
                </ul>
                <a class="btn btn-outline-primary" href="../jjj/Two_again.php">Подробнее</a>
            </div>
        </div>
        <?php $result = mysqli_query($connect, "SELECT * FROM `posts`");
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        $posts = mysqli_fetch_assoc($result);
        ?>
        <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h4 class="my-0 fw-normal"><strong><?php echo $posts['name'] ?></strong></h4>
            </div>
            <?php
            $result = mysqli_query($connect, "SELECT * FROM `posts`");
            $teachers = mysqli_fetch_assoc($result);
            $teachers = mysqli_fetch_assoc($result);
            ?>
            <div class="card-body" style = "image-resolution: 300dpi;">
                <img src="../img/5.jpg"  alt="Задана ширина и высота" width="380" height="530">
                <ul class="list-unstyled mt-3 mb-4">
                    <pre><li><?php echo $posts['short_description']?></li></pre><br>
                </ul>
                <a class="btn btn-outline-primary" href="../jjj/The_ninth_shaft.php">Подробнее</a>
            </div>
        </div>
        <?php require "../blocks/footer.php" ?>
</body>
</html>
