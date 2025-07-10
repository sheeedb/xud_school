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
    <title>Мона Лиза</title>
</head>
<body>
<?php require "../blocks/lk_header2.php" ;
require "../connect.php";
$result = mysqli_query($connect, "SELECT * FROM `posts`");
$posts = mysqli_fetch_assoc($result);
?>
<center>
<div class="container mt-5 ">
    <h3 class="mb-5"><?php echo $posts['name'] ?></h3>
    <div class="d-flex flex-wrap">
</center>
        <center>
            <link rel="stylesheet" href="../css/style.css">
            
                <img src="../img/1.jpg" alt="Задана ширина и высота" width="500" height="700"> <br> <br> 

            </link>
        
            <div class="card mb-4 rounded-3 shadow-sm" style = 'width: 1200px'>
                <div class="card-header py-3">
        <?php echo $posts['decription'] ?>
                </div>
            </div>
        </center>
    </div>
    <?php require "../blocks/footer.php" ?>
</body>
</html>
