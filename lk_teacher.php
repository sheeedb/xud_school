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
    <title>Личный кабинет преподавателя</title>
</head>
<body>
<?php require "blocks/lk_headerteach.php";
require "connect.php";

// Проверяем, является ли текущий пользователь преподавателем (roles_id = 2)
if ($_SESSION['users']['roles_id'] != 2) {
    // Если нет, перенаправляем на страницу с сообщением об ошибке или на главную
    header('Location: index.php');
    exit;
}

// Получаем идентификатор текущего преподавателя
$teacher_id = $_SESSION['users']['id'];

// Запрос к базе данных для получения списка студентов (roles_id = 1)
$query_students = "SELECT * FROM users WHERE roles_id = 1";
$result_students = mysqli_query($connect, $query_students);

// Проверяем успешность выполнения запроса
if (!$result_students) {
    die("Ошибка запроса: " . mysqli_error($connect));
}

// Запрос к базе данных для получения списка предметов, которые преподаватель ведет
$query_subjects = "SELECT DISTINCT subjects.name, users.full_name, users.id AS student_id
                   FROM schedule 
                   INNER JOIN subjects ON schedule.subject_id = subjects.id 
                   INNER JOIN users ON schedule.teacher_id = users.id
                   WHERE schedule.teacher_id = $teacher_id";
$result_subjects = mysqli_query($connect, $query_subjects);

// Проверяем успешность выполнения запроса
if (!$result_subjects) {
    die("Ошибка запроса: " . mysqli_error($connect));
}

// Обработка отправки формы для постановки оценки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_id']) && isset($_POST['subject_name']) && isset($_POST['grade']) && isset($_POST['date'])) {
        $student_id = $_POST['student_id'];
        $subject_name = $_POST['subject_name'];
        $grade = $_POST['grade'];
        $date = $_POST['date'];

        // Проверка на воскресенье
        if (date('N', strtotime($date)) == 7) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Оценка не может быть поставлена за воскресенье.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        // Проверка на будущую дату
        elseif (strtotime($date) > time()) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Оценка не может быть поставлена за будущую дату.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {
            // Получаем идентификатор предмета по его названию
            $query_subject_id = "SELECT id FROM subjects WHERE name = '$subject_name'";
            $result_subject_id = mysqli_query($connect, $query_subject_id);
            if (!$result_subject_id) {
                die("Ошибка запроса: " . mysqli_error($connect));
            }
            $row = mysqli_fetch_assoc($result_subject_id);
            $subject_id = $row['id'];

            // Проверка наличия оценки за указанную дату
            $query_check_grade = "SELECT * FROM grades WHERE student_id = '$student_id' AND teacher_id = '$teacher_id' AND subject_id = '$subject_id' AND date = '$date'";
            $result_check_grade = mysqli_query($connect, $query_check_grade);
            if (!$result_check_grade) {
                die("Ошибка запроса: " . mysqli_error($connect));
            }

            if (mysqli_num_rows($result_check_grade) > 0) {
                // Оценка за указанную дату уже существует, выводим сообщение об ошибке
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Нельзя поставить оценку, так как оценка за это число уже стоит.
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            } else {
                // Записываем оценку в базу данных
                $query_insert_grade = "INSERT INTO grades (student_id, teacher_id, subject_id, grade, date) 
                                   VALUES ('$student_id', '$teacher_id', '$subject_id', '$grade', '$date')";
                $result_insert_grade = mysqli_query($connect, $query_insert_grade);

                // Записываем уведомление
                $notification_message = "У вас новая оценка по предмету $subject_name";
                $notification_created_at = date("Y-m-d"); // Записываем только дату, без времени
                $query_insert_notification = "INSERT INTO notifications (user_id, message, `created_at`) 
                                              VALUES ('$student_id', '$notification_message', '$notification_created_at')";
                $result_insert_notification = mysqli_query($connect, $query_insert_notification);
                if (!$result_insert_notification) {
                    die("Ошибка запроса: " . mysqli_error($connect));
                }
            }
        }
    }
}
// Обработка поискового запроса
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $query_students = "SELECT * FROM users WHERE roles_id = 1 AND (full_name LIKE '%$search%' OR login LIKE '%$search%' OR phone LIKE '%$search%') ORDER BY full_name";
} else {
    // Запрос к базе данных для получения списка учеников (roles_id = 1), отсортированных по алфавиту ФИО
    $query_students = "SELECT * FROM users WHERE roles_id = 1 ORDER BY full_name";
}

$result_students = mysqli_query($connect, $query_students);

// Проверяем успешность выполнения запроса
if (!$result_students) {
    die("Ошибка запроса: " . mysqli_error($connect));
}
?>

<!-- Верстка страницы -->
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Личный кабинет преподавателя</h1>
            <form class="d-flex" method="GET">
                <input type="text" class="form-control" placeholder="Поиск..." aria-label="Search" aria-describedby="clear-search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-success ms-2" type="submit">Найти</button>
                <button class="btn btn-outline-danger ms-2" type="button" id="clear-search">Очистить</button> <!-- Кнопка для очистки поля поиска -->
            </form>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>ФИО ученика</th>
                        <th>Предмет</th>
                        <th>Дата</th>
                        <th>Поставить оценку</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Выводим список учеников и форму для выбора предмета и постановки оценки
                    while ($row = mysqli_fetch_assoc($result_students)) {
                        echo "<tr>";
                        echo "<td>" . $row['full_name'] . "</td>";

                        // Выводим список предметов из результата запроса
                        echo "<td>";
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='student_id' value='" . $row['id'] . "'>";
                        echo "<select name='subject_name'>";
                        mysqli_data_seek($result_subjects, 0); // Сбрасываем указатель результата запроса на начало
                        while ($subject_row = mysqli_fetch_assoc($result_subjects)) {
                            echo "<option value='" . $subject_row['name'] . "'>" . $subject_row['name'] . "</option>";
                        }
                        echo "</select>";
                        echo "</td>";

                        // Выводим текстовое поле для выбора даты
                        echo "<td>";
                        echo "<input type='date' name='date' required>";
                        echo "</td>";

                        // Выводим форму для выбора оценки
                        echo "<td>";
                        echo "<input type='submit' name='grade' value='5' class='btn btn-primary'>";
                        echo "<input type='submit' name='grade' value='4' class='btn btn-primary'>";
                        echo "<input type='submit' name='grade' value='3' class='btn btn-primary'>";
                        echo "<input type='submit' name='grade' value='2' class='btn btn-primary'>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'blocks/footer.php'; // Подключаем файл footer.php ?>

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
</body>
</html>

