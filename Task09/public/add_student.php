<?php
$pdo = new PDO('sqlite:../data/students.db');

$ind = $pdo->prepare("select max(id) from students;");
$ind->execute();
$id_max = $ind->fetchColumn();
$id = $id_max+1;
$specialty_id = $_POST["group_num"][2];
$year = $_POST["group_num"][0];
$date_of_admission = (date("Y") - $year + 1)."-09-01";

$query1 = "insert into students(id, surname, name, patronymic, birthday, gender) values(:id, :surname, :name, :patronymic, :birthday, :gender);";
$ins1 = $pdo->prepare($query1);
$ins1->execute([
    ':id'=> $id,
    ':surname' => $_POST["surname"],
    ':name' => $_POST["name"],
    ':patronymic' => $_POST["patronymic"],
    ':birthday' => $_POST["birthday"],
    ':gender' => $_POST["gender"],
]);

$query2 = "insert into admission(student_id, specialty_id, date) values(:id, :specialty_id, :date);";
$ins2=$pdo->prepare($query2);
$ins2->execute([
    ':id'=> $id,
    ':specialty_id' => $specialty_id,
    ':date' => $date_of_admission,
]);

$sem = $pdo->prepare("select case when cast(strftime('%m', date('now')) as integer) >= 9 and cast(strftime('%m', date('now'))as integer) <= 12 then 1 else 2 end from admission where student_id={$id};");
$sem->execute();
$rez = $sem->fetchColumn();
$semester = $rez;

$query3 = "insert into groups(student_id, specialty_id, group_on_course, semester) values(:id, :specialty_id, :group_num, :semester);";
$ins3=$pdo->prepare($query3);
$ins3->execute([
    ':id'=> $id,
    ':specialty_id' => $specialty_id,
    ':group_num' => $_POST["group_num"],
    ':semester' => $semester,
]);
?>

<!DOCTYPE html>
<html lang="en">
<body align="center"><br><br>
<h2>Студент добавлен</h2><br>
        <form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
            <p><button style="width:200px"><h2>На начальную страницу</h2></button></p>
        </form>
        <form method="post" enctype="application/x-www-form-urlencoded" action="add_student_form.php">
            <p><button style="width:200px"><h2>Добавить еще</h2></button></p>
        </form>
</body>
</html>