<?php

session_start();
require_once '../connect.php';


$full_name = $_POST['full_name'];
$login = $_POST['login'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$password_confirm = $_POST['password_confirm'];


if ($password === $password_confirm) {

    $password = md5($password);
    mysqli_query($connect, "INSERT INTO `users` (`id`, `full_name`, `login`, `password`, `phone`, `roles_id`) VALUES (NULL, '$full_name', '$login', '$password', '$phone', '1')");
   
    $_SESSION['message'] = 'Регистрация прошла успешно!';
    header('Location: ../index.php');


} else {
    $_SESSION['message'] = 'Пароли не совпадают';
    header('Location: ../register.php');
}

?>

