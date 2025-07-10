<?php require '../connect.php'?>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h4 class="my-0 mr-md-auto font-weight-normal text-dark">Художественная школа №14</h4>
    <link rel="stylesheet" href="../css/qeq.css">
    
    <div class="button-container">
        <a class="button1" href="../face.php">Статьи</a>
        <a class="button1" href="../schedule.php">Расписание</a>
        <a class="button1" href="../workers.php">Персонал</a>
</div>
    <a style="margin: 2px 10px;margin-left: 500px;" href="lk.php" class="button"><?= $_SESSION['users']['full_name'] ?></a>
    
    <a class="btn btn-outline-primary" href="../include/logout.php">Выйти</a>
</div>  