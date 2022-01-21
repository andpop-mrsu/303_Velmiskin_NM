<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Студенты</title>
</head>
<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');
$query = "select distinct group_on_course from groups join admission on admission.student_id = groups.student_id where cast(round((julianday('now') - julianday(admission.date))/360 + 1) as integer) < 5;";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();
$groups = $rows;
$statement->closeCursor();
?>

<form action="" method="POST">
    <label>
        <select style="width:200px;" name="group_on_course">
            <option value="" disabled selected>Все группы
            </option>
            <?php foreach ($groups as $row) { ?>
                <option value= <?= $row['group_on_course'] ?>>
                    <?= $row['group_on_course'] ?>
                </option>
            <?php } ?>
        </select>
    </label>
    <button type="submit">Выбрать</button>
</form>

<?php
$number = 0;
if(isset($_POST['group_on_course'])){
    $number = (int)$_POST['group_on_course'];
}
$students = null;

if($number == 0) {
    $query =
        "select groups.group_on_course, specialty.title, students.surname, students.name, students.patronymic, case when students.gender == 'male' then 'мужской' else 'женский' end as gender, students.birthday, students.id as student_card  " .
        "from groups join students on groups.student_id = students.id join specialty on  groups.specialty_id = specialty.id " .
        "join admission on admission.student_id = students.id where cast(round((julianday('now') - julianday(admission.date))/360 + 1) as integer) < 5 " .
        "order by groups.group_on_course, students.surname;";
}
else {
    $query =
        "select groups.group_on_course, specialty.title, students.surname, students.name, students.patronymic, case when students.gender == 'male' then 'мужской' else 'женский' end as gender, students.birthday, students.id as student_card  " .
        "from groups join students on groups.student_id = students.id join specialty on  groups.specialty_id = specialty.id " .
        "join admission on admission.student_id = students.id where cast(round((julianday('now') - julianday(admission.date))/360 + 1) as integer) < 5 and groups.group_on_course = {$number} " .
        "order by groups.group_on_course, students.surname;";
}
$statement = $pdo->query($query);
$students = $statement->fetchAll();
?>

<h1>Студенты</h1>
<table class="students-table" cellpadding="10" cellspacing="0" border="1" width="100%" align="center">
    <tr class="table-header">
        <th>Группа</th>
        <th>Направление</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Пол</th>
        <th>Дата рождения</th>
        <th>Номер студенческого билета</th>
        <th>Редактирование</th>
        <th>Удаление</th>
        <th>Результаты экзаменов</th>
    </tr>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['group_on_course'] ?></td>
            <td><?= $student['title'] ?></td>
            <td><?= $student['surname'] ?></td>
            <td><?= $student['name'] ?></td>
            <td><?= $student['patronymic'] ?></td>
            <td><?= $student['gender'] ?></td>
            <td><?= $student['birthday'] ?></td>
            <td><?= $student['student_card'] ?></td>
            <td>
                <a href="edit_student_form.php?student_id=<?= $student['student_card'] ?>" style="color: black">Редактировать</a>
            </td>
            <td>
                <a href="delete_student.php?student_id=<?= $student['student_card'] ?>" style="color: black">Удалить</a>
            </td>
            <td>
                <a href="session_results.php?student_id=<?= $student['student_card'] ?>" style="color: black">Результаты экзаменов</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<br>
<a href="add_student_form.php" style="color: black"><h3>Добавить студента</h3></a>

</body>
</html>