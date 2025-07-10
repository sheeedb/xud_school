<?php
require_once '../connect.php';

// Получаем идентификатор записи из GET параметра
$result_id = $_GET['id'];

// Запрос для получения данных о расписании с названием предмета
$query_schedule = "SELECT schedule.*, subjects.name AS subject_name 
                   FROM `schedule` 
                   INNER JOIN subjects ON schedule.subject_id = subjects.id 
                   WHERE schedule.id='$result_id'";

$result = mysqli_query($connect, $query_schedule);

// Проверка наличия результата запроса
if (!$result) {
    die("Ошибка запроса: " . mysqli_error($connect));
}

$schedule_data = mysqli_fetch_assoc($result);

// Получаем список всех уроков, кроме текущего
$query_all_schedule = "SELECT * FROM `schedule` WHERE `id` != '$result_id'";
$result_all_schedule = mysqli_query($connect, $query_all_schedule);

if (!$result_all_schedule) {
    die("Ошибка запроса: " . mysqli_error($connect));
}

$all_schedules = [];
while ($row = mysqli_fetch_assoc($result_all_schedule)) {
    $all_schedules[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/rec.css">
    <title>Обновление данных</title>
    <script>
        // Функция для автоматического подставления времени окончания
        function setEndTime() {
            var startTime = document.getElementById("time_start").value;
            var startParts = startTime.split(":");
            var endMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]) + 45;
            var endHours = Math.floor(endMinutes / 60);
            var endMinutesRemainder = endMinutes % 60;
            var endHoursFormatted = endHours < 10 ? "0" + endHours : endHours;
            var endMinutesFormatted = endMinutesRemainder < 10 ? "0" + endMinutesRemainder : endMinutesRemainder;
            document.getElementById("time_end").value = endHoursFormatted + ":" + endMinutesFormatted;
        }

        // Функция для проверки выбранного времени начала
        function checkStartTime() {
            var startTime = document.getElementById("time_start").value;
            var startParts = startTime.split(":");
            var startHours = parseInt(startParts[0]);
            var endHours = startHours + 1;
            if (startHours >= 16) {
                document.getElementById("notification").innerHTML = "<div class='alert alert-danger'>Вы выбираете нерабочее время. Пожалуйста, выберите время с 08:00 до 15:00.</div>";
                document.getElementById("time_start").value = "";
                document.getElementById("time_end").value = "";
            } else {
                document.getElementById("notification").innerHTML = "";
            }
        }

        // Функция для проверки пересечения времени
        function checkTimeOverlap() {
            var startTime = document.getElementById("time_start").value;
            var endTime = document.getElementById("time_end").value;

            var allSchedules = <?php echo json_encode($all_schedules); ?>;

            var startNew = new Date("01/01/2000 " + startTime).getTime();
            var endNew = new Date("01/01/2000 " + endTime).getTime();

            for (var i = 0; i < allSchedules.length; i++) {
                var startExisting = new Date("01/01/2000 " + allSchedules[i]['time_start']).getTime();
                var endExisting = new Date("01/01/2000 " + allSchedules[i]['time_end']).getTime();

                if ((startNew >= startExisting && startNew < endExisting) ||
                    (endNew > startExisting && endNew <= endExisting)) {
                    document.getElementById("update_button").disabled = true;
                    return;
                }
            }

            document.getElementById("update_button").disabled = false;
        }
    </script>
</head>
<body>

<a href="face2.php">Главная</a>
<hr>

<h2>Обновить данные</h2>
<form action="../jjj/update2.php" method="post">
    <input type="hidden" name="id" value="<?= $schedule_data['id'] ?>">
    <p>Название предмета</p>
    <input type="text" name="subject_name" value="<?= $schedule_data['subject_name'] ?>" required>
    <p>Время начала</p>
    <input type="time" id="time_start" name="time_start" value="<?= $schedule_data['time_start'] ?>" onchange="setEndTime(); checkStartTime(); checkTimeOverlap()" required min="08:00" max="15:00">
    <input type="hidden" id="time_end" name="time_end" value="<?= $schedule_data['time_end'] ?>" required>
    <div id="notification"></div>
    <button id="update_button" class="btn btn-primary" type="submit">Обновить</button>
</form>
</body>
</html>
