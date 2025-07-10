<?php
require_once '../connect.php';

$id = $_POST['id'];
$subject_name = $_POST['subject_name'];
$time_start = $_POST['time_start'];
$time_end = $_POST['time_end'];
$today_date = $_POST['today_date']; // Добавлено поле для даты занятия

// Обновление данных в таблице schedule
$query_update_schedule = "UPDATE `schedule` SET `time_start` = '$time_start', `time_end` = '$time_end' WHERE `id` = '$id'";
mysqli_query($connect, $query_update_schedule);

// Обновление названия предмета в таблице subjects
$query_update_subject = "UPDATE `subjects` SET `name` = '$subject_name' WHERE `id` = (SELECT `subject_id` FROM `schedule` WHERE `id` = '$id')";
mysqli_query($connect, $query_update_subject);

// Перенаправление на страницу расписания после обновления
header('Location: ../admin/schedule2.php');
?>
