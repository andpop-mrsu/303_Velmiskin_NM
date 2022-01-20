<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Добавление студента</title>
</head>

<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');
$query = "select group_num from all_groups;";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();
$groups = $rows;
$statement->closeCursor();
?>

<form action="index.php">
    <button type="submit" style="width:200px">Начальная страница</button>
</form>
<br>

<form method="post" action="add_student.php" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><h2>Информация о студенте</h2></legend>
        <h3>Группа:
            <select style="width: 200px;" name = "group_num">
                <?php foreach ($groups as $row) { ?>
                    <option value= <?= $row['group_num'] ?>>
                        <?= $row['group_num'] ?>
                    </option>
                <?php } ?>
            </select>
        </h3>
        <hr>
        <h3>Фамилия:
            <input required class = "text_input" type="text" name="surname" value=""><br>
        </h3>
        <hr>
        <h3>Имя:
            <input required class = "text_input" type="text" name="name" value=""><br>
        </h3>
        <hr>
        <h3>Отчество:
            <input required class = "text_input" type="text" name="patronymic" value=""><br>
        </h3>
        <hr>
        <h3>Пол:
            <input required class="radio_b" type="radio" name="gender" value="male"> Мужской
            <input required class="radio_b" type="radio" name="gender" value="female"> Женский
        </h3>
        <hr>
        <h3>Дата рождения:
            <input required class = "date_birth" type="date" name="birthday" value=""><br>
        </h3>
    </fieldset>
    <br>
    <button style="width:200px">Добавить</button>

</form>
</body>
</html>