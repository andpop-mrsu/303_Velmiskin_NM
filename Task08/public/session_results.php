<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Результаты сессии</title>
</head>

<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');
$query1 = "select distinct group_on_course from groups join admission on admission.student_id = groups.student_id where cast(round((julianday('now') - julianday(admission.date))/360 + 1) as integer) < 5;";
$statement = $pdo->query($query1);
$rows = $statement->fetchAll();
$groups = $rows;
$statement->closeCursor();
?>

<form action="index.php">
    <button type="submit" style="width:200px">Начальная страница</button>
</form><br>

<form method="post" action="<?php $_PHP_SELF ?>" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><h3>Выберите группу</h3></legend>
        <h4>Группа:
            <select style="width: 200px;" name = "group_on_course">
                <?php foreach ($groups as $row) { ?>
                    <option value= <?= $row['group_on_course'] ?>>
                        <?= $row['group_on_course'] ?>
                    </option>
                <?php } ?>
            </select>
        </h4>
    </fieldset>
    <br>
    <button style="width:100px">Выбрать</button>
</form>

<?php
$number = 0;
if(isset($_POST['group_on_course'])){
    $number = (int)$_POST['group_on_course'];
}

if($number != 0) {
    $query2 = "select students.id, students.surname, students.name from students join groups on students.id = groups.student_id where groups.group_on_course = {$number};";
    $statement = $pdo->query($query2);
    $rows = $statement->fetchAll();
    $students = $rows;
    $statement->closeCursor();
    ?>

    <form method="post" action="<?php $_PHP_SELF ?>" enctype="application/x-www-form-urlencoded">
        <fieldset>
            <legend><h3>Выберите студента</h3></legend>
            <h4>Студент:
                <select style="width: 200px;" name = "id">
                    <?php foreach ($students as $row) { ?>
                        <option value= <?= $row['id']." ".$row['surname']." ".$row['name'] ?>>
                            <?= $row['id']." ".$row['surname']." ".$row['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </h4>
        </fieldset>
        <br>
        <button style="width:100px">Выбрать</button>
    </form>

    <?php
}

$student = 0;
if(isset($_POST['id'])){
    $student = (int)$_POST['id'];
}

if($student != 0) {
    $query = "select subjects.subject, subjects.course, subjects.semester, subjects.type_of_certification, case when subjects.type_of_certification = 'экзамен' and session_results.point < 51 then 2 when subjects.type_of_certification = 'экзамен' and session_results.point >= 51 and session_results.point < 71 then 3 when subjects.type_of_certification = 'экзамен' and session_results.point >= 71 and session_results.point < 86 then 4 when subjects.type_of_certification = 'экзамен' and session_results.point >= 86 then 5 when subjects.type_of_certification = 'зачет' and session_results.point < 51 then 'незачет' else 'зачет' end as point from subjects join session_results on subjects.id = session_results.subject_id join students on students.id = session_results.student_id  where students.id = {$student} order by subjects.course, subjects.semester, subjects.type_of_certification, subjects.subject;";
    $statement = $pdo->query($query);
    $rows = $statement->fetchAll();
    $table = $rows;
    $statement->closeCursor();
    ?>

    <h1>Результаты сессий</h1>
    <table class="students-table" cellpadding="10" cellspacing="0" border="1" width="100%" align="center">
        <tr class="table-header">
            <th>Дисциплина</th>
            <th>Курс</th>
            <th>Семестр</th>
            <th>Вид аттестации</th>
            <th>Оценка</th>
        </tr>
        <?php foreach ($table as $row): ?>
            <tr>
                <td><?= $row['subject'] ?></td>
                <td><?= $row['course'] ?></td>
                <td><?= $row['semester'] ?></td>
                <td><?= $row['type_of_certification'] ?></td>
                <td><?= $row['point'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
}
?>

</body>
</html>