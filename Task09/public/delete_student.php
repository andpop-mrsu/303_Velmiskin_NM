<?php
$pdo = new PDO('sqlite:../data/students.db');
$student_id = $_GET['student_id'];

$query1 = "delete from students where id = {$student_id};";
$statement = $pdo->query($query1);
$rows = $statement->fetchAll();
$statement->closeCursor();

$query2 = "delete from session_results where student_id = {$student_id};";
$statement = $pdo->query($query2);
$rows = $statement->fetchAll();
$statement->closeCursor();

$query3 = "delete from admission where student_id = {$student_id};";
$statement = $pdo->query($query3);
$rows = $statement->fetchAll();
$statement->closeCursor();

$query4 = "delete from groups where student_id = {$student_id};";
$statement = $pdo->query($query4);
$rows = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<body align="center"><br><br>
<h2>Студент удален<h2><br>
        <form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
            <p><button style="width:200px"><h2>На начальную страницу</h2></button></p>
        </form>
</body>
</html>