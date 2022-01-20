<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Студенты</title>
    <style>
        td{
            border: 1px solid;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
$pdo = new PDO('sqlite:students.db');
$query = "SELECT DISTINCT group_on_course FROM groups JOIN admission ON admission.student_id = groups.student_id WHERE CAST(round((julianday('now') - julianday(admission.date))/360 + 1) AS INTEGER) < 5;";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();
$groups = $rows;
$statement->closeCursor();
?>

<h2>Выберите группу</h2>
<form action="" method="POST">
    <label>
        <select style="width: 200px;" name="group_on_course">
            <option value="" selected>Все группы
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
        "SELECT groups.group_on_course, specialty.title, students.surname, students.name, students.patronymic, students.gender, students.birthday, students.id AS student_card  " .
        "FROM groups JOIN students ON groups.student_id = students.id join specialty ON groups.specialty_id = specialty.id " .
        "JOIN admission ON admission.student_id = students.id WHERE CAST(round((julianday('now') - julianday(admission.date))/360 + 1) AS INTEGER) < 5 " .
        "ORDER BY groups.group_on_course, students.surname;";
}
else {
    $query =
        "SELECT groups.group_on_course, specialty.title, students.surname, students.name, students.patronymic, students.gender, students.birthday, students.id AS student_card  " .
        "FROM groups JOIN students ON groups.student_id = students.id JOIN specialty ON groups.specialty_id = specialty.id " .
        "JOIN admission ON admission.student_id = students.id WHERE CAST(round((julianday('now') - julianday(admission.date))/360 + 1) AS INTEGER) < 5 AND groups.group_on_course = {$number} " .
        "ORDER BY groups.group_on_course, students.surname;";
}
$statement = $pdo->query($query);
$students = $statement->fetchAll();
?>

<h1>Студенты</h1>
<table>
    <tr>
        <th>group</th>
        <th>specialty</th>
        <th>surname</th>
        <th>name</th>
        <th>patronymic</th>
        <th>gender</th>
        <th>birthday</th>
        <th>student card</th>
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
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>