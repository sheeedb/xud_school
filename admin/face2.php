<?php
session_start();
require_once '../connect.php';
$result = mysqli_query($connect , "SELECT id, name, short_description, decription FROM `posts`");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Администрирование</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php if(!empty($_SESSION['users']['full_name'])):?>
    <?php require "../blocks/admin_header.php" ?>

    <div  class="container mt-5">
        <table  width="1000" class="sold">
            <thead>
            <tr class="td-u">
                <th>№</th>
                <th>Название</th>
                <th>Краткое описание</th>
                <th>Описание</th>
                <th class="td-u2">&#9998;</th>

            </tr>
            </thead>
            <tbody>

            <?php
            while ($char = mysqli_fetch_assoc($result)) {
                ?>
                
                <tr class="td-o">
                
                    <td><?= isset($char['id']) ? $char['id'] : "" ?></td>
                    <td><?= isset($char['name']) ? $char['name'] : "" ?></td>
                    <td><?= isset($char['short_description']) ? $char['short_description'] : "" ?></td>
                    <td><?= isset($char['decription']) ? explode('.', $char['decription'])[0] : "" ?></td> <!-- Выводим только первое предложение -->
                    
                    <td><a href="update.php?id=<?= isset($char['id']) ? $char['id'] : "" ?>">Редактировать</a></td>

                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>
    </div>
    
    <?php require "../blocks/footer.php" ?>
<?php else:
    echo '<h3 class="p-2 text-dark text-decoration-none">Отказано</h3>';
    echo '<a href="/" class="btn btn-primary" >На главную</a>';
    ?>

<?php endif ?>

</body>
</html>
