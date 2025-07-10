<?php
session_start();
require 'connect.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $result = mysqli_query($connect , "SELECT count(*) as `a` FROM `users`");
        $result = mysqli_fetch_assoc($result);
        echo $result['a'];
        $f = $result['a'];
        mysqli_query($connect, "DELETE FROM `users` where full_name = 'Кутузов Андрей Михайлович'");
?><br>

<?php
        $result = mysqli_query($connect , "SELECT count(*) as `a` FROM `users`");
        $result = mysqli_fetch_assoc($result);
        echo $result['a'];
        $s = $result['a']; ?>
        <br>
        <?php
        if($f != $s){
            echo 'Тест выполнен неуспешно';
        }else{
            echo 'Тест выполнен успешно';
        }
    ?>
</body>
</html>
