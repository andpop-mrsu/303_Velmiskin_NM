<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Результаты сессии</title>
</head>

<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');
$student_id = $_GET['student_id'];
$query1 = "select session_results.id as res_id, subjects.subject, subjects.course, subjects.semester, subjects.type_of_certification, case when subjects.type_of_certification = 'экзамен' and session_results.point < 51 then 2 when subjects.type_of_certification = 'экзамен' and session_results.point >= 51 and session_results.point < 71 then 3 when subjects.type_of_certification = 'экзамен' and session_results.point >= 71 and session_results.point < 86 then 4 when subjects.type_of_certification = 'экзамен' and session_results.point >= 86 then 5 when subjects.type_of_certification = 'зачет' and session_results.point < 51 then 'незачет' else 'зачет' end as point from subjects join session_results on subjects.id = session_results.subject_id join students on students.id = session_results.student_id  where students.id = {$student_id} order by subjects.course, subjects.semester, subjects.type_of_certification, subjects.subject;";
$statement = $pdo->query($query1);
$rows = $statement->fetchAll();
$table = $rows;
$statement->closeCursor();

$query2 = "select id, surname, name, patronymic from students where id = {$student_id};";
$statement = $pdo->query($query2);
$rows = $statement->fetchAll();
$student = $rows;
$statement->closeCursor();
$student = $student[0]['id']." ".$student[0]['surname']." ".$student[0]['name']." ".$student[0]['patronymic'];
?>

<form action="index.php">
    <button type="submit" style="width:200px">Начальная страница</button>
</form>

<h1>Результаты сессий</h1>
<h3><?=$student?></h3>
<table class="students-table" cellpadding="10" cellspacing="0" border="1" width="100%" align="center">
    <tr class="table-header">
        <th>Дисциплина</th>
        <th>Курс</th>
        <th>Семестр</th>
        <th>Вид аттестации</th>
        <th>Балл</th>
        <th>Редактирование</th>
        <th>Удаление</th>
    </tr>
    <?php foreach ($table as $row): ?>
        <tr>
            <td><?= $row['subject'] ?></td>
            <td><?= $row['course'] ?></td>
            <td><?= $row['semester'] ?></td>
            <td><?= $row['type_of_certification'] ?></td>
            <td><?= $row['point'] ?></td>
            <td>
                <a href="edit_session_result_form.php?res_id=<?= $row['res_id'] ?>" style="color: black">Редактировать</a>
            </td>
            <td>
                <a href="delete_session_result.php?res_id=<?= $row['res_id'] ?>" style="color: black">Удалить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href = "add_session_result_form_student_and_course.php?student_id=<?= $student_id ?>" style="color: black"><h3>Добавить результат</h3></a>

</body>
</html>