<?php
session_start();
require 'connect.php'; // Убедитесь, что вы подключаете к базе данных

// Обработка нажатия кнопки "Очистить все уведомления"
if (isset($_POST['clear_notifications'])) {
    $student_id = $_SESSION['users']['id'];
    // Запрос к базе данных для удаления всех уведомлений для текущего пользователя
    $query_clear_notifications = "DELETE FROM notifications WHERE user_id = '$student_id'";
    $result_clear_notifications = mysqli_query($connect, $query_clear_notifications);
    if ($result_clear_notifications) {
        // Если удаление прошло успешно, перезагружаем страницу
        header("Refresh:0");
        exit(); // Завершаем выполнение скрипта, чтобы предотвратить дальнейший вывод
    } else {
        // Если произошла ошибка при удалении, выводим сообщение об ошибке
        echo "<script>alert('Ошибка при очистке уведомлений');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .notification-list {
            margin-top: 20px;
        }

        .notification-list .alert {
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            max-width: 600px; /* Устанавливаем максимальную ширину для уведомлений */
            margin-left: auto; /* Выравниваем уведомления по центру */
            margin-right: auto;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .alert-secondary {
            background-color: #e2e3e5;
            border-color: #d6d8db;
            color: #383d41;
        }

        .btn-back {
            margin-top: 20px;
            border: 1px solid #007bff; /* Синяя обводка */
            background-color: transparent;
            color: #007bff;
            transition: border-color 0.3s ease; /* Плавное изменение цвета обводки */
        }

        .btn-back:hover {
            border-color: #007bff; /* Изменение цвета обводки при наведении */
            background-color: #007bff;
            color: #fff;
        }

        /* Новое правило CSS для размещения кнопок */
        .button-container {
            display: flex;
            justify-content: center; /* Располагаем кнопки по центру */
            margin-top: 20px;
        }

        .button-container a {
            margin-left: 10px; /* Отступ между кнопками */
        }
    </style>
    <title>Уведомления</title>
</head>
<body>
<?php require "blocks/lk_header.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1>Уведомления</h1>
        </div>
    </div>
</div>
<br>
<div class="notification-list">
    <?php
    // Запрос к базе данных для получения всех уведомлений для текущего пользователя
    $student_id = $_SESSION['users']['id'];
    $query_notifications = "SELECT * FROM notifications WHERE user_id = '$student_id' ORDER BY id"; // Сортировка по id в обратном порядке
    $result_notifications = mysqli_query($connect, $query_notifications);

    // Проверяем, есть ли уведомления
    if (mysqli_num_rows($result_notifications) > 0) {
        // Если есть, выводим их
        while ($notification = mysqli_fetch_assoc($result_notifications)) {
            echo "<div class='alert alert-info'>" . $notification['message'] . "</div>";
        }
    } else {
        // Если уведомлений нет, выводим соответствующее сообщение
        echo "<div class='alert alert-secondary'>Нет новых уведомлений</div>";
    }
    ?>
</div>

<!-- Кнопка "Очистить все уведомления" -->
<div class="button-container">
    <form method="post">
        <button type="submit" name="clear_notifications" class="btn btn-primary">Очистить все уведомления</button>
    </form>
</div>

<?php require 'blocks/footer.php'; ?>
</body>
</html>
