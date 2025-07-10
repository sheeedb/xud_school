<?php
session_start();
require_once '../connect.php';

// Обработка нажатия кнопки "Обновить дату"
if (isset($_POST['update_date'])) {
    // Получаем текущую дату
    $currentDate = date("Y-m-d");
    
    // Проверяем, если текущая дата - воскресенье
    if (date("N", strtotime($currentDate)) == 7) {
        // Если текущая дата - воскресенье, вычисляем следующий день
        $nextDay = date("Y-m-d", strtotime($currentDate . "+1 day"));
        // Обновляем дату в таблице lesson_date
        $updateDateQuery = mysqli_query($connect, "UPDATE lesson_date SET date = '$nextDay'");
    } else {
        // Если текущая дата - не воскресенье, обновляем дату на текущую
        $updateDateQuery = mysqli_query($connect, "UPDATE lesson_date SET date = CURRENT_DATE");
    }
    
    if ($updateDateQuery) {
        // Если обновление прошло успешно, перенаправляем пользователя на эту же страницу, чтобы избежать повторной отправки формы
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        // Если произошла ошибка при обновлении, выводим сообщение
        echo "Ошибка при обновлении даты";
    }
}

// Выбор даты из таблицы lesson_date
$dateQuery = mysqli_query($connect, "SELECT date FROM lesson_date LIMIT 1");
$row = mysqli_fetch_assoc($dateQuery);
$lessonDate = $row['date'];

// Преобразование даты в формат "дд.мм.гггг"
$lessonDateFormatted = date("d.m.Y", strtotime($lessonDate));

// Запрос на получение расписания из таблицы schedule
$result = mysqli_query($connect, "SELECT schedule.id, subjects.name, users.full_name AS teacher_name, 
                                  SUBSTRING(schedule.time_start, 1, 5) AS time_start, 
                                  SUBSTRING(schedule.time_end, 1, 5) AS time_end
                                  FROM schedule 
                                  INNER JOIN subjects ON schedule.subject_id = subjects.id 
                                  INNER JOIN users ON schedule.teacher_id = users.id
                                  ORDER BY schedule.time_start");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Расписание</title>
</head>
<body>
<?php if(!empty($_SESSION['users']['full_name'])):?>
    <?php require "../blocks/admin_header.php" ?>

    <div class="container mt-5">
        <!-- Вывод даты и кнопки "Обновить дату" -->
        <div class="mb-3 d-flex align-items-center">
            <h3 class="me-2">Дата: <?= $lessonDateFormatted ?></h3>
            <form method="post" class="d-inline">
                <button type="submit" name="update_date" class="btn btn-primary">Обновить дату</button>
            </form>
        </div>

        <!-- Таблица для вывода данных из таблицы schedule -->
        <table width="1000" class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Название предмета</th>
                    <th>Преподаватель</th>
                    <th>Время начала</th>
                    <th>Время окончания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>"; // ID
                    echo "<td>" . $row['name'] . "</td>"; // Имя предмета
                    echo "<td>" . $row['teacher_name'] . "</td>"; // Имя преподавателя
                    echo "<td>" . $row['time_start'] . "</td>";
                    echo "<td>" . $row['time_end'] . "</td>";
                    echo "<td><a href='update2.php?id=" . $row['id'] . "'>Изменить</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php require "../blocks/footer.php" ?>
<?php else:
    echo '<h3 class="p-2 text-dark text-decoration-none">Отказано</h3>';
    echo '<a href="/" class="btn btn-primary">На главную</a>';
    ?>
<?php endif ?>

</body>
</html>
