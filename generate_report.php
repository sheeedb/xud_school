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

if (isset($_POST['month']) && isset($_POST['subject'])) {
    $selected_month = $_POST['month'];
    $selected_month_start = date('Y-m-01', strtotime($selected_month));
    $selected_month_end = date('Y-m-t', strtotime($selected_month));
    // Фильтруем воскресенья
    $sundays = [];
    $start = new DateTime($selected_month_start);
    $end = new DateTime($selected_month_end);
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end);
    foreach ($period as $dt) {
        if ($dt->format('N') == 7) { // Если это воскресенье
            $sundays[] = $dt->format('Y-m-d');
        }
    }

    // Получаем название выбранного предмета
    $selected_subject_id = $_POST['subject'];
    $query_subject = "SELECT name FROM subjects WHERE id = $selected_subject_id";
    $result_subject = mysqli_query($connect, $query_subject);
    $subject_name = mysqli_fetch_assoc($result_subject)['name'];

    // Получаем оценки за выбранный месяц и предмет
    $query_grades = "SELECT users.id, users.full_name, grades.grade, grades.date
                    FROM users
                    LEFT JOIN grades ON users.id = grades.student_id
                    WHERE users.roles_id = 1 
                    AND grades.date >= '$selected_month_start'
                    AND grades.date <= '$selected_month_end'
                    AND grades.subject_id = $selected_subject_id
                    ORDER BY users.full_name, grades.date";
    $result_grades = mysqli_query($connect, $query_grades);

    if (!$result_grades) {
        die("Ошибка запроса: " . mysqli_error($connect));
    }

    // Создаем новый объект Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Записываем заголовки
    $sheet->setCellValue('A1', 'ФИО ученика');
    $col = 2;
    $current_date = strtotime($selected_month);
    while (date('n', $current_date) == date('n', strtotime($selected_month))) {
        if (date('N', $current_date) != 7) { // Проверка на воскресенье
            $sheet->setCellValueByColumnAndRow($col, 1, date('d', $current_date));
            $col++;
        }
        $current_date = strtotime("+1 day", $current_date);
    }

    // Обновляем данные
    $current_student_id = null;
    $current_row = null;
    while ($row_data = mysqli_fetch_assoc($result_grades)) {
        // Пропускаем воскресенья
        if (in_array($row_data['date'], $sundays)) {
            continue;
        }
        if ($current_student_id != $row_data['id']) {
            // Переключаемся на нового студента
            $current_student_id = $row_data['id'];
            $current_row = $sheet->getHighestRow() + 1;
            $sheet->setCellValue('A' . $current_row, $row_data['full_name']);
        }
        // Находим соответствующий столбец для текущей даты
        $current_col = 2;
        $current_date = strtotime($selected_month_start);
        while (date('n', $current_date) == date('n', strtotime($selected_month))) {
            if (date('N', $current_date) != 7) { // Проверка на воскресенье
                if (date('Y-m-d', $current_date) == $row_data['date']) {
                    $sheet->setCellValueByColumnAndRow($current_col, $current_row, $row_data['grade']);
                }
                $current_col++;
            }
            $current_date = strtotime("+1 day", $current_date);
        }
    }

    // Сохраняем файл
    $writer = new Xlsx($spreadsheet);
    $filename = "report_" . date('Y_m', strtotime($selected_month)) . "_$subject_name.xlsx";
    $writer->save($filename);

    // Отправляем файл пользователю
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}
?>
