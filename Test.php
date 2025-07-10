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
        $password = md5(676767);
        mysqli_query($connect, "INSERT INTO `users` (`id`, `full_name`, `login`, `password`, `phone`, `roles_id`) 
        VALUES (NULL, 'Кутузов Андрей Михайлович', '6767677', '$password', '45645645644', '1')");
?><br>

<?php
        $result = mysqli_query($connect , "SELECT count(*) as `a` FROM `users`");
        $result = mysqli_fetch_assoc($result);
        echo $result['a'];
        $s = $result['a']; ?>
        <br>
        <?php
        if($f == ($s-1)){
            echo 'Тест выполнен неуспешно';
        }else{
            echo 'Тест выполнен успешно';
        }
    ?>
</body>
</html>
