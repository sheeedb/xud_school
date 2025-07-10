<?php
session_start();
require_once '../connect.php';

// Определяем запрос на поиск или обновление страницы
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT users.*, roles.name AS role_name FROM `users` INNER JOIN `roles` ON users.roles_id = roles.id 
    WHERE full_name LIKE '%$search%' OR login LIKE '%$search%' OR phone LIKE '%$search%' OR roles.name LIKE '%$search%'";
} else {
    $query = "SELECT users.*, roles.name AS role_name FROM `users` INNER JOIN `roles` ON users.roles_id = roles.id";
}

$result = mysqli_query($connect, $query);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Администрирование</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .btn-outline-secondary {
            border-color: #007bff;
            color: #007bff;
        }

        .btn-outline-secondary:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
<?php if(!empty($_SESSION['users']['full_name'])):?>
    <?php require "../blocks/admin_header.php" ?>

    <div class="container mt-5">
        <a href="register.php" class="btn btn-primary mb-3">Зарегистрировать пользователя</a>
        <form action="" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Поиск..." aria-label="Search" aria-describedby="clear-search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Искать</button>
                <button class="btn btn-outline-secondary" type="button" id="clear-search">&times;</button>
            </div>
        </form>
        <table width="1000" class="sold">
            <thead>
            <tr class="td-u">
                <th>№</th>
                <th>ФИО</th>
                <th>Логин</th>
                <th>Пароль</th>
                <th>Телефон</th>
                <th>Роль</th>
                <th class="td-u2">&#9998;</th>
                <th class="td-u2">&#10060;</th>
            </tr>
            </thead>
            <tbody>

            <?php
            while($char = mysqli_fetch_assoc($result)) {
                ?>
                <tr class="td-o">
                    <td><?= $char['id'] ?></td>
                    <td><?= $char['full_name'] ?></td>
                    <td><?= $char['login'] ?></td>
                    <td><?= $char['password'] ?></td>
                    <td><?= $char['phone'] ?></td>
                    <td><?= $char['role_name'] ?></td>
                    <td><a href="update3.php?id=<?= $char['id'] ?>">Редактировать</a></td>
                    <td><a href="delete.php?id=<?= $char['id'] ?>">Удалить</a></td>
                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>
    </div>

    <?php require "../blocks/footer.php" ?>
<?php else:
    echo '<h3 class="p-2 text-dark text-decoration-none">Отказано</h3>';
    echo '<a href="/" class="btn btn-primary" >На главную</a>';
    ?>

<?php endif ?>

<script>
    // Функция для очистки поля ввода поиска и обновления URL страницы
    function clearAndReload() {
        // Очищаем поле ввода поиска
        document.querySelector('input[name="search"]').value = '';
        // Обновляем URL страницы без добавления записи в историю браузера
        history.replaceState(null, null, window.location.pathname);
        // Перезагружаем страницу
        location.reload();
    }

    // Привязываем функцию к событию нажатия на крестик
    document.getElementById('clear-search').addEventListener('click', clearAndReload);
</script>

</body>
</html>
