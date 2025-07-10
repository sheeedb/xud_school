<?php
session_start();
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка данных, введенных пользователем
    $full_name = $_POST['full_name'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $roles_id = $_POST['roles_id'];

    // Вставка нового пользователя в базу данных
    $query = "INSERT INTO `users` (full_name, login, password, phone, roles_id) VALUES ('$full_name', '$login', '$password', '$phone', '$roles_id')";
    $result = mysqli_query($connect, $query);

    // Перенаправление на страницу администрирования после регистрации пользователя
    header('Location: face2.php');
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Регистрация пользователя</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php require "../blocks/admin_header.php" ?>

<div class="container mt-5">
    <h2>Регистрация пользователя</h2>
    <form method="post">
        <div class="mb-3">
            <label for="full_name" class="form-label">ФИО</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Логин</label>
            <input type="text" class="form-control" id="login" name="login" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Номер телефона</label>
            <input type="text" class="form-control" id="phone" name="phone" onkeyup="this.value = this.value.replace (/\D/gi, '').replace (/^0+/, '')" maxlength="11" required>
        </div>
        <div class="mb-3">
            <label for="roles_id" class="form-label">Роль</label>
            <select class="form-select" id="roles_id" name="roles_id" required>
                <option value="1">Ученик</option>
                <option value="2">Преподаватель</option>
                <option value="3">Администратор</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрировать</button>
    </form>
</div>

<?php require "../blocks/footer.php" ?>

</body>
</html>
