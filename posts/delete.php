<?php
require_once '../connect.php';

$id = $_POST['id'];

mysqli_query($connect, "DELETE FROM `users` where id = '$id'");
header('Location: ../admin/workers2.php');
?>