<?php
$pdo = new PDO('sqlite:../data/students.db');

$query = "insert into session_results(student_id, subject_id, point) values(:student_id, :subject_id, :point);";
$ins = $pdo->prepare($query);
$ins->execute([
    ':student_id'=> $_POST["id"],
    ':subject_id' => $_POST["s_id"],
    ':point' => $_POST["point"],
]);
?>

<!DOCTYPE html>
<html lang="en">
<body align="center"><br><br>
<h2>Результат сессии добавлен<h2><br>
        <form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
            <p><button style="width:200px"><h2>На начальную страницу</h2></button></p>
        </form>
</body>
</html>