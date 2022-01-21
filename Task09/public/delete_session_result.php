<?php
$pdo = new PDO('sqlite:../data/students.db');
$res_id = $_GET['res_id'];
$query = "delete from session_results where id = {$res_id};";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<body align="center"><br><br>
<h2>Результат удален</h2><br>
    <form method="post" enctype="application/x-www-form-urlencoded" action="index.php">
        <p><button style="width:200px"><h2>На начальную страницу</h2></button></p>
    </form>
</body>
</html>