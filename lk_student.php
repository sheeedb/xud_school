<?php
session_start();
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
        .month-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ccc;
            color: black;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        .month-button:hover {
            background-color: #aaa;
        }

        .notification {
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
    <title>Личный кабинет ученика</title>
</head>
<body>
<?php 
require "blocks/lk_header.php";
require "connect.php";
// Получаем текущую дату и переводим её в формат "день-месяц"
$current_date = date("d-m-Y");
// Получаем месяц и год из параметров GET запроса или используем текущую дату
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
// Создаем массив для хранения дат на выбранный месяц, исключая воскресенье
$dates = array();
$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
for ($i = 1; $i <= $days_in_month; $i++) {
    $day = date("Y-m-d", mktime(0, 0, 0, $month, $i, $year));
    if (date("N", strtotime($day)) != 7) { // Проверяем, что день недели не является воскресеньем (7)
        $dates[] = date("d", strtotime($day));
    }
}
// Запрос к базе данных для получения предметов из таблицы subjects
$query_subjects = "SELECT id, name FROM subjects";
$result_subjects = mysqli_query($connect, $query_subjects);
// Проверяем успешность выполнения запроса
if (!$result_subjects) {
    die("Ошибка запроса: " . mysqli_error($connect));
}
// Уведомление о новых оценках
if (!empty($_SESSION['new_grades'])) {
    $last_visit_date = $_SESSION['last_visit_date'];
    echo "<div class='notification'>У вас новая оценка за " . $_SESSION['new_grades'] . " предмет(ов). Последний просмотр: $last_visit_date</div>";
    unset($_SESSION['new_grades']);
}

?>
<!-- Кнопка уведомлений -->
<a href="notifications.php" class="btn btn-primary me-2">
    <i class="bi bi-bell"></i> Уведомления
</a>
<!-- Верстка страницы -->
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Личный кабинет ученика</h1>
            <div id="tableContainer">
                <table class="table">
                    <thead>
                    <tr>
                        <th><strong>Предметы</strong></th>
                        <?php
                        foreach ($dates as $date) {
                            echo "<th><strong>$date</strong></th>";
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    <?php
                    // Выводим список предметов из результата запроса
                    while ($subject_row = mysqli_fetch_assoc($result_subjects)) {
                        echo "<tr>";
                        echo "<td>" . $subject_row['name'] . "</td>";
                        // Выводим оценки для каждой даты
                        foreach ($dates as $date) {
                            $student_id = $_SESSION['users']['id'];
                            $subject_id = $subject_row['id'];
                            $query_grades = "SELECT grade FROM grades WHERE student_id = '$student_id' AND subject_id = '$subject_id' AND date = DATE_FORMAT('$year-$month-$date', '%Y-%m-%d')";
                            $result_grades = mysqli_query($connect, $query_grades);
                            if (!$result_grades) {
                                die("Ошибка запроса: " . mysqli_error($connect));
                            }
                            $grade_row = mysqli_fetch_assoc($result_grades);
                            echo "<td>" . ($grade_row ? intval($grade_row['grade']) : "") . "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div>
                <?php
                // Определяем предыдущий и следующий месяцы
                $prev_month = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
                $next_month = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
                ?>
                <a href="?month=9&year=2023" class="month-button">Сентябрь</a>
                <a href="?month=10&year=2023" class="month-button">Октябрь</a>
                <a href="?month=11&year=2023" class="month-button">Ноябрь</a>
                <a href="?month=12&year=2023" class="month-button">Декабрь</a>
                <a href="?month=1&year=2024" class="month-button">Январь</a>
                <a href="?month=2&year=2024" class="month-button">Февраль</a>
                <a href="?month=3&year=2024" class="month-button">Март</a>
                <a href="?month=4&year=2024" class="month-button">Апрель</a>
                <a href="?month=5&year=2024" class="month-button">Май</a>
            </div>
        </div>
    </div>
</div>
<?php require 'blocks/footer.php'; // Подключаем файл footer.php ?>