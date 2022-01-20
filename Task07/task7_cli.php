<?php

$pdo = new PDO('sqlite:students.db');

echo "Группы, имеющиеся в базе:\n";
$query = "SELECT DISTINCT group_on_course FROM groups JOIN admission ON admission.student_id = groups.student_id WHERE CAST(round((julianday('now') - julianday(admission.date))/360 + 1) AS INTEGER) < 5;";
$statement = $pdo->query($query);
$rows = $statement->fetchAll();
foreach ($rows as $row) {echo $row['group_on_course'] . "  "; }
echo "\n";

$groups = $rows;
$statement->closeCursor();

$number = "";
while($number != "e"){
    echo "Введите номер группы или нажмите 'Enter' для получения информации по всем группам (для выхода из программы введите 'e'): ";
    $number = readline("\n");

    $flag = 0;
    foreach ($groups as $row) {
        if ($row['group_on_course'] == $number) {
            $flag = 1;
        }
    }
    if ($flag == 0 and $number == "") {
        $flag = 2;
    }
    if ($flag == 0 and $number == "e") {
        $flag = 3;
    }

    if ($flag == 1 or $flag == 2) {
        if ($flag == 1){
            $find_students =
                "SELECT groups.group_on_course, specialty.title, students.surname, students.name, students.patronymic, students.gender, students.birthday, students.id AS student_card  " .
                "FROM groups JOIN students ON groups.student_id = students.id JOIN specialty ON groups.specialty_id = specialty.id " .
                "JOIN admission ON admission.student_id = students.id WHERE CAST(round((julianday('now') - julianday(admission.date))/360 + 1) AS INTEGER) < 5 AND groups.group_on_course = {$number} " .
                "ORDER BY groups.group_on_course, students.surname;";
        }
        else{
            $find_students =
                "SELECT groups.group_on_course, specialty.title, students.surname, students.name, students.patronymic, students.gender, students.birthday, students.id AS student_card  " .
                "FROM groups JOIN students ON groups.student_id = students.id join specialty ON groups.specialty_id = specialty.id " .
                "JOIN admission ON admission.student_id = students.id WHERE CAST(round((julianday('now') - julianday(admission.date))/360 + 1) AS INTEGER) < 5 " .
                "ORDER BY groups.group_on_course, students.surname;";
        }

        $statement = $pdo->prepare($find_students);
        $statement->execute();
        $rows = $statement->fetchAll();

        $counter = 0;
        foreach($rows as $row){
            $v1 = sprintf(" %' -5s", $row['group_on_course']);
            $v2 = $row['title'];
            $v3 = $row['surname'];
            $v4 = $row['name'];
            $v5 = $row['patronymic'];
            $v6 = $row['gender'];
            $v7 = $row['birthday'];
            $v8 = $row['student_card'];
            echo $v1 . " - " . $v2 . " - " .  $v3 . " - " .  $v4 . " - " .  $v5 . " - " .  $v6 . " - " .  $v7 . " - " .  $v8;
            echo "\n";
        }
    }
    else if ($flag == 3) {
        echo "Выход из программы.\n";
    }
    else {
        echo "Номер группы введен некорректно.\n";
    }
}
?>