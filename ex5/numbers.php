<?php

require_once 'connection.php';

$conn = getConnection();

//$stmt = $conn->prepare('insert into number (num) values(:num)');
//
//foreach (range(1, 100) as $s){
//    $num = rand(1, 100);
//    $stmt->bindValue(":num", $num);
//
//    $stmt->execute();
//}
//
$stmt = $conn->prepare('select num as my_number from number where num > :threshold');

$stmt->bindValue(":threshold", 80);
$stmt->execute();

foreach ($stmt as $row){
    var_dump($row[0]);
}

