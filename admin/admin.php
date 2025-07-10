<?php
session_start();
require_once '../connect.php';

// Проверяем, были ли данные отправлены методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, есть ли в массиве $_POST нужные данные
    if (isset($_POST['login']) && isset($_POST['password'])) {
        // Получаем значения логина и пароля из $_POST
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Запрос к базе данных для проверки пользователя с ролью администратора
        $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `password` = '$password' AND `login` = '$login' AND `roles_id` = 3");
        
        // Проверяем, найден ли пользователь с указанными данными
        if (mysqli_num_rows($check_user) > 0) {
            $users = mysqli_fetch_assoc($check_user);
            $_SESSION['users'] = [
                "id" => $users['id'],
                "full_name" => $users['full_name']
            ];
            // Перенаправляем пользователя на административную панель
            header('Location: face2.php');
            exit;
        } else {
            // Если пользователь с указанными данными не найден, перенаправляем на страницу авторизации
            header('Location: auth.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Администрирование</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
</html>

<!-- Ваш HTML-код здесь -->


<h3 class="p-2 text-dark text-decoration-none">Отказано</h3>
<a href="/" class="btn btn-primary">На главную</a>
