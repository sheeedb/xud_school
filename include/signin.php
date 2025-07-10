<?php
session_start();
require_once '../connect.php';

$login = $_POST['login'];
$password = ($_POST['password']);

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `password` = '$password' AND `login` = '$login' ");
if (mysqli_num_rows($check_user) > 0) {

    $user_data = mysqli_fetch_assoc($check_user);

    // Сохраняем данные пользователя в сессии
    $_SESSION['users'] = [
        "id" => $user_data['id'],
        "full_name" => $user_data['full_name'],
        "roles_id" => $user_data['roles_id']
    ];

    // Проверяем roles_id и перенаправляем пользователя на соответствующую страницу
    switch ($user_data['roles_id']) {
        case 1:
            // Если роль ученика, перенаправляем на страницу личного кабинета ученика
            header('Location: ../lk_student/lk_face.php');
            break;
        case 2:
            // Если роль преподавателя, перенаправляем на страницу личного кабинета преподавателя
            header('Location: ../lk_teacher.php');
            break;
        default:
            // Если roles_id не соответствует ни одной из ролей, перенаправляем на стандартную страницу
            header('Location: ../index.php');
            break;
    }

} else {
    // Если пользователя с такими данными не найдено, перенаправляем на страницу входа
    header('Location: ../index.php');
}
?>
