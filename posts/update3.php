<?php
require_once '../connect.php';

$full_name = $_POST['full_name'];
$login = $_POST['login'];
$password= $_POST['password'];
$phone = $_POST['phone'];
$roles_id = $_POST['roles_id'];
$id = $_POST['id'];

mysqli_query($connect, "UPDATE `users` SET `full_name` = '$full_name' where users.id = '$id'");
mysqli_query($connect, "UPDATE `users` SET `login` = '$login' where users.id = '$id'");
mysqli_query($connect, "UPDATE `users` SET `password` = '$password' where users.id = '$id'");
mysqli_query($connect, "UPDATE `users` SET `phone` = '$phone' where users.id = '$id'");
mysqli_query($connect, "UPDATE `users` SET `roles_id` = '$roles_id' where users.id = '$id'");

header('Location: ../admin/workers2.php');
?>