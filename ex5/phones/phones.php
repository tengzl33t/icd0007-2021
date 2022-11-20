<?php

require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/Contact.php';

function getContacts() : array {
    $conn = getConnection();

    $stmt = $conn->prepare('SELECT id, name, number from contact c left join phone p on c.id = p.contact_id');

    $stmt->execute();

    $arr = [];
    foreach ($stmt as $row) {
        $number = $row['number'];

        if (isset($arr[$row['id']])){
            $c = $arr[$row['id']];

        }else{
            $c = new Contact($row['id'], $row['name']);
            $arr[$row['id']] = $c;
        }
        if ($number !== null){
            $c->addPhone($number);
        }
    }

    return array_values($arr);
}
print_r(getContacts());