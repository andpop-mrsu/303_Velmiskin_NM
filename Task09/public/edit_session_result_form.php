<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Редактирование результата сессии</title>
</head>

<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');
$res_id = $_GET['res_id'];
$query1 = "select session_results.id, subjects.subject from session_results join subjects on session_results.subject_id = subjects.id where session_results.id = {$res_id};";
$statement = $pdo->query($query1);
$rows = $statement->fetchAll();
$subjects = $rows;
$statement->closeCursor();
?>

<form action="index.php">
    <button type="submit" style="width:200px">Начальная страница</button>
</form>

<form method="post" action="edit_session_result.php" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <h3>Дисциплина:
            <select style="width: 200px;" name = "id">
                <?php foreach ($subjects as $row) { ?>
                    <option value= <?= $row['id']." ".$row['subject']  ?>>
                        <?= $row['id']." ".$row['subject']  ?>
                    </option>
                <?php } ?>
            </select>
        </h3>
        <hr>
        <h3>Балл:
            <input type="number" min="0" max="100" name="point" value=""><br>
        </h3>
    </fieldset>

    <br>
    <button style="width:200px">Редактировать</button>

</form>
</body>
</html>