<?php
session_start();
require "connect.php";
require "vendor/autoload.php"; // Подключаем библиотеку для работы с Excel

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SESSION['users']['roles_id'] != 2) {
    header('Location: error.php');
    exit;
}

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $query_students = "SELECT * FROM users WHERE roles_id = 1 
    AND (full_name LIKE '%$search%' OR login LIKE '%$search%' OR phone LIKE '%$search%') ORDER BY full_name";
} else {
    $query_students = "SELECT * FROM users WHERE roles_id = 1 ORDER BY full_name";
}

$result_students = mysqli_query($connect, $query_students);

if (!$result_students) {
    die("Ошибка запроса: " . mysqli_error($connect));
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
    <title>Ученики</title>
</head>
<body>
<?php require "blocks/lk_headerteach.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1>Ученики</h1>
            <form class="d-flex" method="GET">
            <input type="text" class="form-control" placeholder="Поиск..." aria-label="Search" aria-describedby="clear-search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-success ms-2" type="submit">Найти</button>
                <button class="btn btn-outline-danger ms-2" type="button" id="clear-search">Очистить</button> <!-- Кнопка для очистки поля поиска -->
            </form>

            <form action="generate_report.php" method="POST">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="month" class="form-label">Выберите месяц:</label>
                        <select name="month" id="month" class="form-select">
                            <?php
                            $start_date = strtotime('September 2023');
                            $end_date = strtotime('May 2024');
                            while ($start_date <= $end_date) {
                                // Получаем название месяца на русском языке
                                $month_name = date('F', $start_date);
                                $month_names_russian = [
                                    'January' => 'Январь',
                                    'February' => 'Февраль',
                                    'March' => 'Март',
                                    'April' => 'Апрель',
                                    'May' => 'Май',
                                    'June' => 'Июнь',
                                    'July' => 'Июль',
                                    'August' => 'Август',
                                    'September' => 'Сентябрь',
                                    'October' => 'Октябрь',
                                    'November' => 'Ноябрь',
                                    'December' => 'Декабрь',
                                ];
                                $month_name_russian = $month_names_russian[$month_name];

                                echo '<option value="' . date('Y-m', $start_date) . '">' . $month_name_russian . ' ' . date('Y', $start_date) . '</option>';
                                $start_date = strtotime("+1 month", $start_date);
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="form-label">Выберите предмет:</label>
                        <select name="subject" id="subject" class="form-select">
                            <?php
                            // Получаем предметы, которые ведет текущий преподаватель
                            $teacher_id = $_SESSION['users']['id'];
                            $query_subjects = "SELECT DISTINCT subjects.id, subjects.name
                                              FROM subjects
                                              INNER JOIN grades ON subjects.id = grades.subject_id
                                              WHERE grades.teacher_id = $teacher_id";
                            $result_subjects = mysqli_query($connect, $query_subjects);

                            if (!$result_subjects) {
                                die("Ошибка запроса: " . mysqli_error($connect));
                            }

                            while ($row = mysqli_fetch_assoc($result_subjects)) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Создать отчёт</button>
            </form>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ФИО ученика</th>
                        <th>Логин ученика</th>
                        <th>Телефон ученика</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result_students)) {
                        echo "<tr>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['login'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'blocks/footer.php'; ?>
</body>
</html>

<script>
    // Закрытие уведомления при нажатии на крестик
    document.querySelectorAll('.btn-close').forEach(function (element) {
        element.addEventListener('click', function () {
            this.closest('.alert').remove(); // Удаление ближайшего родительского элемента с классом "alert"
        });
    });

    // Очистка поля ввода поиска при нажатии на кнопку "Очистить"
    document.getElementById('clear-search').addEventListener('click', function() {
        document.querySelector('input[name="search"]').value = '';
        window.location.href = window.location.pathname; // Обновление страницы
    });
</script>
