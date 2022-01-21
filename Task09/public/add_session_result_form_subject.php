<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Добавить результат сессии</title>
</head>

<body>

<?php
$pdo = new PDO('sqlite:../data/students.db');

$query1 = "select groups.specialty_id from groups join students on students.id = groups.student_id where students.id = :id;";
$spec = $pdo->prepare($query1);
$spec->execute([
    ':id'=> $_POST["id"],
]);
$specialty = $spec->fetchColumn();

$query2 = "select subjects.id as s_id , subjects.subject from subjects join subject_specialty on subjects.id = subject_specialty.subject_id where subject_specialty.specialty_id = :specialty and subjects.course = :course and subjects.semester = :semester;";
$subjects = $pdo->prepare($query2);
$subjects->execute([
    ':specialty'=> $specialty,
    ':course' => $_POST["course"],
    ':semester' => $_POST["semester"],
]);

$query3 = "select id, surname, name from students where id = :id;";
$student = $pdo->prepare($query3);
$student->execute([
    ':id' => $_POST["id"],
]);
?>

<form action="index.php">
    <button type="submit" style="width:200px">Начальная страница</button>
</form><br>

<form method="post" action="add_session_result.php" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <h3>Студент:
            <select style="width: 200px;" name = "id">
                <?php foreach ($student as $row) { ?>
                    <option value= <?= $row['id']." ".$row['surname']." ".$row['name']  ?>>
                        <?= $row['id']." ".$row['surname']." ".$row['name']  ?>
                    </option>
                <?php } ?>
            </select>
        </h3>
        <hr>
        <h3>Дисциплина:
            <select style="width: 200px;" name = "s_id">
                <?php foreach ($subjects as $row) { ?>
                    <option value= <?= $row['s_id']." ".$row['subject'] ?>>
                        <?= $row['s_id']." ".$row['subject'] ?>
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
    <button style="width:100px">Добавить</button>

</form>
</body>
</html>