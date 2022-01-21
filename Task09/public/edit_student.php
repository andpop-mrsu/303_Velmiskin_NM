<?php
$pdo = new PDO('sqlite:../data/students.db');

$query1 = "update students set surname = :surname, name = :name, patronymic = :patronymic, gender = :gender, birthday = :birthday where id = :id;";
$ins1 = $pdo->prepare($query1);
$ins1->execute([
    ':surname' => $_POST["surname"],
    ':name' => $_POST["name"],
    ':patronymic' => $_POST["patronymic"],
    ':gender' => $_POST["gender"],
    ':birthday' => $_POST["birthday"],
    ':id' => $_POST["id"],
]);

$query2 = "update groups set group_on_course = :group_num where student_id = :id;";
$ins2 = $pdo->prepare($query2);
$ins2->execute([
    ':group_num' => $_POST["group_num"],
    ':id' => $_POST["id"],
]);
?>

<!DOCTYPE html>
<html lang="en">
<body align="center"><br><br>
<h2>Информация отредактирована<h2><br>
        <form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
            <p><button style="width:200px"><h2>На начальную страницу</h2></button></p>
        </form>
</body>
</html>