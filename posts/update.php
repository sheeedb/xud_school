<?php
require_once '../connect.php';

$name = $_POST['name'];
$short_description = $_POST['short_description'];
$decription = $_POST['decription'];
$id = $_POST['id'];

mysqli_query($connect, "UPDATE `posts` SET `name` = '$name', `short_description` = '$short_description', `decription` = '$decription'  WHERE `posts`.`id` = '$id'");


header('Location: ../admin/face2.php');