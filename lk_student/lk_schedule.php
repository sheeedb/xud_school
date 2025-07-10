<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/rec.css">
    <title>Расписание</title>
</head>
<body>
<?php require "../blocks/lk_header2.php" ?>

<div class="container">
    <h1>
        <?php
        require "../connect.php";

        // Выполняем запрос к базе данных для получения даты расписания
        $dateQuery = mysqli_query($connect, "SELECT date FROM lesson_date LIMIT 1");

        if ($dateQuery && mysqli_num_rows($dateQuery) > 0) {
            $row = mysqli_fetch_assoc($dateQuery);
            $scheduleDate = $row['date'];

            // Проверяем, не пустая ли дата
            if (!empty($scheduleDate)) {
                // Преобразуем дату в формат день-месяц-год
                echo "Расписание занятий на " . date('d.m.Y', strtotime($scheduleDate));
            } else {
                echo "Данные о дате отсутствуют";
            }
        } else {
            echo "Ошибка при выполнении запроса или данные отсутствуют";
        }
        ?>
    </h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Предмет</th>
                <th scope="col">Учитель</th>
                <th scope="col">Время начала</th>
                <th scope="col">Время окончания</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Запрос на расписание для текущего или следующего рабочего дня
            $result = mysqli_query($connect, "SELECT schedule.*, subjects.name AS subject_name, users.full_name AS teacher_name 
                                              FROM `schedule` 
                                              INNER JOIN subjects ON schedule.subject_id = subjects.id 
                                              INNER JOIN users ON schedule.teacher_id = users.id");

            // Проверяем, вернул ли запрос данные
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['subject_name'] . "</td>";
                    echo "<td>" . $row['teacher_name'] . "</td>";
                    echo "<td>" . substr($row['time_start'], 0, -3) . "</td>"; // Обрезаем последние три символа времени (секунды)
                    echo "<td>" . substr($row['time_end'], 0, -3) . "</td>"; // Обрезаем последние три символа времени (секунды)
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Нет данных для отображения</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require "../blocks/footer.php" ?>

</body>
</html>
