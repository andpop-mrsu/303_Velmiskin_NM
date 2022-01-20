<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Добавление результата сесии</title>
</head>

<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');

$course = array();
for($i = 1; $i <= $_POST['group_on_course'][0]; $i++ ) {
    array_push($course, $i);
}
$query = "select students.id, students.surname, students.name from students join groups on students.id = groups.student_id where groups.group_on_course = :number;";
$students = $pdo->prepare($query);
$students->execute([
    ':number'=> $_POST["group_on_course"],
]);
?>

<form action="index.php">
    <button type="submit" style="width:200px">Начальная страница</button>
</form><br>

<form method="post" action="add_session_result_form_subject.php" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <h3>Студент:
            <select style="width: 200px;" name = "id">
                <?php foreach ($students as $row) { ?>
                    <option value= <?= $row['id']." ".$row['surname']." ".$row['name'] ?>>
                        <?= $row['id']." ".$row['surname']." ".$row['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </h3>
        <hr>
        <h3>Курс:
            <select style="width: 200px;" name = "course">
                <?php foreach ($course as $row) { ?>
                    <option value= <?= $row ?>>
                        <?= $row?>
                    </option>
                <?php } ?>
            </select>
        </h3>
        <hr>
        <h3>Семестр:</h3>
        <input required class="radio_b" type="radio" name="semester" value="1"> 1
        <input required class="radio_b" type="radio" name="semester" value="2"> 2
    </fieldset>
    <br>
    <button style="width:100px">Выбрать</button>

</form>
</body>
</html>